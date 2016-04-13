#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 9, 2016 11:56:14 PM$"

def construct_master_matrix(blCalendar, granularity):
    import classes
    attendees = blCalendar["attendance"]
    MasterMatrix = []
    i = 0
    for attendee in attendees:
        args = {
            "rawcalendar":blCalendar[attendee],
            "owner":attendee,
            "granularity":granularity
        }
        matrix = classes.CalendarMatrix("construct_from_blcalendar", args)
        if(i==0):
            MasterMatrix = matrix
        else:
            MasterMatrix = classes.CalendarMatrix("construct_from_union", {"self":MasterMatrix,"other":matrix})
        i+=1
    return MasterMatrix

def index(list, search):
    index = 0
    for item in list:
        if (item == search):
            return index
        index+=1
    return -1

def is_number(test):
    try:
        float(test)
        return True
    except ValueError:
        return False

def maxdate(dates):
    from datetime import date
    maxdate = date.min
    for when in dates:
        if(when>maxdate):
            maxdate = when
    return maxdate

def maxtime(times):
    from datetime import time
    maxtime = time.min
    for when in times:
        if(when>maxtime):
            maxtime = when
    return maxtime

def mindate(dates):
    from datetime import date
    mindate = date.max
    for when in dates:
        if(when<mindate):
            mindate = when
    return mindate

def mintime(times):
    from datetime import time
    mintime = time.max
    for when in times:
        if(when<mintime):
            mintime = when
    return mintime

def parseRRule(txRRule):
    if(txRRule != ""):
        rules = txRRule.split(";")
        RRule = {}
        for rule in rules:
            if(rule != ""):
                keyval = rule.split("=")
                if(keyval[1].isdigit()):
                    RRule[keyval[0]] = int(keyval[1])
                else:
                    RRule[keyval[0]] = keyval[1]
        return RRule
    else:
        return txRRule

def strpdate(string, format):
    from datetime import datetime
    format += "T%H:%M:%S"
    return datetime.strptime(string+"T00:00:00", format).date()

def strptime(string, format):
    from datetime import datetime
    format = "%Y-%m-%dT" + format
    return datetime.strptime("2016-01-01T"+string, format).time()

def swap(a, b):
    temp = a
    a = b
    b = temp
    return {"newa":a,"newb":b}