#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import subprocess
#import gammu
import requests, json
from urllib import quote


if __name__ == '__main__':

    reload(sys)
    sys.setdefaultencoding('utf-8')
    
    #wait for mysql server is ready 
    time.sleep(45)

    #read configurations here

    dom = minidom.parse("sms2sserver.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
        
    for node in dom.getElementsByTagName("smsremote"):
        smsurl = node.getAttribute("uri")
        #netid = node.getAttribute("netid")
        tzone = node.getAttribute("tzone")
        

    # connection for raspbian mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset='utf8')
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
  
    timeinterval = 1 # inner loop interval i
    overtime = 180 # ignore overtime messages
    maxretry = 10 #maximun retries for a given phone number

    # scriptname & macaddress
    progid = os.path.basename(__file__)
    macaddr = open('/sys/class/net/eth0/address').read()[0:17]
    # netid
    netid = ''
    with open("/etc/hostapd/hostapd.conf") as fin:
        for line in fin:
            if 'ssid=' in line:
                #print line
                netid = line.split('=')[1]
                netid = netid.replace('\n', '')
                netid = netid.replace('\r', '')
                #print netid
                break
    try:
        #for k in range(1, 60, timeinterval): # for loop 4 times erery minutes
        while True: # while loop
            strnow = str(datetime.datetime.now())
            print "loop " #+ str(k) +": "
            #prepare sms list
            
            sms =""
            str_sql = "select id, prefix, sms, postfix, phone, rectime from authsms where \
                TIMESTAMPDIFF(SECOND, rectime, '"+ strnow +"') < '" + str(overtime) + "' \
                and stat*optflag = '0'  \
                and CONCAT(prefix,sms,postfix) <> ''  \
                and phone <> '' \
                and stat < '" + str(maxretry) +"' order by id"

            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                for (mesg) in cursor :
                    msgid = mesg[0]
                    msgprefix = mesg[1]
                    msgsms = mesg[2]
                    msgpostfix = mesg[3]
                    msgphone = mesg[4]
                    msgrectime = mesg[5]
                
                    optflag = "0"
                    if (msgsms == "") :
                        optflag = "1"
                    else :
                        # send sms and read output
                        try:
                            # Push msg data to rest service
                            headers = {"content-type":"application/json;charset=UTF-8"}
                            payload = '{'
                            payload = payload + '"id":' + '0' + ','
                            payload = payload + '"srcid":' + ('null' if msgid == None else ('"' + str(msgid) +'"') ) +  ','
                            payload = payload + '"prefix":' + quote(('null' if msgprefix == None else ('"' + str(msgprefix) +'"') ))  + ','
                            payload = payload + '"sms":' + quote(('null' if msgsms == None else ('"' + str(msgsms) +'"') )) + ','
                            payload = payload + '"postfix":' + quote(('null' if msgpostfix == None else ('"' + str(msgpostfix) +'"') )) + ','
                            payload = payload + '"mac":' + 'null' + ','
                            payload = payload + '"ip":' + 'null' + ','
                            payload = payload + '"phone":' + ('"' + str(msgphone) +'"')  + ','
                            payload = payload + '"stat":' + '0' + ','
                            payload = payload + '"optflag":' + '0' + ','
                            payload = payload + '"token":' + 'null' + ','
                            payload = payload + '"rectime":' + 'null' + ','
                            #payload = payload + '"rectime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                            payload = payload + '"sender":"' + macaddr + '",'
                            #payload = payload + '"netid":' + ('null' if netid == None else ('"' + str(netid) +'"') )  + ','
                            payload = payload + '"netid":"' + netid  + '",'
                            payload = payload + '"progid":"' + progid + '",'
                            #payload = payload + '"optime":' + 'null' + ','
                            payload = payload + '"optime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ','
                            payload = payload + '"sendtime":' + 'null' + ''
                            #payload = payload + '"sendtime":' + ('null' if msgrectime == None else ('"' + str(msgrectime).replace(' ','T') + str(tzone) +'"') ) + ''
                            payload = payload + '}' 
                            
                            print payload
                            #print headers
                            #print smsurl
                            
                            try:
                                #pass
                                response = requests.post(smsurl, data=payload, headers=headers)
                                #print response.status_code
                                if int(response.status_code) == 201 :
                                    optflag = "1"
                            except Exception,e:
                                print e
                                
                        except Exception,e:
                            print e                                
                    
                    #update authsms set sent flag
                    str_sql = "update authsms set stat = stat + 1 , \
                    sendtime = now(), optflag = " + optflag + "  \
                    where id = '" + str(msgid) +"'"
                    #print str_sql
                    try:
                        cursor1 = cnx.cursor()
                        cursor1.execute(str_sql)
                        cnx.commit()
                    except MySQLdb.Error as err:
                        print("update 'authsms' failed.")
                        print("Error: {}".format(err.args[1]))   
                    finally:
                        cursor1.close()          
            
            except MySQLdb.Error as err:
                print("select 'sms' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()
                

                    
            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    


