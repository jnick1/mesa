#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

if __name__ == "__main__":
    print "Hello World"

 end = 5 #object
 start = 6 #object
 attendies = {2, 3, 4, 4} #list of people 
 location = "place"
 reoccurance = {} #list of the number of times it happens, and holds multiple meetings
 
 searchWidth = 7 #user based input
 granularity = 1 #hour, can also be wither 15mins or 1 mins depending on user input
 bannedtimes = 8 #banned granularity increments based on user input
 
 #matrices necessary 
 masterCalender = (searchWidth, (24/granularity) - bannedtimes)
 normCalender = (searchWidth, (24/granularity) - bannedtimes)
 
 for(i = 0; i<searchWidth; i++)
 {
    for(j=0; j<(24/granularity) - bannedtimes; j+granularity)
    {
        #if there is an evern
            NormCalender(i,j) = 1
        #else
            
    }
 }
    
 
 
 

