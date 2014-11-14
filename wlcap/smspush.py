#!/usr/bin/env python
#encoding=utf-8

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

    # connection for mysqldb
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset="utf8")
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
    strtime = time.strftime('%Y-%m-%d %H:%M:%S',time.localtime(time.time()))
    timeinterval = 5
    for k in range(1, 60, timeinterval): # 12 times erery minutes
        print "loop " + str(k) +": "

        str_sql = "select msgid,prefix,sms,postfix, \
             cndmacfirst,cndmacstay,cndpagefirst,cndpagestay, \
             cndonsite,cndonline,cnduserrole from smspool where \
             stat='100' and \
             timestampdiff(second,cndfromtime,now())>= '0' and \
             timestampdiff(second,cndtotime,now()) < '0'"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            results = cursor.fetchall()
            for r in results:
                #print r
                select_str = "select mac, phone,userid from useractive where \
                     timestampdiff(second,macfirst,now())>= '" + str(r[4]) + "' and \
                     timestampdiff(second,macfirst,maclast)>= '" + str(r[5]) + "' and \
                     timestampdiff(second,pagefirst,now())>= '" + str(r[6]) + "' and \
                     timestampdiff(second,pagefirst,pagelast)>= '" + str(r[7]) + "' and \
                     onsite >= '" + str(r[8]) + "' and \
                     online >= '" + str(r[9]) + "' and \
                     userrole = '" + str(r[10]) + "' and  \
                     phone is not null and \
                     phone <> '' and \
                     userid is not null and \
                     userid <> ''"
                #print select_str
                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(select_str)
                    cnx.commit()
                    for (mac, phone, userid) in cursor1:
                        chk_str = "select id from authsms where \
                        msgid = '" + str(r[0]) + "' and \
                        mac = '" + mac + "' and \
                        phone = '" + phone +"'"
                        #print  chk_str

                        try:
                            cursor2 = cnx.cursor()
                            cursor2.execute(chk_str)
                            cnx.commit()
                                            
                            if not cursor2.rowcount: # msgid + mac +phone not in authsms
                                sel_str = "select userid,fname,lname from useraccounts where\
                            userid = '" + userid + "'"
                                #print  sel_str

                                try:
                                    cursor3 = cnx.cursor()
                                    cursor3.execute(sel_str)
                                    cnx.commit()
                                    if cursor3.rowcount:
                                        userinfo = cursor3.fetchone()
                                        #print userinfo
                                except MySQLdb.Error as err:
                                    print("select 'useraccounts' failed.")
                                    print("Error: {}".format(err.args[1]))   
                                finally:
                                    cursor3.close()                                
                            
                                ins_str = "insert into authsms set \
                            mac = '" + mac + "', \
                            phone = '" + phone +"',\
                            msgid = '" + str(r[0]) + "',  \
                            prefix = '" + userinfo[2] + "@" + strtime +": " + r[1] +  "', \
                            sms = '" + r[2] + "', \
                            postfix = '" + r[3] + "', \
                            stat = '0', \
                            rectime = now()"
                                #print  ins_str

                                try:
                                    cursor3 = cnx.cursor()
                                    cursor3.execute(ins_str)
                                    cnx.commit()
                                except MySQLdb.Error as err:
                                    print("insert into 'authsms' failed.")
                                    print("Error: {}".format(err.args[1]))   
                                finally:
                                    cursor3.close()    
                                    
                        except MySQLdb.Error as err:
                            print("select 'authsms' failed.")
                            print("Error: {}".format(err.args[1]))   
                        finally:
                            cursor2.close()                            
            
                except MySQLdb.Error as err:
                    print("select 'useractive' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()          

            
        except MySQLdb.Error as err:
            print("select 'smspool' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()          
            
        time.sleep(timeinterval)
    
