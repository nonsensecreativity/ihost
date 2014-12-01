#!/usr/bin/env python

import os, sys, time, traceback, pexpect
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time

if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("configpnt.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    for node in dom.getElementsByTagName("userpnt"):
        step = node.getAttribute("step")
        firstseen = node.getAttribute("firstseen")


    # connection for mysqldb
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset="utf8")
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
    timeinterval = 60
    for k in range(1, 60, timeinterval): # 1 times erery minutes
        print "loop " + str(k) +": "

        upd_sql = "update userpoints set points = points + " +step +" , \
                updtime = now() , \
                action = 'sta2pnt' where \
                mac in (select distinct replace(mac,':','-') from wlsta)"
        #print upd_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(upd_sql)
            cnx.commit()
        except MySQLdb.Error as err:
            print("update 'userpoints' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()
            
        str_sql = "select replace(mac,':','-') as strmac from wlsta where \
            replace(mac,':','-') not in (select distinct mac from userpoints)"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for (strmac) in cursor:
                #print "strmac", strmac, type(strmac)

                ins_str = "insert into userpoints set \
            mac = '" + strmac[0] + "', \
            points = '" + firstseen + "',  \
            action = 'sta2pnt', \
            rectime = now()"
                #print  ins_str

                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(ins_str)
                    cnx.commit()
                except MySQLdb.Error as err:
                    print("insert into 'userpoints' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()                                  

        except MySQLdb.Error as err:
            print("select 'wlsta' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()          
            
        #time.sleep(timeinterval)
    
