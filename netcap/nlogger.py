#!/usr/bin/env python

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime



def dlist2db ():    
    
    global  dlist, cnx

    #dlist[0] string to datetime part and minus part 
    ptime = str(dlist[0])
    ptimelist = ptime.split(".")
    struct_time = time.strptime(ptimelist[0], "%b %d, %Y %H:%M:%S")
    
    #prepare insert sql statement
    insert_vst_sql="INSERT INTO actvst SET \
    pkttime = " + "'" + time.strftime("%Y-%m-%d %X", struct_time)  + "'," +\
    "timefrac = " + "'0." + str(ptimelist[1])  + "'," +\
    "srcmac = '" + str(dlist[1]) + "'," +\
    "srcip = '" + str(dlist[2]) + "'," + \
    "destip = '" + str(dlist[3]) + "'," +\
    "url = '" + str(dlist[4]) + "'," +\
    "rectime = '" + str(datetime.datetime.now()) +"'"
    
    #print(insert_vst_sql)
    try:
        cursor = cnx.cursor()
        cursor.execute(insert_vst_sql)
        cnx.commit()
            
    except MySQLdb.Error as err:
        print("insert record 'wlpkt' failed.")
        print("Error: {}".format(err.args[1])) 
    finally:
        cursor.close()

def updatesitelist(cnx):
    #update visit recording rules site by site, include default settings
    #"identical" visiting record is recorded once in the given time period
    global sitelist,  DEFLEN,  DEFTIME
    #example ((7L, '0001.0000.0000', 'www.baidu.com', 0L, 0L, 1))
    #turple in turple
    sitelist = []
    
    select_vrf_sql="SELECT id, level, dname, mlen, ltime FROM actvrf WHERE active = 1 order by type, level, dname"
    
    try:
        cursor = cnx.cursor()
        cursor.execute(select_vrf_sql)
        cnx.commit()
        sitelist = cursor.fetchall()
    except MySQLdb.Error as err:
        print("select 'actvrf' failed.")
        print("Error: {}".format(err.args[1])) 
    finally:
        cursor.close()
        
    for i in range(len(sitelist)-1, -1, -1):
        if sitelist[i][1]=="9999.9999.9999":
            # default settings for "identical" visiting record
            DEFLEN = int(sitelist[i][3])
            DEFTIME = int(sitelist[i][4])
            break

def updatefilter():
    #filter list for recording visits
    global filterlist
    #print filterlist
    for i in range(len(filterlist)-1, -1, -1):
        #prepare filter list [id, url, basetime, ltime], global , dynamic in memory
        btime = filterlist[i][2]
        #print(abs(datetime.datetime.now()-btime).seconds)
        #print(int(filterlist[i][3]))
        #print((abs(datetime.datetime.now()-btime).seconds) > int(filterlist[i][3]))
        if (abs(datetime.datetime.now()-btime).seconds) > int(filterlist[i][3]) : 
            del filterlist[i]
    #print filterlist


if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("configact.xml")
    for node in dom.getElementsByTagName("interface"):
        pktpipe = node.getAttribute("pktpipe")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    
    for node in dom.getElementsByTagName("netlog"):
        CSITE = int(node.getAttribute("csite"))
        CFILTER = int(node.getAttribute("cfilter"))
        MAXTIMEDIFF = int(node.getAttribute("maxtimediff"))
        
    
    try:
        pktsrc = open(pktpipe, 'r',  buffering= 1)
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening pktsrc")
        sys.exit(0)
        
    # connection for  mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db)
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    

    sitelist = [] # container for sites from database. sites have different recording match length and time space 
    #prepare filter list [id, url, basetime, ltime], global , dynamic in memory
    filterlist=[""]
    filterlist.pop()
    #initial values for default sites visites recording. will be updated in updatesitelist() function
    DEFLEN = 20 # length of url match for default sites
    DEFTIME = 120 # filter item alive time for default sites
    
    updatesitelist(cnx)
    
    chksite = CSITE
    chkfilter = CFILTER     
    
    # "Jul 26, 2014 09:03:29.017913000","b8:27:eb:e9:4c:4b","172.16.0.101","202.108.23.29",
    # "Jul 26, 2014 09:03:29.021558000","00:87:34:19:02:d3","172.16.0.101","202.108.23.29","http://pan.baidu.com/res/static/thirdparty/connect.jpg?t=1406336601"
    dlist=[""]*5
    
    try:
        while True:    
            #count down to refresh filter and keyword
            #chksite = chksite -1
            #chkfilter = chkfilter -1
            #print "loop"
            try:
                line = ""
                while len(line) == 0 :
                    #read line from pipe, untile len(line) > 0.  hold here when a broken pipe occurs (wlcap not running)
                    line = pktsrc.readline()[:-1]
                    #print "line here---------"
                    #print line
                    #
                #parse line for url
                # "Jul 26, 2014 09:03:29.017913000","b8:27:eb:e9:4c:4b","172.16.0.101","202.108.23.29",
                # "Jul 26, 2014 09:03:29.021558000","00:87:34:19:02:d3","172.16.0.101","202.108.23.29","http://pan.baidu.com/res/static/thirdparty/connect.jpg?t=1406336601"
                
                # replace ,, to ,   --double comma to single
                linstr = line.replace(",,", ",")
                #find a character as spliter 
                for s in (":", "^", "~", "%", "`", "!", "@", "#","$","*","(",")","-","="):
                    r = linstr.find(s)
                    if r < 0: break
                
                linstr = linstr.replace("\",\"", s) # set splitter
                linstr = linstr.replace("\"", "") # leading and tailing "
                linstr = linstr.replace("\'", "")  #to avoid sql statement error
        
                # split to list
                dlist=linstr.split(s)
                # dlist example 0-frametime 1-srcmac 2-srcip 3-destip 4-url
                #(Jul 26, 2014 09:03:29.021558000,00:87:34:19:02:d3,172.16.0.101,202.108.23.29,http://pan.baidu.com/res/static/thirdparty/connect.jpg?t=1406336601)
                
                if len(dlist) >= 5 : #line with url
                    #dlist[0] string to datetime part and minus part 
                    ptime = str(dlist[0])
                    ptimelist = ptime.split(".")  #type of ptimelist[0] is string  "%b %d, %Y %H:%M:%S"
                    
                    chkpkttime = datetime.datetime.now()
                    try:
                        chkpkttime = datetime.datetime.strptime(ptimelist[0], "%b %d, %Y %H:%M:%S")
                    except Exception as e:
                        print str(e)
                        traceback.print_exc()
                        
                    if abs(abs(datetime.datetime.now()-chkpkttime).seconds) <= MAXTIMEDIFF : 
                        # check filter list
                        matchlen = DEFLEN
                        matchtime = DEFTIME
                        url = dlist[4]
                        for i in range(len(sitelist)):
                            #sitelist example ((7L, '0001.0000.0000', 'www.baidu.com', 0L, 0L, 1))
                            #turple in turple
                            # dlist example 0-frametime 1-srcmac 2-srcip 3-destip 4-url
                            #(Jul 26, 2014 09:03:29.021558000,00:87:34:19:02:d3,172.16.0.101,202.108.23.29,http://pan.baidu.com/res/static/thirdparty/connect.jpg?t=1406336601)
                            slist=sitelist[i]
                            if slist[2] in url and slist[2] != "":  # defined sites in wlvrf
                                matchlen = int(slist[3])
                                matchtime = int(slist[4])
                                break
                        if matchlen != 0 :
                            suburl = url[0:matchlen] + " | "  + dlist[1] + " | "  + dlist[2]
                            infilter = 0
                            for fitem in filterlist:
                                #check filter list [id, url+, basetime, ltime], global
                                if suburl == fitem[1]:
                                    infilter = 1
                                    break
                            if infilter == 0:
                                dlist2db()
                                filterlist.append(["", suburl,datetime.datetime.now(),matchtime])
                                #count down to refresh filter and keyword
                                chksite = chksite -1
                                chkfilter = chkfilter -1
  
                        else :
                            dlist2db()
                            filterlist.append(["", suburl,datetime.datetime.now(),matchtime])
                            #count down to refresh filter and keyword    
                            chksite = chksite -1 
                            chkfilter = chkfilter -1 
    
                
                # update site lists from mysql wlvrf
                if chksite < 0:
                    #print "update site--- "
                    updatesitelist(cnx)
                    chksite = CSITE
                    
                # update filterlist in memory
                if chkfilter < 0:
                    #print "update -filter--- "
                    updatefilter()
                    chkfilter = CFILTER
                
            except Exception as e:
                print str(e)
                traceback.print_exc()
                cnx.close()
                sys.exit(0)
                
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()

