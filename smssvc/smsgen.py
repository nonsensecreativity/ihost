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

    dom = minidom.parse("smsupload.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
        

    # connection for raspbian mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset='utf8')
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
  
    timeinterval = 3 # inner loop interval i


    try:
        #for k in range(1, 60, timeinterval): # for loop 4 times erery minutes
        while True: # while loop
            print "loop " #+ str(k) +": "
                    
            #insert sms record
            prefix = "验证码测试"
            postfix = "紫光软件"
            sms = '123457'
            str_sql = "insert into  authsms set"
            str_sql = str_sql + "   prefix='" + prefix + "Cert Code:'"
            str_sql = str_sql + ",  sms='" + sms + "'"
            str_sql = str_sql + ",  postfix='Supported by:" + postfix  + "'"
            str_sql = str_sql + ",  phone='18833500052'"
            str_sql = str_sql + ",  stat='0'"
            str_sql = str_sql + ",  optflag='0'"
            str_sql = str_sql + ",  rectime=now()"
            print str_sql
            try:
                cursor2 = cnx.cursor()
                cursor2.execute(str_sql)
                cnx.commit()
            except MySQLdb.Error as err:
                print("update 'authsms' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor2.close()          

            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    
