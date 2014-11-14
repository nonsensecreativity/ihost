def updblklist(device, blklist, unblkflag):
    """
    This runs a command on the remote Ruckus AP. This handles the case when you try to
    connect to a new host and ssh asks you if you want to accept the public key
    fingerprint and continue connecting.
    """
    #device structer
    #[u'192.168.1.251', u'super', u'sp-admin', u'22', [u'wlan0', u'wlan1']]
    host = device[0]
    user = device[1]
    password = device[2]
    port = device[3]
    wlan = device[4]
    print user,password,host,port,wlan,blklist, unblkflag
  
    if port != '':
        host = "-p "+ port + " " + host
        
    sucflag = 'OK'
    failflag = 'parameter error'
    ssh_newkey = 'want to continue'
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

    i = child.expect([pexpect.TIMEOUT, 'rkscli:'])
    if i == 0: # Timeout    
        print 'ERROR!'
        print 'No rkscli for set after password. Here is what SSH said:'
        print child.before, child.after
        return None
    for j in range(0,len(blklist),1):
        if unblkflag == 0:
            stract = "add"
        else:
            stract = "delete"
        for wlanname in wlan:
            setcmd = 'set acl ' + wlanname + ' mac ' + stract + '  '
            setcmd = setcmd + blklist[j].replace("'", "")
            print wlanname, j, setcmd    
            # send cmd
            child.sendline(setcmd)
            i = child.expect([pexpect.TIMEOUT, 'rkscli:'])
            if i == 0: # Timeout    
                print 'ERROR!'
                print 'No rkscli after set acl . Here is what SSH said:'
                print child.before, child.after
                
        