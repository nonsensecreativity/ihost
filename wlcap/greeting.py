#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback, pexpect
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time

if __name__ == '__main__':

    #set default coding utf-8
    reload(sys)
    sys.setdefaultencoding('utf-8')

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
    
    strdate = time.strftime('%Y-%m-%d',time.localtime(time.time()))
    strhour = time.strftime('%H',time.localtime(time.time()))

    strssid = 'Matrix'
    stroperator = '13701272752'
    strurl = 'http://172.16.0.1/hug.php'
    
 
    # greeting message #1
    str_sql = "select msgtype from smspool where \
        msgtype like 'greeting-1%' order by id desc limit 1"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
        if not cursor.rowcount:
            ins_str = "insert into smspool set \
                msgtype = '" + 'greeting-1-' + strdate + "', \
                prefix = '" +  '欢迎使用Matrix Wifi！ 请打开手机无线网络，连接' + "', \
                sms = '"+ strssid + "',  \
                postfix = '" + ' ，并输入Internet网址。 服务电话 ' + stroperator+"',  \
                cnduserrole = '0', \
                cndfromtime = '" + strdate + " 06:00:00', \
                cndtotime = '" + strdate + " 23:00:00', \
                updtime = now(), \
                rectime = now()" 
            #print  ins_str
            try:
                cursor1 = cnx.cursor()
                cursor1.execute(ins_str)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert into 'smspool' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor1.close()
        else:
            if strhour == '06':
                msgtype = cursor.fetchone()[0]
                if msgtype != 'greeting-1-' + strdate:
                    upd_str = "update smspool set \
                        msgtype = '" + "greeting-1-" + strdate + "',  \
                        cndfromtime = '" + strdate + " 06:00:00', \
                        cndtotime = '" + strdate + " 23:00:00', \
                        updtime = now() \
                        where msgtype = '" + msgtype + "'" 
                    #print  upd_str
                    try:
                        cursor1 = cnx.cursor()
                        cursor1.execute(upd_str)
                        cnx.commit()
                    except MySQLdb.Error as err:
                        print("update 'smspool' failed.")
                        print("Error: {}".format(err.args[1]))   
                    finally:
                        cursor1.close()            
    except MySQLdb.Error as err:
        print("select 'smspool - greeting-1' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()              
    
    # greeting message #2
    str_sql = "select msgtype from smspool where \
        msgtype like 'greeting-2%' order by id desc limit 1"
    #print str_sql
    try:
        cursor = cnx.cursor()
        cursor.execute(str_sql)
        cnx.commit()
        if not cursor.rowcount:
            ins_str = "insert into smspool set \
                msgtype = '" + 'greeting-2-' + strdate + "', \
                prefix = '" +  '试试手气！' + "', \
                sms = '"+ strurl + "',  \
                postfix = '" + '得积分兑彩票' +"',  \
                cnduserrole = '0', \
                cndfromtime = '" + strdate + " 06:00:00', \
                cndtotime = '" + strdate + " 23:00:00', \
                updtime = now(), \
                rectime = now()" 
            #print  ins_str
            try:
                cursor1 = cnx.cursor()
                cursor1.execute(ins_str)
                cnx.commit()
            except MySQLdb.Error as err:
                print("insert into 'smspool' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor1.close()
        else:
            if strhour == '06':
                msgtype = cursor.fetchone()[0]
                if msgtype != 'greeting-2-' + strdate:
                    upd_str = "update smspool set \
                        msgtype = '" + "greeting-2-" + strdate + "',  \
                        cndfromtime = '" + strdate + " 06:00:00', \
                        cndtotime = '" + strdate + " 23:00:00', \
                        updtime = now() \
                        where msgtype = '" + msgtype + "'" 
                    #print  upd_str
                    try:
                        cursor1 = cnx.cursor()
                        cursor1.execute(upd_str)
                        cnx.commit()
                    except MySQLdb.Error as err:
                        print("update 'smspool' failed.")
                        print("Error: {}".format(err.args[1]))   
                    finally:
                        cursor1.close()            
    except MySQLdb.Error as err:
        print("select 'smspool - greeting-2' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()              
    
