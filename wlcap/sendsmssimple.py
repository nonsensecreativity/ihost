#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import subprocess
import gammu


if __name__ == '__main__':
    
    time.sleep(45)

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
    
    # Connect to phone
    try:    
        # Create state machine object
        sm = gammu.StateMachine()
        sm.ReadConfig() # Read ~/.gammurc
        sm.Init()
    except Exception,e:
        print e
        sys.exit(0) 
    
    timeinterval = 1 # inner loop interval i
    overtime = 180 # ignore overtime messages
    maxretry = 3 #maximun retries for a given phone number

    try:
        #for k in range(1, 60, timeinterval): # for loop 4 times erery minutes
        while True: # while loop
            strnow = str(datetime.datetime.now())
            print "loop " #+ str(k) +": "
            #prepare sms list
            str_sql = "select id, phone,CONCAT(prefix,sms,postfix) as smsmix from authsms where \
                stat*optflag = '0'  \
                and phone <> '' \
                and sms <> ''  \
                and stat < '" + str(maxretry)  + "'"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for datarow in cursor:
                    #print datarow

                    optflag = "0"
                    if (datarow[1] == None  or  datarow[2] == None) :
                        optflag = "1"
                    else :
                        # send sms and read output
                        try:

                            # Prepare message data
                            # We tell that we want to use first SMSC number stored in phone

                            phone_number = datarow[1]
                            message = datarow[2]
                            #print phone_number, message
                            message = {
                                'Text': message,
                                'SMSC': {'Location': 1},
                                'Number': phone_number,
                                'Coding': 'Unicode_No_Compression',
                            }
                            # Actually send the message
                            sm.SendSMS(message)
                            optflag = "1"
                        except Exception,e:
                            print e
                    
                    #update authsms set sent flag
                    str_sql = "update authsms set stat = stat + 1 , \
                    sendtime = now(), optflag = " + optflag + "  \
                    where id = '" + str(datarow[0]) +"'"
                    #print str_sql
                    try:
                        cursor2 = cnx.cursor()
                        cursor2.execute(str_sql)
                        cnx.commit()
                    except MySQLdb.Error as err:
                        print("update 'authsms' failed.")
                        print("Error: {}".format(err.args[1]))   
                    finally:
                        cursor2.close()          

            except MySQLdb.Error as err:
                print("select 'authsms' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          
                    
            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    

