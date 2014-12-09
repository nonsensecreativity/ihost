#!/usr/bin/env python

import os, sys, time, traceback, pexpect
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time

if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("configauth.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    for node in dom.getElementsByTagName("onsitechk"):
        onsite = node.getAttribute("onsite")
        online = node.getAttribute("online")
        leave = node.getAttribute("leave")
    
    # connection for mysqldb
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset="utf8")
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
    # remove user from useractive 
    str_sql = "delete from useractive where \
        timestampdiff(second,maclast,now())> '" + str(leave)+ "'"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
    except MySQLdb.Error as err:
        print("delete 'useractive' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()          

    # set onsite=0
    str_sql = "update useractive set pushflag=if(onsite='0',pushflag,'4'), onsite='0'  \
        where timestampdiff(second,maclast,now())> '" + str(onsite) + "'"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
    except MySQLdb.Error as err:
        print("update onsite 'useractive' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()              

    # set online=0
    str_sql = "update useractive set pushflag=if(online='0',pushflag,'16'), online='0' \
        where timestampdiff(second,pagelast,now())> '" + str(online) + "'"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
    except MySQLdb.Error as err:
        print("update online 'useractive' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()              
