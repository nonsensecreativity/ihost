#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time


if __name__ == '__main__':
    

    #set default coding utf-8
    reload(sys)
    sys.setdefaultencoding('utf-8')

    oper = '15076487993'
    #read configurations here
    dom = minidom.parse("configauth.xml")
        
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
    

    try:
        strnow = str(datetime.datetime.now())

        #check que length
        str_sql = "select count(id) as cnt from authsms where  \
        stat*optflag = '0'    and phone <> '' and sms <> ''  and  stat < '3'"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for datarow in cursor:
                qlen = datarow[0]
        except MySQLdb.Error as err:
            print("select 'authsms' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()         
           
        #check que length
        str_sql = "insert into authsms (sms,phone)  \
        values ('" + str(qlen) +  "@" + strnow + "','" + oper +"')"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for datarow in cursor:
                qlen = datarow[0]
        except MySQLdb.Error as err:
            print("select 'authsms' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()         
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    

