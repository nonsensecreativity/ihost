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
    threshold = '60'
    fbottom = '10'
    fceiling = '1000'
    gracetime = '30'
    
    for k in range(1, 60, timeinterval): # once erery 1 minutes
        print "loop " + str(k) +": "
            
        str_sql = "update useraccounts set pntfactor=round(1.25*pntfactor/2) \
        where userid in ( \
            select userid from \
              (select userid,mac, sum(dintegral) as sumd,week(rectime) from userlog \
                      where mac<>'' and \
                      (action='pnt2user' or action='pointToIntegral') and \
                      year(rectime)=year(now()) and week(rectime)=week(now())  \
                      group by userid,mac,week(rectime) order by mac,week(rectime) ) tbl1 \
            where sumd > '" + threshold  + "') \
        and pntfactor > '" + fbottom +  "'"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
        except MySQLdb.Error as err:
            cnx.rollback()
            print("update 'useraccounts' set pntfactor failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close()          
            
        # if one mac appears in 30 days, all the userids bound to the mac is excluded 
        # if any mac bounded to one userid is not appeared in the last 30 days, pntfactor is reset to 1000
        str_sql = "update useraccounts set pntfactor='" + fceiling + "' \
        where userid not in (select distinct(userid) from usermacs \
                          where mac in \
                                 (select distinct(mac)  from userlog \
                                 where mac<>'' and \
                                 (action='pnt2user' or action='pointToIntegral') and \
                                 timestampdiff(day,rectime,now())<'" + gracetime + "') \
                          and stat >= '100') \
        and userid in (select distinct(userid) from userlog) \
        and pntfactor < '" + fceiling + "' \
        and stat >= '100'"
        #print str_sql
        try:
            cursor = cnx.cursor()
            cursor.execute(str_sql)
            cnx.commit()
        except MySQLdb.Error as err:
            cnx.rollback()
            print("update 'useraccounts' reset pntfactor failed.")
            print("Error: {}".format(err.args[1]))   
        finally:
            cursor.close() 
        #time.sleep(timeinterval)
    
