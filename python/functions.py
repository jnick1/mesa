#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

#constructs the calendar set from calendar data
def construct_calendar_set(blCalendar):
    import classes
    import copy
    attendees = blCalendar["attendance"]
    attendeesCalendarData = {}
    for attendee in attendees:
        print(str(attendee) + " : " + str(attendees[attendee]))
        attendeesCalendarData[attendee] = classes.Calendar(blCalendar[attendee], attendee, attendees[attendee])
    calendarSet = classes.CalendarSet(attendeesCalendarData)
    return calendarSet

#performs the same function as index, but performs a binary search at O(log(n))
#   Assume that list is sorted from lowest to highest.
def binary_index(list, search):
#    return _rbinary_index(list, 0, len(list)-1, search)
    start = 0
    end = len(list)-1
    while(start<end):
        mid = (start+end)//2
        if(list[mid]==search):
            return mid
        elif(list[mid]<search):
            start = mid+1
        else:
            end = mid-1
    return -1

#returns the position in a list of a given item, -1 if not found
def index(list, search):
    index = 0
    for item in list:
        if (item == search):
            return index
        index+=1
    return -1

#returns True if a string is a number (float parsable)
def is_number(test):
    try:
        float(test)
        return True
    except ValueError:
        return False

#returns the latest date in a list of dates
def maxdate(dates):
    from datetime import date
    maxdate = date.min
    for when in dates:
        if(when>maxdate):
            maxdate = when
    return maxdate

#returns the latest time in a list of times
def maxtime(times):
    from datetime import time
    maxtime = time.min
    for when in times:
        if(when>maxtime):
            maxtime = when
    return maxtime

#returns the earliest date in a list of dates
def mindate(dates):
    from datetime import date
    mindate = date.max
    for when in dates:
        if(when<mindate):
            mindate = when
    return mindate

#returns the earliest time in a list of times
def mintime(times):
    from datetime import time
    mintime = time.max
    for when in times:
        if(when<mintime):
            mintime = when
    return mintime

#parses blSettings into a dictionary of priorities
def parsePriorities(blSettings):
    priorities = {
        "time":         1,
        "date":         2,
        "duration":     3,
        "repeat":       4,
        "location":     5,
        "granularity":  6,
        "attendees":    7,
    }
    if(not blSettings["useDefault"]):
        if(blSettings["time"]):
            priorities["time"] = priorities["time"]*int(blSettings["time"]["prioritization"])
        if(blSettings["date"]):
            priorities["date"] = priorities["date"]*int(blSettings["date"]["prioritization"])
        if(blSettings["duration"]):
            priorities["duration"] = priorities["duration"]*int(blSettings["duration"]["prioritization"])
        if(blSettings["repeat"]):
            priorities["repeat"] = priorities["repeat"]*int(blSettings["repeat"]["prioritization"])
        if(blSettings["location"]):
            priorities["location"] = priorities["location"]*int(blSettings["location"]["prioritization"])
        if(blSettings["attendees"]):
            priorities["attendees"] = priorities["attendees"]*int(blSettings["attendees"]["prioritization"])
    return priorities

#parses txRRule into a dictionary
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

#converts a string representing a date into a date based on a given format
def strpdate(string, format):
    from datetime import datetime
    format += "T%H:%M:%S"
    return datetime.strptime(string+"T00:00:00", format).date()

#converts a string representing a time into a time based on a given format
def strptime(string, format):
    from datetime import datetime
    format = "%Y-%m-%dT" + format
    return datetime.strptime("2016-01-01T"+string, format).time()

#returns a dictionary of swapped values
def swap(a, b):
    import copy
    return {"newa":copy.deepcopy(b),"newb":copy.deepcopy(a)}