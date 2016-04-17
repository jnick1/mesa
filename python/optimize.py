#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 10, 2016 3:30:13 AM$"

print ("test")
import sys
import json
from datetime import datetime, date, time
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

RRule = functions.parseRRule(txRRule)
print ("RRule: ")
print (RRule)
print("\n")

priorities = functions.parsePriorities(blSettings)
originalEvent = classes.Event("blevent", {"blEvent":{"start_time":dtStart.replace(" ", "T")+"Z", "end_time":dtEnd.replace(" ", "T")+"Z", "location":txLocation, "travel_time":0}})
modifiedMatrix = functions.construct_modified_matrix(calendars, blSettings, 30)

