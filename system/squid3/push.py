#!/usr/bin/env python
 
import os, sys, commands
import xml.dom.minidom as minidom
import MySQLdb,  datetime
import subprocess


if __name__ == '__main__':
    
    dbserver = "127.0.0.1"
    dbuser = "proxy"
    dbpasswd = "proxyatussp"
    dbname = "wlsp"
    
    proxyip = "172.16.0.1"
    proxyport = "3128"
    
    try:
        cnx = MySQLdb.connect(host=dbserver,user=dbuser,passwd=dbpasswd,db=dbname)
    except Exception as e:
        print str(e)
        print("Error Opening mysql")
        sys.exit(0)  
        
    try:
        while True:
            try:
                # the format of the line read from stdin is
                # URL ip-address/fqdn ident method
                # for example
                # http://www.baidu.com 172.16.0.111/- - GET myip=192.168.1.127 myport=3128
                # dest url                    requester                  squid
                line = sys.stdin.readline().strip()
                # for test run
                #line ="http://www.baidu.com/#wd=supper& 172.16.0.10/- - GET myip=172.16.0.1 myport=3128"
                #line ="http://172.16.0.1/hdr.php 172.16.0.10/- - GET myip=172.16.0.1 myport=3128"
                #line ="http://www.sogou.com?%E5%8D%88%E9%A5%AD 172.16.0.11/- - GET myip=172.16.0.1 myport=3128"
                #line ="http://www.baidu.com 172.16.0.11/- - GET myip=172.16.0.1 myport=3128"



                #print line
                new_url = line.split(' ')[0] + '\n'
                srcip = line.split(' ')[1].split("/")[0]
                
                select_redir_sql="SELECT rurl, rurltoken \
                    FROM pushrurl WHERE active = 1  \
                    and (srcip =  '" +  srcip  + "'  \
                    or srcip =  'default') \
                    and TIMESTAMPDIFF(SECOND, ftime, now()) < dura  \
                    order by prio desc, type desc, id desc limit 1"
                
                #print select_redir_sql
                
                try:
                    cursor = cnx.cursor()
                    cursor.execute(select_redir_sql)
                    cnx.commit()
                    redirurl = cursor.fetchall()
                except MySQLdb.Error as err:
                    pass
                    #print("select 'rurl, rurltoken' failed.")
                    #print("Error: {}".format(err.args[1])) 
                finally:
                    cursor.close()
                #print redirurl
                if len(redirurl) != 0 :
                    if redirurl[0][1] != None: 
                        if not(redirurl[0][1]  in new_url and redirurl[0][0] != ""):        
                            new_url = redirurl[0][0] +"\n"
                            #new_url = new_url + "?site=" + (line.replace(" ", "%20")).replace("?", "&para=")
                            #new_url = new_url + "?site=" + ((line.replace(" ", "%20")).replace("?", "&para=")).split("-")[0]
                            
                            #new_url = "http://172.16.0.1/push.php"     
                            #new_url = new_url + "?site=" + (line.replace(" ", "%20")).replace("?", "&para=")
                            #new_url = new_url + '\n'

                            #sys.stdout.write(new_url)
                            #sys.stdout.flush() 
                else:
                    # clear iptables
                    shellcmd = "sudo iptables -t nat -D PREROUTING -s  " + srcip + "  \
                    -p tcp --dport 80  -j DNAT --to  " + proxyip + ":" + proxyport
                    ps = subprocess.Popen(shellcmd, shell = True)
                 
   
                #new_url = "http://172.16.0.1/push.php"     
                #new_url = new_url + "?site=" + (line.replace(" ", "%20")).replace("?", "&para=")
                #new_url = new_url + '\n'
                #print new_url
                sys.stdout.write(new_url)
                sys.stdout.flush() 
                    
            except Exception as e:
                #print e
                pass
                
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 
        cnx.close()

