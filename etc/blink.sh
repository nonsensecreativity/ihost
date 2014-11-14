#!/bin/bash

workingLED=55
echo out > /sys/class/gpio/gpio${workingLED}/direction

while true
do
    echo 1 > /sys/class/gpio/gpio${workingLED}/value
    usg=$(top -bn 1 | awk '{print $9}' | tail -n +8 | awk '{s+=$1} END {print s}')
    tmp=$(($usg / 20))
    iusg=$(( $tmp + 1 ))
    intvl=$(echo $iusg | awk '{printf "%.3f \n", 1/$usg}')
    echo 0 > /sys/class/gpio/gpio${workingLED}/value
    sleep $(echo $intvl | awk '{printf "%.3f \n", $intvl/1}')
done
