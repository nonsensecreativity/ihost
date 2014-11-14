#!/usr/bin/env python
 
import os, sys, commands
import xml.dom.minidom as minidom
import MySQLdb,  datetime
import subprocess

#works together with push.php

if __name__ == '__main__':
        
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
                #line ="http://172.16.0.10/push.php 172.16.0.101/- - GET myip=172.16.0.1 myport=3128"
                #line ="http://www.sogou.com?%E5%8D%88%E9%A5%AD 172.16.0.11/- - GET myip=172.16.0.1 myport=3128"
                #line ="http://www.baidu.com 172.16.0.11/- - GET myip=172.16.0.1 myport=3128"
                
                new_url = "http://172.16.0.1/push/push.php"     
                new_url = new_url + "?site=" + (line.replace(" ", "%20")).replace("?", "&para=")
                new_url = new_url + '\n'
                
                sys.stdout.write(new_url)
                sys.stdout.flush() 
                    
            except Exception as e:
                print e
                pass
                
    except KeyboardInterrupt as err:
        print("\n---End of Loop---") 


