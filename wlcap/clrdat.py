#!/usr/bin/env python

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime


if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("config.xml")

    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
        
    # connection for  mysqldb,
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db)
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
    clrwlpkt = 168
    clractvst = 1440
    
    # remove user from wlpkt 
    str_sql = "delete from wlpkt where \
        timestampdiff(hour,rectime,now())> '" + str(clrwlpkt)+ "'"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
    except MySQLdb.Error as err:
        print("delete 'wlpkt' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()          


    # remove user from actvst
    str_sql = "delete from actvst where \
        timestampdiff(hour,rectime,now())> '" + str(clractvst)+ "'"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
    except MySQLdb.Error as err:
        print("delete 'actvst' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()          
