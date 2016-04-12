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
print("calendars: ")
print(calendars)

RRule = functions.parseRRule(txRRule)
print ("RRule: ")
print (RRule)
print("\n")

cal1 = classes.Calendar(calendars["janick@oakland.edu"], "in7.4.1776@gmail.com")
cal2 = classes.Calendar(calendars["in7.4.1776@gmail.com"], "in7.4.1776@gmail.com")
args1 = {
    "calendar":cal1,
    "startdate":functions.strpdate("2016-04-04", "%Y-%m-%d"),
    "enddate":functions.strpdate("2016-04-16", "%Y-%m-%d"),
    "starttime":functions.strptime("18:10:00", "%H:%M:%S"),
    "endtime":functions.strptime("23:59:59", "%H:%M:%S"),
    "granularity":30
}
args2 = {
    "calendar":cal2,
    "startdate":functions.strpdate("2016-04-04", "%Y-%m-%d"),
    "enddate":functions.strpdate("2016-04-16", "%Y-%m-%d"),
    "starttime":functions.strptime("18:10:00", "%H:%M:%S"),
    "endtime":functions.strptime("23:59:59", "%H:%M:%S"),
    "granularity":30
}

matrix1 = classes.CalendarMatrix("construct_from_calendar",args1)
matrix2 = classes.CalendarMatrix("construct_from_calendar",args2)
matrix3 = matrix1+matrix2

functions.construct_master_matrix(calendars, 30)