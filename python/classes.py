#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 10, 2016 3:30:29 AM$"

import json
from datetime import datetime, date, time

class CalendarMatrix:
    def __init__(self, calendar):
        print("")

class Calendar:
    def __init__(self, blCalendar):
        calendar = json.loads(blCalendar)
        self.email = calendar[0]["calendar_email"]
        self.events = []
        for event in calendar:
            self.events.append(_Event(event))
            print(_Event(event))
    
class _Event:

    def __init__(self, blEvent):
        self.start = datetime.strptime(blEvent["start_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.end = datetime.strptime(blEvent["end_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.location = blEvent["location"]
        self.travelTime = int(blEvent["travel_time"])

    def __str__(self):
        output = "{\"start_time\":\""+self.start.format("%Y-%m-%dT%H:%M:%SZ")+"\",\"end_time\":\""+self.end.format("%Y-%m-%dT%H:%M:%SZ")+"\",\"location\":\""+self.location+",\"travel_time\":"+self.travelTime+"}"
        return output #error here with above statement (formet doesn't exist), will have to fix later

    def isBusy(self, when):
        if(when > self.start and when < self.end):
            return True
        else:
            return False