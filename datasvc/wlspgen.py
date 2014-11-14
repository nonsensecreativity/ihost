#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import subprocess



if __name__ == '__main__':

    reload(sys)
    sys.setdefaultencoding('utf-8')
    
    #read configurations here

    dom = minidom.parse("wlspupload.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    for node in dom.getElementsByTagName("table1"):
        tbl1 = node.getAttribute("tblname")
    for node in dom.getElementsByTagName("table2"):
        tbl2 = node.getAttribute("tblname")
    for node in dom.getElementsByTagName("table3"):
        tbl3 = node.getAttribute("tblname")
    for node in dom.getElementsByTagName("table4"):
        tbl4 = node.getAttribute("tblname")
    for node in dom.getElementsByTagName("table5"):
        tbl5 = node.getAttribute("tblname")
    for node in dom.getElementsByTagName("table6"):
        tbl6 = node.getAttribute("tblname")

        

    # connection for  mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset='utf8')
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
  
    timeinterval = 1 # inner loop interval i

    #print sys.getdefaultencoding() 
    try:
        #for k in range(1, 60, timeinterval): # for loop 4 times erery minutes
        while True: # while loop
            print "loop " #+ str(k) +": "
                    
            #insert authclient record
            str_sql = "insert into  " + tbl1 +" set"
            str_sql = str_sql + "   cid='11110000'" 
            str_sql = str_sql + ",  ctype='1000'"
            str_sql = str_sql + ",  stat='100'" 
            str_sql = str_sql + ",  phone='18833500052'"
            str_sql = str_sql + ",  sphone='18833500052'"
            str_sql = str_sql + ",  mac='00-16-6D-C0-76-3C'"
            str_sql = str_sql + ",  srcip='172.168.0.200'"
            str_sql = str_sql + ",  rectime=now()"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert 'authclient' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #insert authmac record
            str_sql = "insert into  " + tbl2 +" set"
            str_sql = str_sql + "  mac='00-16-6D-C0-76-3C'"
            str_sql = str_sql + ",  ip='172.168.0.200'"
            str_sql = str_sql + ",  stat='100'" 
            str_sql = str_sql + ",   cid='11110000'" 
            str_sql = str_sql + ",  phone='18833500052'"
            str_sql = str_sql + ",  base='ihost'"
            str_sql = str_sql + ",  srcip='172.168.0.10'"
            str_sql = str_sql + ",  rectime=now()"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert 'authmac' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          
 

            #insert authmacip record
            strurl = "http://webserver ip/ihost.php?res=notyet\
            &uamip=192.168.10.1&uamport=3990\
            &challenge=d250bf0a4396dfafbf1df4051759fb3b\
            &called=B8-27-EB-61-27-F0&mac=00-15-58-C3-BB-E5\
            &ip=192.168.10.131&nasid=nas01\
            &sessionid=539108d100000003\
            &userurl=http%3a%2f%2fwww.baidu.com%2f"
            
            str_sql = "insert into  " + tbl3 +" set"
            str_sql = str_sql + "  mac='00-16-6D-C0-76-3C'"
            str_sql = str_sql + ",  ip='172.168.0.200'"
            str_sql = str_sql + ",  called='B8-27-EB-61-27-F0'" 
            str_sql = str_sql + ",  srcip='172.168.0.10'"
            str_sql = str_sql + ",  orgurl='" + strurl + "'" 
            str_sql = str_sql + ",  userurl='http%3a%2f%2fwww.baidu.com%2f'"
            str_sql = str_sql + ",  rectime=now()"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert 'authmac' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          
                

            #insert actvst record
            str_sql = "insert into  " + tbl4 +" set"
            str_sql = str_sql + "  pkttime=now()"
            str_sql = str_sql + ",  timefrac='0080'"
            str_sql = str_sql + ",  srcmac='00-16-6D-C0-76-3C'"
            str_sql = str_sql + ",  srcip='172.168.0.200'"
            str_sql = str_sql + ",  destip='192.168.0.1'" 
            str_sql = str_sql + ",   url='http://www.sina.com'" 
            str_sql = str_sql + ",  rectime=now()"
            print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert 'actvst' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()                          
            """
            #insert wlact record
            str_sql = "insert into  " + tbl5 +" set"
            str_sql = str_sql + "  event='coming'"
            str_sql = str_sql + ",  mac='00-16-6D-C0-76-3C'"
            str_sql = str_sql + ",  subevent='upgrade'"
            str_sql = str_sql + ",  oldvalue='100'"
            str_sql = str_sql + ",  newvalue='200'"
            str_sql = str_sql + ",  firstseen=now()"
            str_sql = str_sql + ",  lastseen=now()"
            str_sql = str_sql + ",  stat='100'"
            str_sql = str_sql + ",  ssid='免费WIFI'"
            str_sql = str_sql + ",  action='1'"
            str_sql = str_sql + ",  tcount='300'"
            str_sql = str_sql + ",  srcip='172.168.0.200'"
            str_sql = str_sql + ",  rectime=now()"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert 'wlact' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()                         
            """
            #insert wlsta record
            str_sql = "insert into  " + tbl6 +" set"
            str_sql = str_sql + "  tcount='300'"
            str_sql = str_sql + ",  mac='00-16-6D-C0-76-3C'"
            str_sql = str_sql + ",  ssid='免费WIFI'"
            str_sql = str_sql + ",  rssi='-65'"
            str_sql = str_sql + ",  stat='100'"
            str_sql = str_sql + ",  setby='rdpp.py'"
            str_sql = str_sql + ",  keepalive='100'"
            str_sql = str_sql + ",  firstseen=now()"
            str_sql = str_sql + ",  lastseen=now()"
            str_sql = str_sql + ",  npacket='120'"
            str_sql = str_sql + ",  action='1'"
            str_sql = str_sql + ",  srcip='172.168.0.200'"
            str_sql = str_sql + ",  rectime=now()"
            print str_sql.encode("utf8")
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert 'wlsta' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()                   

            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    
