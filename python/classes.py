#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

import json
from datetime import datetime, date, time, timedelta

class CalendarSet:
    def __init__(self, calendarList):
        self.calendarList = calendarList
    
    def is_required_attendees_busy(self, when, duration):
        for attendee in self.calendarList:
            if not self.calendarList[attendee].optional and self.calendarList[attendee].is_busy_for_duration(when, duration):
                return True
        return False
    
    def available_attendees(self, when, duration):
        availableAttendees = []
        for attendee in self.calendarList:
            if not self.calendarList[attendee].is_busy_for_duration(when, duration):
                availableAttendees.append(attendee)
        return availableAttendees
    
    def calculate_time_bound_start(self, granularity):
        start = datetime.max
        for attendee in self.calendarList:
            earliestInCalendar = datetime.combine(self.calendarList[attendee].earliest_date(), self.calendarList[attendee].calculate_time_bound_start(granularity))
            if(earliestInCalendar < start):
                start = earliestInCalendar
        return start
    
    def calculate_time_bound_end(self, granularity):
        end = datetime.min
        for attendee in self.calendarList:
            latestInCalendar = datetime.combine(self.calendarList[attendee].latest_date(), self.calendarList[attendee].calculate_time_bound_end(granularity))
            if(latestInCalendar > end):
                end = latestInCalendar
        return end

class Calendar:
    #instantiates a new Calendar object from raw json data
    #
    #requires:
    #   blCalendar is raw json data
    #   owner is a string
    #   optional is True or False
    def __init__(self, blCalendar, owner, optional):
        calendar = json.loads(blCalendar)
        self.email = owner
        self.optional = optional
        self.events = []
        for event in calendar:
            self.events.append(Event("blevent", {"blEvent":event}))
    
    #returns the number of events in this Calendar object
    def __len__(self):
        return len(self.events)
    
    #returns a json-formatted string representing this Calendar object
    def __str__(self):
        output = "["
        for event in self.events:
            output+="{\"calendar_email\":\""+self.email+"\","+str(event)+"},"
        output = output[:-1]+"]";
        return output
    
    #Performs a more advanced/thorough search of the earliest time in a calendar
    #   While the below functions do well to find the earliest time that any
    #   event starts at in a calendar, they only consider when an event starts.
    #   If an event starts too close to the end of the day, i.e. 23:30:00, and
    #   runs until, say 01:00:00, the below methods won't consider the time
    #   between as the earliest time an event occurs (the desired answer of
    #   00:00:00 should be returned). This method corrects this.
    #
    #requires: granularity is an int > 0, < 1440
    def calculate_time_bound_start(self, granularity):
        import copy
        prototime = self.earliest_time()
        startdate = self.earliest_date()
        enddate = self.latest_date()
        
        prototime = (datetime.combine(startdate, prototime)+timedelta(minutes=(granularity-prototime.minute%granularity)%granularity)).time()
        starttime = copy.deepcopy(prototime)
        width = (enddate - startdate).days+2
        for i in range(width):
            while(True):
                if(self.is_busy(datetime.combine(startdate, prototime)+timedelta(days=i))):
                    starttime = copy.deepcopy(prototime)
                if(prototime == time(hour=0,minute=0)):
                    break
                prototime = (datetime.combine(startdate, prototime)-timedelta(minutes=granularity)).time()
            if(starttime == time(hour=0,minute=0)):
                break
            prototime = copy.deepcopy(starttime)
        return starttime
    
    #Performs a more advanced/thorough search of the latest time in a calendar
    #   Similar to calculate_time_bound_start, this method will perform a check
    #   for busy-ness to find the latest time any event in a calendar occurs.
    #
    #requires: granularity is an int > 0, < 1440
    #
    #See also: calculate_time_bound_start
    def calculate_time_bound_end(self, granularity):
        import copy
        prototime = self.latest_time()
        startdate = self.earliest_date()
        enddate = self.latest_date()
        
        prototime = (datetime.combine(startdate, prototime)-timedelta(minutes=prototime.minute%granularity)).time()
        endtime = copy.deepcopy(prototime)
        width = (enddate - startdate).days+2
        for i in range(width):
            while(True):
                if(self.is_busy(datetime.combine(startdate, prototime)+timedelta(days=i))):
                    endtime = copy.deepcopy(prototime)
                if(prototime == (datetime.combine(startdate,time(hour=23,minute=59))-timedelta(minutes=granularity-1)).time()):
                    break
                prototime = (datetime.combine(startdate, prototime)+timedelta(minutes=granularity)).time()
                
            if(endtime == (datetime.combine(startdate,time(hour=23,minute=59))-timedelta(minutes=granularity-1)).time()):
                break
            prototime = copy.deepcopy(endtime)
        return endtime
    
    #returns a date object representing the earliest start date of any event in this Calendar object
    def earliest_date(self):
        mindate = date.max
        for event in self.events:
            if(event.start.date()<mindate):
                mindate = event.start.date()
        return mindate
    
    #returns a time object representing the earliest start time of any event in this Calendar object
    def earliest_time(self):
        mintime = time.max
        for event in self.events:
            if(event.start.time()<mintime):
                mintime = event.start.time()
        return mintime
    
    #returns True if any event in the Calendar occurs during the specified time, otherwise False
    #
    #requires: when must be a datetime object
    def is_busy(self, when):
        for event in self.events:
            if(event.is_busy(when)):
                return True
        return False
    
    #returns True if any event in the calendar occurs during the specified time, for a given duration
    #   In this instance of this method, the busy-ness is checked continuously,
    #   whereas in the CalendarMatrix class's implementation, a discrete check
    #   is performed.
    #
    #requires: when must be a datetime object, duration must be an int > 0
    #   (representing minutes)
    def is_busy_for_duration(self, when, duration):
        tempevent = Event("duration", {"start":when, "duration":duration, "location":"", "travelTime":0})
        for event in self.events:
            if(tempevent.conflict(event)):
                return True
        return False
    
    #returns a date object representing the latest end date of any event in this Calendar object
    def latest_date(self):
        maxdate = date.min
        for event in self.events:
            if(event.end.date() > maxdate):
                maxdate = event.end.date()
        return maxdate
    
    #returns a time object representing the latest end time of any event in this Calendar object
    def latest_time(self):
        maxtime = time.min
        for event in self.events:
            if(event.end.time() > maxtime):
                maxtime = event.end.time()
        return maxtime
    
class Event:
    
    #instantiates a new Event object
    #   This method, similar to Matrix.__init__, allows for multiple constructors
    #   to be called based off of what is passed to inittype. An Event is
    #   most commonly constructed from raw event data.
    #   
    #required args: varies
    #   inittype: blevent
    #       blEvent                         json formatted string of event data, non-parsed
    #   inittype: duration
    #       duration                        int representing minutes
    #       location                        string
    #       start                           datetime object
    #       travelTime                      int representing ???
    def __init__(self, inittype, args):
        constructors = {
            "blevent":       self.construct_from_blevent,
            "duration":      self.construct_from_duration
        }
        constructor = constructors.get(inittype, -1)
        
        if(constructor != -1):
            constructor(args)
        else:
            raise ValueError("Invalid inittype passed. Please refer to documentation to see valid inittypes")
    
    #constructs a new Event object based on raw event data
    #   This method assumes much about the structure of the data passed to it,
    #   i.e. the format being saved to in the database.
    #
    #required args: blEvent
    def construct_from_blevent(self, args):
        self.start = datetime.strptime(args["blEvent"]["start_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.end = datetime.strptime(args["blEvent"]["end_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.location = args["blEvent"]["location"]
        self.travelTime = int(args["blEvent"]["travel_time"])
    
    #constructs a new Event object based on various parameters
    #
    #required args: start, duration, location, travelTime
    #
    #requires: start, end must be a datetime object, duration is an int > 0 
    #   (representing minutes)
    def construct_from_duration(self, args):
        self.start = args["start"]
        self.end = args["start"]+timedelta(minutes=args["duration"])
        self.location = args["location"]
        self.travelTime = args["travelTime"]
    
    #returns the duration of the event in seconds
    def __len__(self):
        return (self.end-self.start).seconds
    
    #returns a rough (incomplete/unbounded) json formatted string representing this event
    def __str__(self):
        output = "\"start_time\":\""+self.start.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"end_time\":\""+self.end.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"location\":\""+self.location+",\"travel_time\":"+str(self.travelTime)+""
        return output
    
    #returns True if a given event "conflicts" with the current event
    #   To explain further, if there is any instant of time taken up by both
    #   events, this method will return True.
    #
    #Note: start times are considered inclusively, whereas end times are considered
    #   exclusively
    #
    #requires: other must be and Event object
    def conflict(self, other):
        if(not isinstance(other, Event)):
            raise TypeError("Erroneous argument type supplied. Please use an Event object")
        if(
        (self.start >= other.start and self.start < other.end) or 
        (self.end > other.start and self.end < other.end) or 
        (self.start <= other.start and self.end >= other.end)):
            return True
        return False
    
    #returns True if the given datetime occurs during this event, otherwise False
    #
    #Note: start times are considered inclusively, whereas end times are considered
    #   exclusively
    #
    #requires: when must be a datetime object
    def is_busy(self, when):
        if(when >= self.start and when < self.end):
            return True
        return False