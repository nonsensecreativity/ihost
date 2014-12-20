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
    for k in range(1, 60, timeinterval): # once erery 10 minutes
        print "loop " + str(k) +": "
            
        str_sql = "SELECT t1.id, t1.mac, t1.points, t1.action, t1.updtime as updtime1, \
            t2.mac as mac2, t2.userid as userid2, t2.userrole as userrole2, \
            t3.id as id3, t3.userid, t3.integral, t3.updtime as updtime3, t3.pntfactor  \
            FROM (userpoints t1  \
            INNER JOIN useractive t2 ON t1.mac = t2.mac)  \
            INNER JOIN useraccounts t3 ON t2.userid = t3.userid"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
            for (datarow) in cursor:
                #print "datarow:", datarow, type(datarow)
                
                if  datarow[2] != None  and  int(datarow[2]) > 0:
                    points = str(datarow[2]) 
                    integral = "0" if datarow[10] == None else ( str(datarow[10]) )
                    pntfactor = "1000" if datarow[12] == None else ( str(datarow[12]) )
                    dintegral = str(int(int(points) * int(pntfactor) / 1000))
                    if int(dintegral) > 0 :
                        # insert record in userlog
                        ins_str = "insert into userlog set \
                    mac = '" + datarow[1] + "', \
                    token = '" + str(datarow[0]) + "', \
                    dintegral = '" + dintegral + "', \
                    userid = '" + str(datarow[8]) + "', \
                    integral = '" + integral + "', \
                    action = 'pnt2user', \
                    rectime = now()"
                        #print  ins_str

                        # increase integral in useraccounts
                        upd_str1 = "update useraccounts set \
                    integral = '" + str(int(integral) + int(dintegral)) + "', \
                    pushflag = pushflag + '2' \
                    where id = '" + str(datarow[8]) + "'" 
                        #print  upd_str1

                        # decrease points in userpoints
                        upd_str2 = "update userpoints set \
                    points = '0' \
                    where id = '" + str(datarow[0]) + "'" 
                        #print  upd_str2

                        try:
                            cursor1 = cnx.cursor()
                            cursor1.execute(ins_str)
                            cursor1.execute(upd_str1)
                            cursor1.execute(upd_str2)
                            cnx.commit()
                        except MySQLdb.Error as err:
                            print("points to integral failed.")
                            print("Error: {}".format(err.args[1]))   
                        finally:
                            cursor1.close() 

        except MySQLdb.Error as err:
            cnx.rollback()
            print("select 'userpoints' failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()          
            
        #time.sleep(timeinterval)
    
