#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 10, 2016 3:30:13 AM$"

print ("test")
import sys
import json
import functions
import classes

dtStart = sys.argv[1]
dtEnd = sys.argv[2]
txLocation = sys.argv[3]
txRRule = sys.argv[4]
temp = open("C:/wamp/www/mesa/python/temp1.json", "r")
calendars = json.loads(temp.read())
temp.close()
temp = open("C:/wamp/www/mesa/python/temp2.json", "r")
blSettings = json.loads(temp.read())
temp.close()
print("settings: ")
print(blSettings)
print("calendars: ")
print(calendars)

RRule = functions.parseRRule(txRRule)
print ("RRule: ")
print (RRule)

test = classes.Calendar(calendars[0])

print (test)