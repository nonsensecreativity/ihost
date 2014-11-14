#!/usr/bin/env python

import os, sys, time, traceback, pexpect
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import urllib,urllib2


import authupddev

if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("configauth.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")

    for node in dom.getElementsByTagName("auth"):
        devlist=[]
        for dev in node.getElementsByTagName("dev"):
            hostaddr = dev.getAttribute("addr")
            uname = dev.getAttribute("user")
            passwd = dev.getAttribute("passwd")
            port = dev.getAttribute("port")
            wlanlist=[]
            for wlan in dev.getElementsByTagName("wlan"):
                wlanlist.append(wlan.getAttribute("name"))
            devlist.append([hostaddr, uname, passwd, port, wlanlist])
    #print devlist
    # connection for raspbian mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db)
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
    timeinterval = 15
    for k in range(1, 60, timeinterval): # 4 times erery minutes
        print "loop " + str(k) +": "
        #prepare unblock list
        strunblkmac = ""
        str_sql = "select distinct mac from authblkmac where \
            TIMESTAMPDIFF(SECOND, rectime, now()) > blktime"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for (mac) in cursor:
                #print "mac", mac
                #print "mac[0]", mac[0]
                strunblkmac = strunblkmac + "'" + mac[0] + "',"
            strunblkmac = strunblkmac[0:len(strunblkmac)-1]
            
        except MySQLdb.Error as err:
            print("select 'strunblkmac' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()          
    
        #test string    
        #strunblkmac = "'C8-3A-35-CE-47-40','C8-3A-35-CE-47-60'"
        # delete from table authblkmac
        #print strunblkmac
        if strunblkmac != "":
            str_sql = "delete from authblkmac where \
            mac in (" + strunblkmac + ")"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                
            except MySQLdb.Error as err:
                print("delete 'blkmac' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          
        
        
        unblklist = strunblkmac.split(',')
        if len(unblklist[0]) != 0 :
            #update wlan's  block list
            for device in devlist: 
            #[[u'192.168.1.251', u'super', u'sp-admin', u'22', [u'wlan0', u'wlan1']], [u'192.168.1.250', u'super', u'sp-admin', u'22', [u'wlan0', u'wlan1']]]
                updblklist(device, unblklist, 1)
    
    
        #prepare id string
        strmixid =""
        str_sql = "select CONCAT(cid,'-',phone,'-',token) as mixid from authclient where \
            manstat < '-5' and stat > '0'"
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for (mixid) in cursor:
                strmixid = strmixid + "'" + mixid[0] + "',"
            strmixid = strmixid[0:len(strmixid)-1]
            
        except MySQLdb.Error as err:
            print("select 'strmixid' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()
        print strmixid
        #test string    
        #strmixid = '130324197110046316-13333510020-1069435678'
        
        if strmixid != "":
            #update local table authclient    
            str_sql = "update authclient set stat = '-99', optflag = '10' where \
                CONCAT(cid,'-',phone,'-',token) in (" + strmixid +")" 
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("update 'local authclient' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()
                
            #update central table authclient & authmac here!!      
            tmp={'strmixid':strmixid}
            strget = urllib.urlencode(tmp)
            print strmixid
            strurl = "http://192.168.1.252/auth/wscliblk.php"
            response = urllib2.urlopen(strurl+"?"+strget)
            html = response.read()
            print html
            if ("0" in html):
                print "sucess"      
       
            
            #prepare mac string
            strblkmac =""
            str_sql = "select distinct mac from authmac where \
                CONCAT(cid,'-',phone,'-',token) in (" + strmixid +") and \
                mac not in ( select mac from authmac where \
                CONCAT(cid,'-',phone,'-',token) not in (" + strmixid +"))"
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (mac) in cursor:
                    strblkmac = strblkmac + "'"+ mac[0] + "',"
                strblkmac = strblkmac[0:len(strblkmac)-1]
                
            except MySQLdb.Error as err:
                print("select 'strblkmac' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()
            
            #test string    
            #strblkmac = "'C8-3A-35-CE-47-40','C8-3A-35-CE-47-50'"
            
            if strblkmac != "":
                #update local table authmac
                str_sql = "delete from authmac where \
                    CONCAT(cid,'-',phone,'-',token) in (" + strmixid +")"
                    #mac in (" + strblkmac +")"
                print str_sql
                try:
                    cursor = cnx.cursor()
                    cursor.execute(str_sql)
                    cnx.commit()
                except MySQLdb.Error as err:
                    print("update 'local authmac' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor.close()
                    
                 
                #add to table authblkmac for unblock
                blklist = (strblkmac.replace('-', ':')).split(',')
                blktime = '60'
                for mac in blklist:
                    #print mac
                    str_sql = "insert into authblkmac set \
                        mac = " + mac +" \
                        , blktime = '"+ blktime +"' \
                        , rectime = now()"
                    print str_sql
                    try:
                        cursor = cnx.cursor()
                        cursor.execute(str_sql)
                        cnx.commit()
                    except MySQLdb.Error as err:
                        print("insert into 'local authblkmac' failed.")
                        print("Error: {}".format(err.args[1]))   
                    finally:
                        cursor.close()
               
                if len(blklist[0]) != 0 :
                    #update wlan's  block list
                    for device in devlist: 
                    #[[u'192.168.1.251', u'super', u'sp-admin', u'22', [u'wlan0', u'wlan1']], [u'192.168.1.250', u'super', u'sp-admin', u'22', [u'wlan0', u'wlan1']]]
                        updblklist(device, blklist, 0)
            
        time.sleep(timeinterval)
    
