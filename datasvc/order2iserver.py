#!/usr/bin/env python
#encoding=utf-8

import os, sys, time, traceback
import xml.dom.minidom as minidom
import MySQLdb,  datetime, time
import subprocess
#import gammu
import requests, json
#from xml.etree.ElementTree import ElementTree, dump


if __name__ == '__main__':

    reload(sys)
    sys.setdefaultencoding('utf-8')
    
    #wait for mysql server is ready 
    time.sleep(45)

    #read configurations here

    dom = minidom.parse("orderupload.xml")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    for node in dom.getElementsByTagName("table1"):
        tbl1 = node.getAttribute("tblname")
        url1 = node.getAttribute("uri")
        tzone1 = node.getAttribute("tzone")
        interv1 = node.getAttribute("interv")
        #start1 = node.getAttribute("start")
    
    # connection for  mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db,charset='utf8')
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        sys.exit(0)  
    
  
    timeinterval = 10 # inner loop interval i

    try:
        #for k in range(1, 60, timeinterval): # for loop 4 times erery minutes
        while True: # while loop
            print "loop "
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

            #prepare prodorder list
            str_sql = "select id, username, prodcode, prodname, \
            prodtype, prodspec, proddesp, quan, unit, pkg, \
            recipaddr,recipname, recipphone1, recipphone2, recipemail, \
            assignto, delicode, delidesp, delimemo, \
            srcip, updtime, rectime, pushflag "
            str_sql = str_sql + " from " + tbl1
            str_sql = str_sql + " where  pushflag >= '1'"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                upd_sql = "update prodorder set pushflag = '0' where pushflag >='1'"
                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(upd_sql)
                    cnx.commit()
                except MySQLdb.Error as err:
                    print("update 'prodorder' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()     
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"username":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"prodcode":' + ('null' if datarow[2] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"prodname":' + ('null' if datarow[3] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"prodtype":' + ('null' if datarow[4] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"prodspec":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"proddesp":' + ('null' if datarow[6] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"quan":' + ('null' if datarow[7] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"unit":' + ('null' if datarow[8] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"pkg":'+ ('null' if datarow[9] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"recipaddr":' + ('null' if datarow[10] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"recipname":' + ('null' if datarow[11] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"recipphone1":' + ('null' if datarow[12] == None else ('"' + str(datarow[8]) +'"') ) + ','
                    payload = payload + '"recipphone2":' + ('null' if datarow[13] == None else ('"' + str(datarow[9]) +'"') ) + ','
                    payload = payload + '"recipemail":' + ('null' if datarow[14] == None else ('"' + str(datarow[10]) +'"') ) + ','
                    payload = payload + '"assignto":' + ('null' if datarow[15] == None else ('"' + str(datarow[11]) +'"') ) + ','
                    payload = payload + '"delicode":' + ('null' if datarow[16] == None else ('"' + str(datarow[12]) +'"') ) + ','
                    payload = payload + '"delidesp":' + ('null' if datarow[17] == None else ('"' + str(datarow[13]) +'"') ) + ','
                    payload = payload + '"delimemo":' + ('null' if datarow[18] == None else ('"' + str(datarow[14]) +'"') ) + ','
                    payload = payload + '"srcip":' + ('null' if datarow[19] == None else ('"' + str(datarow[15]) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    payload = payload + '"updtime":' + ('null' if datarow[20] == None else ('"' + str(datarow[28]).replace(' ','T') + str(tzone1) +'"') ) + ','
                    payload = payload + '"rectime":' + ('null' if datarow[21] == None else ('"' + str(datarow[29]).replace(' ','T') + str(tzone1) +'"') ) + ','
                    payload = payload + '"pushflag":' + ('null' if datarow[22] == None else ('"' + str(datarow[30]) +'"') ) 
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url1, data=payload, headers=headers)
                        #print response.status_code
                        if int(response.status_code) != 201 :
                            nflag = int(datarow[22]) if int(datarow[22]) >=32768  else (int(datarow[22]) + 32768) 
                            upd_sql = "update prodorder set pushflag = '" + str(nflag) +"'  where id = '" 
                            upd_sql = upd_sql + ('' if datarow[0] == None else  str(datarow[0]))  + "'"
                            print upd_sql
                            try:
                                cursor1 = cnx.cursor()
                                cursor1.execute(upd_sql)
                                cnx.commit()
                            except MySQLdb.Error as err:
                                print("update 'prodorder pushflag + 32768' failed.")
                                print("Error: {}".format(err.args[1]))   
                            finally:
                                cursor1.close()                                 
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'prodorder' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    


