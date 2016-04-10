#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 10, 2016 3:30:29 AM$"

import json
import math
from datetime import datetime, date, time, timedelta

class Matrix:
    def __init__(self, startdate, enddate, starttime, endtime, granularity):
        rows = math.ceil(((endtime-starttime).seconds)/(granularity*60))
        cols = (enddate-startdate).days + (1 if (enddate-startdate).seconds%86400!=0 else 0)
        self.matrix = [[0 for x in range(cols)] for x in range(rows)]
        self.dates = [0 for x in range(cols)]
        self.times = [0 for x in range(rows)]
        for j in range(cols):
            self.dates[j] = (startdate+timedelta(days=1*j)).strftime("%Y-%m-%d")
        for i in range(rows):
            self.times[i] = (starttime+timedelta(minutes=granularity*i)).strftime("%H:%M:%S")
    
    def __str__(self):
        output = ""
        for row in range(len(self.matrix)):
            output+="["
            for col in range(len(self.matrix[0])):
                output+=str(self.matrix[row][col])+" "
            output+="]\n"
        return output

class CalendarMatrix(Matrix):
    def __init__(self, calendar, startdate, enddate, starttime, endtime, granularity):
        if(isinstance(calendar, Calendar)):
            Matrix.__init__(self, startdate, enddate, starttime, endtime, granularity)
#            for event in calendar.events:
                
        else:
            raise TypeError("Incorrect class supplied at argument: calendar. Please use a Calendar object")
    
    def __str__(self):
        return Matrix.__str__(self)

class Calendar:
    def __init__(self, blCalendar, owner):
        calendar = json.loads(blCalendar)
        self.email = owner
        self.events = []
        for event in calendar:
            self.events.append(_Event(event))
            
    def __str__(self):
        output = "["
        for event in self.events:
            output+="{\"calendar_email\":\""+self.email+"\","+str(event)+"},"
        output = output[:-1]+"]";
        return output
    
class _Event:

    def __init__(self, blEvent):
        self.start = datetime.strptime(blEvent["start_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.end = datetime.strptime(blEvent["end_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.location = blEvent["location"]
        self.travelTime = int(blEvent["travel_time"])

    def __str__(self):
        output = "\"start_time\":\""+self.start.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"end_time\":\""+self.end.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"location\":\""+self.location+",\"travel_time\":"+str(self.travelTime)+""
        return output

    def isBusy(self, when):
        if(when > self.start and when < self.end):
            return True
        else:
            return False