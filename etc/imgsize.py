#!/usr/bin/env python2
#-*-encoding:utf-8-*-

import subprocess, Image
import os, sys,  traceback

if __name__ == '__main__':
    
    # get new jpg or jpeg files in the last 1 minutes
    strpath ="/opt/id-images"
    strtime = 1 # last 1 minutes
    findcmd = "find  " + strpath + " -maxdepth 1 -regex \".*\\.\\(jpg\\|jpeg\\)\" -mmin -" + str(strtime)
    try:
        proc= subprocess.Popen(findcmd, stdout=subprocess.PIPE, shell = True)
        stdout = proc.communicate()
    except Exception as e:
        print str(e)
        traceback.print_exc()
        print("Error find file names")
        sys.exit(0)  
    #print stdout
    namelist = stdout[0].split("\n")
    #print namelist

    # resize if the size is larger than 32k
    for imgname in namelist:
        if len(imgname) !=0 :
            size=os.path.getsize(imgname)
            #print size
            if size > 32768 : # greater than 32k
                print imgname
                infile = imgname
                outfile = imgname
                try:
                    im = Image.open(infile)
                    (x,y) = im.size #read image size
                    if x >= y:
                        x_s = 480 #define standard width
                        y_s = y * x_s / x #calc height based on standard width
                    else :
                        y_s = 480
                        x_s = x * y_s / y
                    out = im.resize((x_s,y_s),Image.ANTIALIAS) #resize image with high-quality
                    out.save(outfile)
                except Exception as e:
                    print str(e)
                    traceback.print_exc()

    # delete png files created by fa detection
    delcmd = "rm  " + strpath + "/*.png"
    try:
        proc= subprocess.Popen(delcmd, stdout=None, shell = True)
    except Exception as e:
        print str(e)
        traceback.print_exc()
        sys.exit(0)


