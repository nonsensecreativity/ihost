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

    # connection for mysqldb
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset="utf8")
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
    timeinterval = 3
    for k in range(1, 60, timeinterval): # 20 times erery minutes
        print "loop " + str(k) +": "

        str_sql = "select replace(mac,':','-') as strmac,lastseen from wlsta where \
            replace(mac,':','-') in (select distinct mac from usermacs)"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for (strmac, lastseen) in cursor:
                #print "strmac", strmac, type(strmac)
                #print "lastseen",  lastseen,  type(lastseen)
                select_str = "select id, maclast from useractive where \
                mac = '" + strmac + "' order by id desc limit 1"
                #print select_str
                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(select_str)
                    cnx.commit()
                    if cursor1.rowcount: # mac is already in useractive
                        macid = cursor1.fetchone()
                        td = lastseen - macid[1]
                        tdelta = td.days*24*3600 + td.seconds
                        if tdelta > 10: # maclast is later than lastseen 
                            upd_str = "update useractive set \
                            pushflag=if(onsite='1',pushflag,pushflag+'2'), \
                            onsite='1', \
                            macfirst=if(macfirst='1970-01-01 00:00:00','" + lastseen.strftime('%Y-%m-%d %H:%M:%S') + "',macfirst),\
                            maclast = '" + lastseen.strftime('%Y-%m-%d %H:%M:%S') + "', \
                            updby='onsite.py', \
                            updtime=now()\
                            where id = '" + str(macid[0]) + "'"
                            #print  upd_str

                            try:
                                cursor2 = cnx.cursor()
                                cursor2.execute(upd_str)
                                cnx.commit()
                            except MySQLdb.Error as err:
                                print("update 'useractive' failed.")
                                print("Error: {}".format(err.args[1]))   
                            finally:
                                cursor2.close()          

                    else: # mac not in useractive
                        # get user's data from usermacs by mac
                        sel_str = "select userid, userrole, phone from usermacs where \
                        mac ='" + strmac + "' and \
                        userid is not null and \
                        userid <> '' \
                        order by pntmaster desc, dft desc, prio desc, updtime desc, id desc limit 1"
                        #print sel_str
                        try:
                            cursor3 = cnx.cursor()
                            cursor3.execute(sel_str)
                            cnx.commit()
                            if  cursor3.rowcount: # user's id, userrole, phone in usermacs
                                userdata = cursor3.fetchone()
                                #print userdata
                                ins_str = "insert into useractive set \
                            mac = '" + strmac + "', \
                            userid = '" + str(userdata[0]) + "',  \
                            userrole = \
                            " + ("null" if userdata[1] == None else ("'" + str(userdata[1]) +"'") ) + ", \
                            phone = \
                            " + ("null" if userdata[2] == None else ("'" + str(userdata[2]) +"'") ) + ", \
                            onsite='1', maclast = '" + lastseen.strftime('%Y-%m-%d %H:%M:%S') + "',\
                            insby='onsite.py', \
                            macfirst = '" + lastseen.strftime('%Y-%m-%d %H:%M:%S') + "',\
                            rectime = now(), \
                            pushflag = '1'"
                                #print  ins_str

                                try:
                                    cursor2 = cnx.cursor()
                                    cursor2.execute(ins_str)
                                    cnx.commit()
                                except MySQLdb.Error as err:
                                    print("insert into 'useractive' failed.")
                                    print("Error: {}".format(err.args[1]))   
                                finally:
                                    cursor2.close()                                  
 
 
                        except MySQLdb.Error as err:
                            print("select 'usermacs' failed.")
                            print("Error: {}".format(err.args[1]))   
                        finally:
                            cursor3.close()                              
            
                except MySQLdb.Error as err:
                    print("select 'useractive' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()          

            
        except MySQLdb.Error as err:
            print("select 'wlsta' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()          
            
        time.sleep(timeinterval)
    
