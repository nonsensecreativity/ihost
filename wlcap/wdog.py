#!/usr/bin/env python

"""
This runs a check routin for all the subprocess running
"""

import os, traceback,  datetime,  time
import subprocess
import xml.dom.minidom as minidom
import MySQLdb

class ErrNoPid(Exception):
    def __init__(self, value):
        self.value = value
    def __str__(self):
        return repr(self.value)

def updatewlsta():
    global cnx,  gone,  losting
    
    strNow = str(datetime.datetime.now())
    #stat: 100-comming 200-staying 300-losting 
    str_gone = "delete from wlsta where \
            TIMESTAMPDIFF(SECOND, lastseen,'" + strNow + "') > '" + str(gone) +"'"
    str_losting = "update wlsta set stat = '300' where \
            TIMESTAMPDIFF(SECOND, lastseen,'" + strNow + "') > '" + str(losting) + "' and \
            TIMESTAMPDIFF(SECOND, lastseen,'" + strNow + "') <= '" + str(gone) + "' and  \
            stat <> '300'"  
    
    try:
        cursor = cnx.cursor()
        cursor.execute(str_gone)
        cnx.commit()
        cursor.execute(str_losting)
        cnx.commit()

    except MySQLdb.Error as err:
        print("insert record 'activepackets' failed.")
        print("Error: {}".format(err.args[1]))   
    finally:
        cursor.close()
 

if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("config.xml")
    
    for node in dom.getElementsByTagName("interface"):
        iftype = node.getAttribute("iftype")
        remotehost = node.getAttribute("host")
        ifname =node.getAttribute("ifname")
        pktpipe =node.getAttribute("pktpipe")
        
    for node in dom.getElementsByTagName("dbconn"):
        user = node.getAttribute("user")
        pwd =node.getAttribute("pwd")
        host = node.getAttribute("host")
        db = node.getAttribute("db")
    
    for node in dom.getElementsByTagName("ppdb"):
        losting = int(node.getAttribute("losting"))
        gone = int(node.getAttribute("gone"))
    
    
    if iftype == "remote":
        ifname = "rpcap://" + remotehost + "/" +ifname
        
    # Prepare wlcap string. Note remotehost is included in ifname already
    wlCapture = "wlcap -l"
    wlCapture = wlCapture + " -i " + ifname
    if iftype == "local" :
        wlCapture = wlCapture +" -f" + " \"subtype assoc-resp or subtype reassoc-resp or subtype probe-req or subtype disassoc\""
    wlCapture = wlCapture + " -T fields -E separator=, -E quote=d"
    # 0-frametime 1-protocal 2-rssi 3-subtype 4-da 5-sa 6-bssid 7-ssid
    wlCapture = wlCapture + " -e frame.time -e frame.protocols -e radiotap.dbm_antsignal -e ppi.80211-common.dbm.antsignal"
    wlCapture = wlCapture + " -e wlan.fc.type_subtype -e wlan.da -e wlan.sa -e wlan.bssid -e wlan_mgt.ssid"
    wlCapture = wlCapture + " > " + pktpipe
    # print out for check
    #print(wlCapture)
    
    #check pipe ready
    if not os.path.exists(pktpipe):
        os.mkfifo(pktpipe)
    
    # check running status of wlcap
    
    nochildflag = 0
    
    # wlcap child process
    try:
        shellcmd = "ps aux | grep \"wlcap -l -i "+ifname+"\" | grep -v grep | grep -v \"/sh \""
        ps= subprocess.Popen(shellcmd, stdout=subprocess.PIPE, shell = True)
        output = ps.stdout.read()[0:15]
        ps.stdout.close()
        wlcappid = 0
        try:
            wlcappid = [int(s) for s in str.split(output) if s.isdigit()][0]
            if wlcappid == 0:
                raise ErrNoPid(0)
        except Exception as e:
            raise ErrNoPid(0)
    except ErrNoPid as e:
        nochildflag = 1
    except Exception as e:
        nochildflag = 1
        print str(e)
        traceback.print_exc()
    finally:
        print(shellcmd, wlcappid)
      
    nofatherflag = 0
    
    # if no wlcap child process, check father (shell command)'s existence
    if nochildflag == 1:
        try:
            shellcmd = "ps aux | grep \"/sh -c wlcap -l -i "+ifname+"\" | grep -v grep "
            ps= subprocess.Popen(shellcmd, stdout=subprocess.PIPE, shell = True)
            output = ps.stdout.read()[0:15]
            ps.stdout.close()
            wlcappid = 0
            try:
                wlcappid = [int(s) for s in str.split(output) if s.isdigit()][0]
                if wlcappid == 0:
                    raise ErrNoPid(0)
            except Exception as e:
                raise ErrNoPid(0)
        except ErrNoPid as e:
            nofatherflag = 1
        except Exception as e:
            nofatherflag = 1
            print str(e)
            traceback.print_exc()
        finally:
            print(shellcmd, wlcappid)

    if nochildflag == 1 and nofatherflag == 1:
        try:
            # start wlcap process
            wlcapProc = subprocess.Popen(wlCapture, bufsize= 0, stdin= subprocess.PIPE, stdout= None, shell=True)
            # send return to start remote capture
            wlcapProc.stdin.write("\n")
            wlcapProc.poll()
            #get wlcapProc.returncode, None means alive
            if wlcapProc.returncode != None:
                raise Exception('Exception. subprocess.Popen error' )
        except Exception as e:
            print str(e)
            traceback.print_exc()
        
    # check running status of rdpp.py
    try:
        shellcmd = "ps aux | grep rdpp.py | grep -v grep | grep -v \"/sh \""
        ps= subprocess.Popen(shellcmd, stdout=subprocess.PIPE, shell = True)
        output = ps.stdout.read()[0:15]
        ps.stdout.close()
        rdpppid = 0
        try:
            rdpppid = [int(s) for s in str.split(output) if s.isdigit()][0]
        except Exception as e:
            raise ErrNoPid(0)
        if rdpppid == 0:
            raise ErrNoPid(0)
    except ErrNoPid as e:
            shellcmd = "python rdpp.py &"
            ps= subprocess.Popen(shellcmd, shell = True)
    except Exception as e:
        print str(e)
        traceback.print_exc()
    finally:
        print(shellcmd, rdpppid)    
        
    
    # connection for raspbian mysqldb, global
    try:
        cnx = MySQLdb.connect(host=host,user=user,passwd=pwd,db=db)
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error Opening mysql")
        
    updatewlsta()
    
    cnx.close()
