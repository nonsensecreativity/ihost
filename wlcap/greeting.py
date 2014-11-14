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

    if strhour == '06':
        # morning message
        str_sql = "select msgid from smspool where \
            msgid like 'morning%' order by id desc limit 1"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            if not cursor.rowcount:
                ins_str = "insert into smspool set \
                    msgid = '" + 'morning-' + strdate + "', \
                    sms = '" +  "开始上班啦" + "',  \
                    cnduserrole = '100', \
                    cndfromtime = '" + strdate + " 06:00:00', \
                    cndtotime = '" + strdate + " 09:00:00', \
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
                msgid = cursor.fetchone()[0]
                if msgid != 'morning-' + strdate:
                    upd_str = "update smspool set \
                        msgid = '" + "morning-" + strdate + "',  \
                        cndfromtime = '" + strdate + " 06:00:00', \
                        cndtotime = '" + strdate + " 09:00:00', \
                        updtime = now() \
                        where msgid = '" + msgid + "'" 
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
            print("select 'smspool - morining' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()              
    
    elif strhour == '12':
        str_sql = "select msgid from smspool where \
            msgid like 'noon%' order by id desc limit 1"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            if not cursor.rowcount:
                ins_str = "insert into smspool set \
                    msgid = '" + 'noon-' + strdate + "', \
                    sms = '" +  "该吃午饭啦" + "',  \
                    cnduserrole = '100', \
                    cndfromtime = '" + strdate + " 12:00:00', \
                    cndtotime = '" + strdate + " 12:30:00', \
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
                msgid = cursor.fetchone()[0]
                if msgid != 'noon-' + strdate:
                    upd_str = "update smspool set \
                        msgid = '" + "noon-" + strdate + "',  \
                        cndfromtime = '" + strdate + " 12:00:00', \
                        cndtotime = '" + strdate + " 12:30:00', \
                        updtime = now() \
                        where msgid = '" + msgid + "'" 
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
            print("select 'smspool - noon' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()                 
