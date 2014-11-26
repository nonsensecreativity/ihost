#!/usr/bin/env python

"""
This runs a command on a remote host using SSH.
"""

import sys, time, pexpect,  traceback
import subprocess
import xml.dom.minidom as minidom

def sshcmd (user, password, host, port, ifname, setorget):
    """
    This runs a command on the remote Ruckus AP. This handles the case when you try to
    connect to a new host and ssh asks you if you want to accept the public key
    fingerprint and continue connecting.
    """
    if port != '':
        host = "-p "+ port + " " + host
        
    setcmd = 'set capture ' + ifname + ' stream-nobcp'
    getcmd = 'get capture ' + ifname + ' state'
    sucflag = 'Packet Capture state: stream-nobeacon-nocontrol-nopromiscuous'
    failflag = 'Packet Capture state: idle'
    ssh_newkey = 'Are you sure you want to continue connecting'
    # Create a new spawn object.
    child = pexpect.spawn('ssh %s' % (host))
       
    i = child.expect([pexpect.TIMEOUT, ssh_newkey, 'Please login:'])
    
    # timeout: print and quit
    if i == 0: # Timeout
        print 'ERROR!'
        print 'No SSH_newkey nor login received. Here is what SSH said:'
        print child.before, child.after
        return None
    # no ssh public key, accept
    if i == 1: # SSH does not have the public key. Just accept it.
        child.sendline ('yes')
        i = child.expect([pexpect.TIMEOUT, 'Please login:'])
        if i == 0: # Timeout
            print 'ERROR!'
            print 'No login after SSH_newkey. Here is what SSH said:'
            print child.before, child.after
            return None
        # send username
        child.sendline(user)
    # login:
    if i == 2: # login
        child.sendline (user)

    i = child.expect([pexpect.TIMEOUT, 'password :'])
    if i == 0: # Timeout
        print 'ERROR!'
        print 'No password after login. Here is what SSH said:'
        print child.before, child.after
        return None
    # send password
    child.sendline(password)

    if setorget == 1:
        i = child.expect([pexpect.TIMEOUT, 'rkscli:'])    
        if i == 0: # Timeout    
            print 'ERROR!'    
            print 'No rkscli for set after password. Here is what SSH said:'    
            print child.before, child.after    
            return None    
        # send cmd
        child.sendline(setcmd)
        
        i = child.expect([pexpect.TIMEOUT, 'rkscli:'])    
        if i == 0: # Timeout    
            print 'ERROR!'    
            print 'No rkscli after SETcmd. Here is what SSH said:'    
            print child.before, child.after
            child.sendcontrol('d')
            return None    
    else:
        i = child.expect([pexpect.TIMEOUT, 'rkscli:'])
        if i == 0: # Timeout    
            print 'ERROR! rkscli timeout'
            print 'No rkscli for get after password.. Here is what SSH said:'
            print child.before, child.after
            return None
        # send cmd
        child.sendline(getcmd)

        i = child.expect([pexpect.TIMEOUT, failflag, sucflag])
        if i == 0: # Timeout    
            print 'ERROR!'
            print 'Timeout after GETcmd. Here is what SSH said:'        
            print child.before, child.after
            child.sendcontrol('d')
            return None
        if i == 1: # failflag    
            print 'ERROR!'
            print 'Fail flag after GETcmd. Here is what SSH said:'
            print child.before, child.after
            child.sendcontrol('d')
            return None
        
    return child



def setget (setorget):
    global uname, passwd, hname, port, ifname
    # excute
    child = sshcmd (uname, passwd, hname, port, ifname, setorget)
    if child == None:
        
        #try to kill wlcap process if it is running
        try:
            shellcmd = "ps aux | grep \"wlcap -l -i rpcap://"+hname+"/"+ifname+"\" | grep -v grep | grep -v \"/sh \""
            ps= subprocess.Popen(shellcmd, stdout=subprocess.PIPE, shell = True)
            output = ps.stdout.read()[0:15]
            ps.stdout.close()            
            try:
                wlcappid = [int(s) for s in str.split(output) if s.isdigit()][0]
            except Exception as e:
                raise Exception("wlcap not found")
            if wlcappid > 0:
                shellcmd = "kill " + str(wlcappid)
                ps= subprocess.Popen(shellcmd, shell = True)
                print("killed wlcap process : ", wlcappid)
        except Exception as e:
            print str(e)
            traceback.print_exc()
        
        # go on ssh ruckus
        print 'Failed at : ', 'Set' if setorget == 1 else 'Get'
        raise Exception('Exception. Failed at : ', 'Set' if setorget == 1 else 'Get' )  
        
    else:
        child.sendcontrol('d')
    
    # wait for eof
    child.expect(pexpect.EOF)
    # print out
    print 'Sucess : EOF of ','Set' if setorget == 1 else 'Get',child.before

if __name__ == '__main__':
    
    #read configurations here
    dom = minidom.parse("configsrks.xml")
    for node in dom.getElementsByTagName("interface"):
        iftype = node.getAttribute("iftype")
        hname = node.getAttribute("host")
        ifname =node.getAttribute("ifname")
        
    for node in dom.getElementsByTagName("ssh"):
        uname = node.getAttribute("user")
        passwd =node.getAttribute("passwd")
        port = node.getAttribute("port")
        
    if iftype == 'remote':
        #try get state first, if failed, try set capture
        try:
            setget(0) # get state. if sucessful, exit
            
        # get state failed. either by raise() or by system "pexpect" timeout
        except Exception as e:
            print str(e)
            traceback.print_exc()
            try:
                setget(1) # try set capture
            except Exception as e:
                print str(e)
                traceback.print_exc()
