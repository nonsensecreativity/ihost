#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import subprocess
import gammu


if __name__ == '__main__':
    
    time.sleep(30)
    
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
            str_sql = "select distinct msgid,phone from authsms where \
                TIMESTAMPDIFF(SECOND, rectime, '"+ strnow +"') < '" + str(overtime) + "' \
                and stat*optflag = '0'  \
                and phone <> '' \
                and phone is not null \
                and sms <> ''  \
                and sms is not null \
                and stat < '" + str(maxretry)  + "'"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (msgid, phone) in cursor:
                    #print phone
                    #print msgid
                    #get latest message
                    sms =""
                    str_sql = "select CONCAT(prefix,sms,postfix) as smsmix from authsms where \
                        TIMESTAMPDIFF(SECOND, rectime, '"+ strnow +"') < '" + str(overtime) + "' \
                        and phone ='" + str(phone) + "' \
                        and msgid ='" + str(msgid) + "' \
                        and stat*optflag = '0'  \
                        and sms <> ''  \
                        and sms is not null \
                        and stat < '" + str(maxretry) +"' order by id desc limit 1"

                    #print str_sql
                    try:
                        cursor1 = cnx.cursor()
                        cursor1.execute(str_sql)
                        cnx.commit()
                        sms = cursor1.fetchone()[0]
                        #print sms
                    except MySQLdb.Error as err:
                        print("select 'sms' failed.")
                        print("Error: {}".format(err.args[1]))   
                    finally:
                        cursor1.close()
                        
                    optflag = "0"
                    if (sms == "") :
                        optflag = "1"
                    else :
                        # send sms and read output
                        try:

                            # Prepare message data
                            # We tell that we want to use first SMSC number stored in phone

                            phone_number = phone
                            message = sms
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
                    where phone = '" + str(phone) +"' \
                    and msgid = '" + str(msgid) +"' \
                    and TIMESTAMPDIFF(SECOND, rectime, '"+ strnow +"') < '" + str(overtime) +"'"
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
                print("select 'phone' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()     
           
            # check & receive sms
            mlocation = '0'
            mfolder = '0'
            sms = ['']
            start = True
            while True: # while loop
                #print "inner loop"
                try :
                    if start:
                        #print "start---"
                        sms = sm.GetNextSMS(Start = True, Folder=0)
                        start = False
                    else:
                        #print "else---"
                        sms = sm.GetNextSMS(Location = sms[0]['Location'], Folder=0)
                        #be careful sometimes Location is directly in the hash so you'll have to remove the [0]
                except gammu.ERR_EMPTY:
                    #print "empty"
                    break
                except :
                    #print "except"
                    pass
                #print "Location:%s\t State:%s\t Folder:%s\t Text:%s" % (sms[0]['Location'],sms[0]['State'],sms[0]['Folder'],sms[0]['Text'])
                if len(sms) > 0 :
                    #print sms
                    mlocation = str(sms[0]['Location'])
                    mfolder = str(sms[0]['Folder'])
                    #print mlocation
                    if sms[0]['Coding'] <> '8bit':
                        print "... insert loop"
                        phone = sms[0]['Number']
                        msgtime = sms[0]['DateTime'].strftime( '%Y-%m-%d %H:%M:%S' )
                        try :
                            msg = sms[0]['Text'].encode('utf-8')
                        except :
                            msg = sms[0]['Text']
                        #prepare sms list
                        str_sql = "insert into smsrcv set \
                            msg = '" + msg +"', \
                            phone = '" + phone +"', \
                            msgtime = '" + msgtime +"', \
                            mlocation = '" + mlocation + "', \
                            mfolder = '" + mfolder + "', \
                            rectime = now()"
                        #print str_sql
                        try:
                            cursor = cnx.cursor()
                            cursor.execute(str_sql)
                            cnx.commit()
                
                        except MySQLdb.Error as err:
                            print("insert 'smsrcv' failed.")
                            print("Error: {}".format(err.args[1]))   
                        finally:
                            cursor.close()              


            # delete sms from stick
            #print mlocation
            try :
                x = int(mlocation)
                for x in range(int(mlocation),0,-1):
                    sm.DeleteSMS(int(mfolder), x)
                    print "......... delete loop" + str(x)      
            except :
                pass
             
            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    

