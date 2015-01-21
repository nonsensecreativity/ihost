#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import subprocess
#import gammu
import requests, json
#from xml.etree.ElementTree import ElementTree, dump


if __name__ == '__main__':

    reload(sys)
    sys.setdefaultencoding('utf-8')
    
    #wait for mysql server is ready 
    time.sleep(45)

    #read configurations here

    dom = minidom.parse("wlspupload.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    for node in dom.getElementsByTagName("table1"):
        tbl1 = node.getAttribute("tblname")
        url1 = node.getAttribute("uri")
        #netid1 = node.getAttribute("netid")
        tzone1 = node.getAttribute("tzone")
        interv1 = node.getAttribute("interv")
        start1 = node.getAttribute("start")
    for node in dom.getElementsByTagName("table2"):
        tbl2 = node.getAttribute("tblname")
        url2 = node.getAttribute("uri")
        #netid2 = node.getAttribute("netid")
        tzone2 = node.getAttribute("tzone")
        interv2 = node.getAttribute("interv")
        start2 = node.getAttribute("start")
    for node in dom.getElementsByTagName("table3"):
        tbl3 = node.getAttribute("tblname")
        url3 = node.getAttribute("uri")
        #netid3 = node.getAttribute("netid")
        tzone3 = node.getAttribute("tzone")
        interv3 = node.getAttribute("interv")
        start3 = node.getAttribute("start")
    for node in dom.getElementsByTagName("table4"):
        tbl4 = node.getAttribute("tblname")
        url4 = node.getAttribute("uri")
        #netid4 = node.getAttribute("netid")
        tzone4 = node.getAttribute("tzone")
        interv4 = node.getAttribute("interv")
        start4 = node.getAttribute("start")   
    for node in dom.getElementsByTagName("table5"):
        tbl5 = node.getAttribute("tblname")
        url5 = node.getAttribute("uri")
        #netid5 = node.getAttribute("netid")
        tzone5 = node.getAttribute("tzone")
        interv5 = node.getAttribute("interv")
        start5 = node.getAttribute("start")
    for node in dom.getElementsByTagName("table6"):
        tbl6 = node.getAttribute("tblname")
        url6 = node.getAttribute("uri")
        #netid6 = node.getAttribute("netid")
        tzone6 = node.getAttribute("tzone")
        interv6 = node.getAttribute("interv")
        start6 = node.getAttribute("start")   

    # connection for  mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset='utf8')
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
  
    timeinterval = 10 # inner loop interval i

    try:
        #for k in range(1, 60, timeinterval): # for loop 4 times erery minutes
        while True: # while loop
            print "loop "
            dom = minidom.parse("wlspupload.xml")
            for node in dom.getElementsByTagName("table1"):
                start1 = node.getAttribute("start")
            try:
                #check 
                int(start1)
            except ValueError:
                start1 = '0'
                
            for node in dom.getElementsByTagName("table2"):
                start2 = node.getAttribute("start")
            try:
                #check 
                int(start2)
            except ValueError:
                start2 = '0'
                
            for node in dom.getElementsByTagName("table3"):
                start3 = node.getAttribute("start")
            try:
                #check 
                int(start3)
            except ValueError:
                start3 = '0'
                
            for node in dom.getElementsByTagName("table4"):
                start4 = node.getAttribute("start")
            try:
                #check 
                int(start4)
            except ValueError:
                start4 = '0'
                
            for node in dom.getElementsByTagName("table5"):
                start5 = node.getAttribute("start")
            try:
                #check 
                int(start5)
            except ValueError:
                start5 = '0'
                
            for node in dom.getElementsByTagName("table6"):
                start6 = node.getAttribute("start")
            try:
                #check 
                int(start6)
            except ValueError:
                start6 = '0'

            #prepare end time
            str_sql = "select id "
            str_sql = str_sql + " from " + tbl1
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end1 = ""
                for (idlist) in cursor:
                    end1 = str(idlist[0])
                try:
                    int(end1)
                    #print end1
                except ValueError:
                    end1 = '0'
            except MySQLdb.Error as err:
                end1 = '0'
            finally:
                cursor.close()     
            if int(end1) > 0 : end1 = str(int(end1)+1)
            
            #for database rebuild
            if int(start1) > int(end1):
                start1 = '0'

            str_sql = "select id "
            str_sql = str_sql + " from " + tbl2
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end2 = ""
                for (idlist) in cursor:
                    end2 = str(idlist[0])
                try:
                    int(end2)
                    #print end2
                except ValueError:
                    end2 = '0'
            except MySQLdb.Error as err:
                end2 = '0'
            finally:
                cursor.close()     
            if int(end2) > 0 : end2 = str(int(end2)+1)
            
            #for database rebuild
            if int(start2) > int(end2):
                start2 = '0'

            str_sql = "select id "
            str_sql = str_sql + " from " + tbl3
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end3 = ""
                for (idlist) in cursor:
                    end3 = str(idlist[0])
                try:
                    int(end3)
                    #print end3
                except ValueError:
                    end3 = '0'
            except MySQLdb.Error as err:
                end3 = '0'
            finally:
                cursor.close()     
            if int(end3) > 0 : end3 = str(int(end3)+1)
            
            #for database rebuild
            if int(start3) > int(end3):
                start3 = '0'

            str_sql = "select id "
            str_sql = str_sql + " from " + tbl4
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end4 = ""
                for (idlist) in cursor:
                    end4 = str(idlist[0])
                try:
                    int(end4)
                    #print end4
                except ValueError:
                    end4 = '0'
            except MySQLdb.Error as err:
                end4 = '0'
            finally:
                cursor.close()     
            if int(end4) > 0 : end4 = str(int(end4)+1)
            
            #for database rebuild
            if int(start4) > int(end4):
                start4 = '0'

            str_sql = "select id "
            str_sql = str_sql + " from " + tbl5
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end5 = ""
                for (idlist) in cursor:
                    end5 = str(idlist[0])
                try:
                    int(end5)
                    #print end5
                except ValueError:
                    end5 = '0'
            except MySQLdb.Error as err:
                end5 = '0'
            finally:
                cursor.close()     
            if int(end5) > 0 : end5 = str(int(end5)+1)
            
            #for database rebuild
            if int(start5) > int(end5):
                start5 = '0'

            str_sql = "select id "
            str_sql = str_sql + " from " + tbl6
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end6 = ""
                for (idlist) in cursor:
                    end6 = str(idlist[0])
                try:
                    int(end6)
                    #print end6
                except ValueError:
                    end6 = '0'
            except MySQLdb.Error as err:
                end6 = '0'
            finally:
                cursor.close()     
            if int(end6) > 0 : end6 = str(int(end6)+1)
            
            #for database rebuild
            if int(start6) > int(end6):
                start6 = '0'

            #write end values to xml
            for node in dom.getElementsByTagName("table1"):
                node.setAttribute("start", end1) 
            for node in dom.getElementsByTagName("table2"):
                node.setAttribute("start", end2) 
            for node in dom.getElementsByTagName("table3"):
                node.setAttribute("start", end3) 
            for node in dom.getElementsByTagName("table4"):
                node.setAttribute("start", end4) 
            for node in dom.getElementsByTagName("table5"):
                node.setAttribute("start", end5) 
            for node in dom.getElementsByTagName("table6"):
                node.setAttribute("start", end6) 

            tmp_config = "wlspupload.xml"
            f = open(tmp_config, 'w')
            dom.writexml( f )
            f.close()

            # scriptname & macaddress
            progid = os.path.basename(__file__)
            macaddr = open('/sys/class/net/eth0/address').read()[0:17]
            # netid
            netid = ''
            with open("/etc/hostapd/hostapd.conf") as fin:
                for line in fin:
                    if 'ssid=' in line:
                        #print line
                        netid = line.split('=')[1]
                        netid = netid.replace('\n', '')
                        netid = netid.replace('\r', '')
                        #print netid
                        break

            #prepare authclient list
            str_sql = "select id,cid,ctype,stat,phone,sphone,msg,plan,mac,optflag,srcip,rectime "
            str_sql = str_sql + " from " + tbl1
            str_sql = str_sql + " where  (id >= '" + start1 +"'"
            str_sql = str_sql + " and  id < '" + end1 +"')"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"cid":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') )  + ','
                    payload = payload + '"ctype":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') ) + ','
                    payload = payload + '"stat":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"phone":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"sphone":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"msg":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"plan":'+ ('null' if datarow[7] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"question":' + 'null' + ','
                    payload = payload + '"answer":' + 'null' + ','
                    payload = payload + '"token":' + 'null' + ','
                    payload = payload + '"mac":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]) +'"') ) + ','
                    payload = payload + '"img":' + 'null' + ','
                    payload = payload + '"imgchk1":' + 'null' + ','
                    payload = payload + '"imgchk2":' + 'null' + ','
                    payload = payload + '"imgchk3":' + 'null' + ','
                    payload = payload + '"manstat":' + 'null' + ','
                    payload = payload + '"manchker":' + 'null' + ','
                    payload = payload + '"manid":' + 'null' + ','
                    payload = payload + '"mantype":' + 'null' + ','
                    payload = payload + '"mantime":' + 'null' + ','
                    payload = payload + '"optflag":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]) +'"') ) + ','
                    payload = payload + '"srcip":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]) +'"') ) + ','
                    payload = payload + '"srcname":' + 'null' + ','
                    payload = payload + '"rectime":' + 'null' + ','
                    #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    #payload = payload + '"optime":' + 'null' + ','
                    payload = payload + '"optime":' + ('null' if datarow[11] == None else ('"' + str(datarow[11]).replace(' ','T') + str(tzone1) +'"') ) + ''
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url1, data=payload, headers=headers)
                        print response
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'authclient' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare authmac list
            str_sql = "select id,mac,ip,stat,cid,phone,base,srcip,rectime "
            str_sql = str_sql + " from " + tbl2
            str_sql = str_sql + " where  (id >= '" + start2 +"'"
            str_sql = str_sql + " and  id < '" + end2 +"')"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"mac":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"ip":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"stat":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"fromtime":'  + 'null' + ','
                    payload = payload + '"lasting":'  + 'null' + ','
                    payload = payload + '"pushflag":'  + 'null' + ','
                    payload = payload + '"pushurl":'  + 'null' + ','
                    payload = payload + '"pushtime":'  + 'null' + ','
                    payload = payload + '"cid":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"phone":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"token":' + 'null' + ','
                    payload = payload + '"base":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"srcip":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"srcname":' + 'null' + ','
                    payload = payload + '"rectime":' + 'null' + ','
                    #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    #payload = payload + '"optime":' + 'null' + ','
                    payload = payload + '"optime":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]).replace(' ','T') + str(tzone2) +'"') ) + ''
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url2, data=payload, headers=headers)
                        print response
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'authmac' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare authmacip list
            str_sql = "select id,mac,ip,called,srcip,orgurl,userurl,rectime "
            str_sql = str_sql + " from " + tbl3
            str_sql = str_sql + " where  (id >= '" + start3 +"'"
            str_sql = str_sql + " and  id < '" + end3 +"')"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"mac":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"ip":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"called":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"srcip":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"procid":' + 'null' + ','
                    payload = payload + '"orgurl":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"userurl":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"token":' + 'null' + ','
                    payload = payload + '"rectime":' + 'null' + ','
                    #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    #payload = payload + '"optime":' + 'null' + ','
                    payload = payload + '"optime":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]).replace(' ','T') + str(tzone3) +'"') ) + ''
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url3, data=payload, headers=headers)
                        print response
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'authmacip' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare actvst list
            str_sql = "select id,pkttime,timefrac,srcmac,srcip,destip,url,rectime "
            str_sql = str_sql + " from " + tbl4
            str_sql = str_sql + " where  (id >= '" + start4 +"'"
            str_sql = str_sql + " and  id < '" + end4 +"')"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"pkttime":'  + ('null' if datarow[1] == None else ('"' + str(datarow[1]).replace(' ','T') + str(tzone4) +'"') ) + ','
                    payload = payload + '"timefrac":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"srcmac":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"srcip":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"destip":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"url":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"rectime":' + 'null' + ','
                    #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    #payload = payload + '"optime":' + 'null' + ','
                    payload = payload + '"optime":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]).replace(' ','T') + str(tzone4) +'"') ) + ''
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url4, data=payload, headers=headers)
                        print response
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'actvst' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare wlact list
            str_sql = "select id,event,mac,subevent,oldvalue,newvalue,\
            firstseen,lastseen,stat,ssid,action,tcount,srcip,rectime "
            str_sql = str_sql + " from " + tbl5
            str_sql = str_sql + " where  (id >= '" + start5 +"'"
            str_sql = str_sql + " and  id < '" + end5 +"')"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"event":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"mac":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"subevent":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"oldvalue":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"newvalue":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"firstseen":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]).replace(' ','T') + str(tzone5) +'"') ) + ','
                    payload = payload + '"lastseen":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]).replace(' ','T') + str(tzone5) +'"') ) + ','
                    payload = payload + '"stat":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]) +'"') ) + ','
                    payload = payload + '"ssid":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]) +'"') ) + ','
                    payload = payload + '"action":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]) +'"') ) + ','
                    payload = payload + '"tcount":' + ('null' if datarow[11] == None else ('"' + str(datarow[11]) +'"') ) + ','
                    payload = payload + '"srcip":' + ('null' if datarow[12] == None else ('"' + str(datarow[12]) +'"') ) + ','
                    payload = payload + '"rectime":' + 'null' + ','
                    #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    #payload = payload + '"optime":' + 'null' + ','
                    payload = payload + '"optime":' + ('null' if datarow[13] == None else ('"' + str(datarow[13]).replace(' ','T') + str(tzone5) +'"') ) + ''
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url5, data=payload, headers=headers)
                        print response
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'wlact' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare wlsta list
            bigrssi = '-75'
            str_sql = "select id,tcount,mac,ssid,rssi,stat,setby,keepalive,\
            firstseen,lastseen,npacket,action,srcip,rectime "
            str_sql = str_sql + " from " + tbl6
            str_sql = str_sql + " where  rssi >= '" + bigrssi +"'"
            #str_sql = str_sql + " where  (id >= '" + start6 +"'"
            #str_sql = str_sql + " and  id < '" + end6 +"')"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"tcount":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"mac":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"ssid":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"rssi":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"stat":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"setby":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"keepalive":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"firstseen":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]).replace(' ','T') + str(tzone6) +'"') ) + ','
                    payload = payload + '"lastseen":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]).replace(' ','T') + str(tzone6) +'"') ) + ','
                    payload = payload + '"rtrend":' + 'null' + ','
                    payload = payload + '"npacket":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]) +'"') ) + ','
                    payload = payload + '"ptrend":' + 'null' + ','
                    payload = payload + '"action":' + ('null' if datarow[11] == None else ('"' + str(datarow[11]) +'"') ) + ','
                    payload = payload + '"ostype":' + 'null' + ','
                    payload = payload + '"alivetime":' + 'null' + ','
                    payload = payload + '"srcip":' + ('null' if datarow[12] == None else ('"' + str(datarow[12]) +'"') ) + ','
                    payload = payload + '"rectime":' + 'null' + ','
                    #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    #payload = payload + '"optime":' + 'null' + ','
                    payload = payload + '"optime":' + ('null' if datarow[13] == None else ('"' + str(datarow[13]).replace(' ','T') + str(tzone6) +'"') ) + ''
                    payload = payload + '}' 
                    
                    print payload.encode("utf8")
                    try:
                        #pass
                        response = requests.post(url6, data=payload, headers=headers)
                        print response
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'wlsta' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          


            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    


