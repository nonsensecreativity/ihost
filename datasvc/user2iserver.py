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

    dom = minidom.parse("userupload.xml")
        
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
    for node in dom.getElementsByTagName("table2"):
        tbl2 = node.getAttribute("tblname")
        url2 = node.getAttribute("uri")
        tzone2 = node.getAttribute("tzone")
        interv2 = node.getAttribute("interv")
        #start2 = node.getAttribute("start")
    for node in dom.getElementsByTagName("table3"):
        tbl3 = node.getAttribute("tblname")
        url3 = node.getAttribute("uri")
        tzone3 = node.getAttribute("tzone")
        interv3 = node.getAttribute("interv")
        #start3 = node.getAttribute("start")
    

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
            '''
            dom = minidom.parse("userupload.xml")
            for node in dom.getElementsByTagName("table3"):
                start3 = node.getAttribute("start")
            try:
                #check 
                int(start3)
            except ValueError:
                start3 = '0'
                

            #prepare end time
            str_sql = "select id "
            str_sql = str_sql + " from " + tbl3
            str_sql = str_sql + " order by id desc limit 1 "
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                end3 = ""
                for (idlist) in cursor:
                    end3 = str(idlist[0])
                try:
                    int(end3)
                    #print end3
                except ValueError:
                    end3 = '0'
            except MySQLdb.Error as err:
                end3 = '0'
            finally:
                cursor.close()     
            if int(end3) > 0 : end3 = str(int(end3)+1)
            
            #for database rebuild
            if int(start3) > int(end3):
                start3 = '0'

            #write end values to xml
            for node in dom.getElementsByTagName("table3"):
                node.setAttribute("start", end3) 

            tmp_config = "userupload.xml"
            f = open(tmp_config, 'w')
            dom.writexml( f )
            f.close()
            '''
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

            #prepare useraccounts list
            str_sql = "select id,userid,srcnode,usercode,user_uuid,mac,\
            useremail1,useremail2,fname,lname,userrole,usertype,\
            integral,pntfactor,byear,bmonth,bday,gender,occup,orgn,\
            title,cid,ctype,regphone,phone,address,location,memo,updtime,rectime,\
            pushflag "
            str_sql = str_sql + " from " + tbl1
            str_sql = str_sql + " where  pushflag >= '1'"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                upd_sql = "update useraccounts set pushflag = '0' where pushflag >='1'"
                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(upd_sql)
                    cnx.commit()
                except MySQLdb.Error as err:
                    print("update 'useraccounts' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()     
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"userid":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"token":' + 'null' + ','
                    payload = payload + '"srcnode":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"usercode":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"user_uuid":' + ('null' if datarow[4] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"mac":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"userpass":' + 'null' + ','
                    payload = payload + '"useremail1":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"useremail2":'+ ('null' if datarow[7] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"question":' + 'null' + ','
                    payload = payload + '"answer":' + 'null' + ','
                    payload = payload + '"fname":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]) +'"') ) + ','
                    payload = payload + '"lname":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]) +'"') ) + ','
                    payload = payload + '"userrole":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]) +'"') ) + ','
                    payload = payload + '"usertype":' + ('null' if datarow[11] == None else ('"' + str(datarow[11]) +'"') ) + ','
                    payload = payload + '"integral":' + ('null' if datarow[12] == None else ('"' + str(datarow[12]) +'"') ) + ','
                    payload = payload + '"pntfactor":' + ('null' if datarow[13] == None else ('"' + str(datarow[13]) +'"') ) + ','
                    payload = payload + '"byear":' + ('null' if datarow[14] == None else ('"' + str(datarow[14]) +'"') ) + ','
                    payload = payload + '"bmonth":' + ('null' if datarow[15] == None else ('"' + str(datarow[15]) +'"') ) + ','
                    payload = payload + '"bday":' + ('null' if datarow[16] == None else ('"' + str(datarow[16]) +'"') ) + ','
                    payload = payload + '"gender":' + ('null' if datarow[17] == None else ('"' + str(datarow[17]) +'"') ) + ','
                    payload = payload + '"occup":' + ('null' if datarow[18] == None else ('"' + str(datarow[18]) +'"') ) + ','
                    payload = payload + '"orgn":' + ('null' if datarow[19] == None else ('"' + str(datarow[19]) +'"') ) + ','
                    payload = payload + '"title":' + ('null' if datarow[20] == None else ('"' + str(datarow[20]) +'"') ) + ','
                    payload = payload + '"cid":' + ('null' if datarow[21] == None else ('"' + str(datarow[21]) +'"') ) + ','
                    payload = payload + '"ctype":' + ('null' if datarow[22] == None else ('"' + str(datarow[22]) +'"') ) + ','
                    payload = payload + '"regphone":' + ('null' if datarow[23] == None else ('"' + str(datarow[23]) +'"') ) + ','
                    payload = payload + '"captcha":' + 'null' + ','
                    payload = payload + '"phone":' + ('null' if datarow[24] == None else ('"' + str(datarow[24]) +'"') ) + ','
                    payload = payload + '"address":' + ('null' if datarow[25] == None else ('"' + str(datarow[25]) +'"') ) + ','
                    payload = payload + '"location":' + ('null' if datarow[26] == None else ('"' + str(datarow[26]) +'"') ) + ','
                    payload = payload + '"action":' + 'null' + ','
                    payload = payload + '"stat":' + 'null' + ','
                    payload = payload + '"open1":' + 'null' + ','
                    payload = payload + '"open2":' + 'null' + ','
                    payload = payload + '"smscheck":' + 'null' + ','
                    payload = payload + '"memo":' + ('null' if datarow[27] == None else ('"' + str(datarow[27]) +'"') ) + ','
                    payload = payload + '"srcip":' + 'null' + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    payload = payload + '"intid":' + 'null' + ','
                    payload = payload + '"updtime":' + ('null' if datarow[28] == None else ('"' + str(datarow[28]).replace(' ','T') + str(tzone1) +'"') ) + ','
                    payload = payload + '"rectime":' + ('null' if datarow[29] == None else ('"' + str(datarow[29]).replace(' ','T') + str(tzone1) +'"') ) + ','
                    payload = payload + '"pushflag":' + ('null' if datarow[30] == None else ('"' + str(datarow[30]) +'"') ) 
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url1, data=payload, headers=headers)
                        #print response.status_code
                        if int(response.status_code) != 201 :
                            nflag = int(datarow[30]) if int(datarow[30]) >=64  else (int(datarow[30]) + 64) 
                            upd_sql = "update useraccounts set pushflag = '" + str(nflag) +"'  where id = '" 
                            upd_sql = upd_sql + ('' if datarow[0] == None else  str(datarow[0]))  + "'"
                            print upd_sql
                            try:
                                cursor1 = cnx.cursor()
                                cursor1.execute(upd_sql)
                                cnx.commit()
                            except MySQLdb.Error as err:
                                print("update 'useraccounts pushflag + 64' failed.")
                                print("Error: {}".format(err.args[1]))   
                            finally:
                                cursor1.close()                                 
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'useraccounts' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare usermacs list
            str_sql = "select id,userid,srcnode,usercode,mac,phone,userrole,\
            pntmaster,memo,updtime,rectime,pushflag "
            str_sql = str_sql + " from " + tbl2
            str_sql = str_sql + " where  pushflag >= '1'"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                upd_sql = "update usermacs set pushflag = '0' where pushflag >='1'"
                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(upd_sql)
                    cnx.commit()
                except MySQLdb.Error as err:
                    print("update 'usermacs' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()     
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"userid":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"token":'  + 'null' + ','
                    payload = payload + '"srcnode":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"usercode":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"mac":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"phone":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"stat":' + 'null' + ','
                    payload = payload + '"dft":' + 'null' + ','
                    payload = payload + '"prio":' + 'null' + ','
                    payload = payload + '"userrole":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    payload = payload + '"pntmaster":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"memo":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]) +'"') ) + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    payload = payload + '"updtime":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]).replace(' ','T') + str(tzone2) +'"') ) + ','
                    payload = payload + '"rectime":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]).replace(' ','T') + str(tzone2) +'"') ) + ','
                    payload = payload + '"pushflag":' + ('null' if datarow[11] == None else ('"' + str(datarow[11]) +'"') ) 
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url2, data=payload, headers=headers)
                        #print response.status_code
                        if int(response.status_code) != 201 :
                            nflag = int(datarow[11]) if int(datarow[11]) >=64  else (int(datarow[11]) + 64) 
                            upd_sql = "update usermacs set pushflag = '" + str(nflag) +"'  where id = '" 
                            upd_sql = upd_sql + ('' if datarow[0] == None else  str(datarow[0]))  + "'"
                            print upd_sql
                            try:
                                cursor1 = cnx.cursor()
                                cursor1.execute(upd_sql)
                                cnx.commit()
                            except MySQLdb.Error as err:
                                print("update 'usermacs pushflag + 64' failed.")
                                print("Error: {}".format(err.args[1]))   
                            finally:
                                cursor1.close()             
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'usermacs' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          

            #prepare useractive list
            str_sql = "select id,mac,phone,userrole,userid,IF(onsite=1,'true','false')onsite,\
            IF(online=1,'true','false'),macfirst,maclast,pagefirst,pagelast,updtime,rectime,pushflag "
            str_sql = str_sql + " from " + tbl3
            str_sql = str_sql + " where  pushflag >= '1'"
            #str_sql = str_sql + " where  (id >= '" + start3 +"'"
            #str_sql = str_sql + " and  id < '" + end3 +"')"
            #print str_sql
            try:
                cursor = cnx.cursor()
                cursor.execute(str_sql)
                cnx.commit()
                upd_sql = "update useractive set pushflag = '0' where pushflag >='1'"
                try:
                    cursor1 = cnx.cursor()
                    cursor1.execute(upd_sql)
                    cnx.commit()
                except MySQLdb.Error as err:
                    print("update 'useractive' failed.")
                    print("Error: {}".format(err.args[1]))   
                finally:
                    cursor1.close()     
                for (datarow) in cursor:
                    # Push msg data to rest service
                    headers = {"content-type":"application/json;charset=UTF-8"}
                    payload = '{'
                    payload = payload + '"id":' + '0' + ','
                    payload = payload + '"srcid":' + ('null' if datarow[0] == None else ('"' + str(datarow[0]) +'"') ) +  ','
                    payload = payload + '"mac":' + ('null' if datarow[1] == None else ('"' + str(datarow[1]) +'"') ) +  ','
                    payload = payload + '"phone":' + ('null' if datarow[2] == None else ('"' + str(datarow[2]) +'"') )  + ','
                    payload = payload + '"userrole":' + ('null' if datarow[3] == None else ('"' + str(datarow[3]) +'"') ) + ','
                    payload = payload + '"userid":' + ('null' if datarow[4] == None else ('"' + str(datarow[4]) +'"') ) + ','
                    payload = payload + '"onsite":' + ('null' if datarow[5] == None else ('"' + str(datarow[5]) +'"') ) + ','
                    payload = payload + '"online":' + ('null' if datarow[6] == None else ('"' + str(datarow[6]) +'"') ) + ','
                    #payload = payload + '"macfirst":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]) +'"') ) + ','
                    payload = payload + '"macfirst":' + ('null' if datarow[7] == None else ('"' + str(datarow[7]).replace(' ','T') + str(tzone3) +'"') ) + ','
                    payload = payload + '"macmark":' + 'null' + ','
                    #payload = payload + '"maclast":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]) +'"') ) + ','
                    payload = payload + '"maclast":' + ('null' if datarow[8] == None else ('"' + str(datarow[8]).replace(' ','T') + str(tzone3) +'"') ) + ','
                    #payload = payload + '"pagefirst":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]) +'"') ) + ','
                    payload = payload + '"pagefirst":' + ('null' if datarow[9] == None else ('"' + str(datarow[9]).replace(' ','T') + str(tzone3) +'"') ) + ','
                    payload = payload + '"pagemark":' + 'null' + ','
                    #payload = payload + '"pagelast":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]) +'"') ) + ','
                    payload = payload + '"pagelast":' + ('null' if datarow[10] == None else ('"' + str(datarow[10]).replace(' ','T') + str(tzone3) +'"') ) + ','
                    payload = payload + '"updby":' + 'null' + ','
                    payload = payload + '"insby":' + 'null' + ','
                    payload = payload + '"srcip":' + 'null' + ','
                    payload = payload + '"sender":"' + macaddr + '",'
                    payload = payload + '"netid":"' + netid  + '",'
                    payload = payload + '"progid":"' + progid + '",'
                    payload = payload + '"updtime":' + ('null' if datarow[11] == None else ('"' + str(datarow[11]).replace(' ','T') + str(tzone3) +'"') ) + ','
                    payload = payload + '"rectime":' + ('null' if datarow[12] == None else ('"' + str(datarow[12]).replace(' ','T') + str(tzone3) +'"') ) + ','
                    payload = payload + '"pushflag":' + ('null' if datarow[13] == None else ('"' + str(datarow[13]) +'"') ) 
                    payload = payload + '}' 
                    
                    print payload
                    try:
                        #pass
                        response = requests.post(url3, data=payload, headers=headers)
                        #print response.status_code
                        if int(response.status_code) != 201 :
                            nflag = int(datarow[13]) if int(datarow[13]) >=64  else (int(datarow[13]) + 64) 
                            upd_sql = "update useractive set pushflag = '" + str(nflag) +"'  where id = '" 
                            upd_sql = upd_sql + ('' if datarow[0] == None else  str(datarow[0]))  + "'"
                            print upd_sql
                            try:
                                cursor1 = cnx.cursor()
                                cursor1.execute(upd_sql)
                                cnx.commit()
                            except MySQLdb.Error as err:
                                print("update 'useractive pushflag + 64' failed.")
                                print("Error: {}".format(err.args[1]))   
                            finally:
                                cursor1.close() 
                    except Exception,e:
                        print e

            except MySQLdb.Error as err:
                print("select 'useractive' failed.")
                print("Error: {}".format(err.args[1]))   
            finally:
                cursor.close()          


            time.sleep(timeinterval)
            
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()    


