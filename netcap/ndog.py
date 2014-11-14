#!/usr/bin/env python

"""
This runs a check routin for wlcap process and nlogger process
"""

import os, traceback,  datetime,  time
import subprocess
import xml.dom.minidom as minidom

class ErrNoPid(Exception):
    def __init__(self, value):
        self.value = value
    def __str__(self):
        return repr(self.value)

if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("configact.xml")
    
    for node in dom.getElementsByTagName("interface"):
        ifname = node.getAttribute("ifname")
        pktpipe = node.getAttribute("pktpipe")
        pktfilter = node.getAttribute("filter")
    
        
    # Prepare wlcap string. Note remotehost is included in ifname already
    wlCapture = "wlcap -l"
    wlCapture = wlCapture + " -i " + ifname
    wlCapture = wlCapture +" -f" + " \"" + pktfilter +"\""
    wlCapture = wlCapture + " -T fields -E separator=, -E quote=d"
    # 0-frametime 1-protocal 2-rssi 3-subtype 4-da 5-sa 6-bssid 7-ssid
    wlCapture = wlCapture + " -e frame.time -e eth.src -e ip.src -e ip.dst -e http.request.full_uri "
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
        shellcmd = "ps aux | grep nlogger.py | grep -v grep | grep -v \"/sh \""
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
            shellcmd = "python nlogger.py &"
            ps= subprocess.Popen(shellcmd, shell = True)
    except Exception as e:
        print str(e)
        traceback.print_exc()
    finally:
        print(shellcmd, rdpppid)    
