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
import Classes
import SClass
#import SOptCode


print ("hello")
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


test = Classes.Calendar(calendars["janick@oakland.edu"], "in7.4.1776@gmail.com")
test2 = Classes.CalendarMatrix(test, datetime.strptime("2016-04-04T18:30:00Z", "%Y-%m-%dT%H:%M:%SZ"), datetime.strptime("2016-04-08T18:30:00Z", "%Y-%m-%dT%H:%M:%SZ"), datetime.strptime("2016-04-08T08:00:00Z", "%Y-%m-%dT%H:%M:%SZ"),datetime.strptime("2016-04-08T23:59:59Z", "%Y-%m-%dT%H:%M:%SZ"),30)
print (test)

Priority = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
DAYS = [0, 1, 2, 3, 4, 5, 6] #specific days wanted
print ("{3}/n")





cal1 = classes.Calendar(calendars["janick@oakland.edu"], "in7.4.1776@gmail.com")
cal2 = classes.Calendar(calendars["in7.4.1776@gmail.com"], "in7.4.1776@gmail.com")
args1 = {
    "calendar":cal1,
    "startdate":datetime.strptime("2016-04-04T18:30:00Z", "%Y-%m-%dT%H:%M:%SZ"),
    "enddate":datetime.strptime("2016-04-16T20:00:00Z", "%Y-%m-%dT%H:%M:%SZ"),
    "starttime":functions.strptime("18:10:00", "%H:%M:%S"),
    "endtime":functions.strptime("23:59:59", "%H:%M:%S"),
    "granularity":30
}
args2 = {
    "calendar":cal2,
    "startdate":datetime.strptime("2016-04-04T18:30:00Z", "%Y-%m-%dT%H:%M:%SZ"),
    "enddate":datetime.strptime("2016-04-16T20:00:00Z", "%Y-%m-%dT%H:%M:%SZ"),
    "starttime":functions.strptime("18:10:00", "%H:%M:%S"),
    "endtime":functions.strptime("23:59:59", "%H:%M:%S"),
    "granularity":30
}
matrix1 = classes.CalendarMatrix(args1)
matrix2 = classes.CalendarMatrix(args2)
matrix3 = matrix1+matrix2

print(matrix3.print_labeled())
print (cal1)
print("testing my code")


