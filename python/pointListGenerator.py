#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, date, time, timedelta
import classes
import math

def construct_point_list(masterMatrix, granularity, baseEvent, blSettings):
    startTime = baseEvent.start - timedelta(minutes=(granularity - baseEvent.start.minute%granularity)%granularity)
    startingDuration = (baseEvent.end - baseEvent.start).seconds//60
    startingDuration = startingDuration + (granularity - startingDuration%granularity)%granularity
    
    canModulateAttendees = True
    canModulateDuration = True
    canModulateDate = True
    canModulateTime = True
    minAttendees = 1
    if(blSettings["useDefault"] == False):
        if(blSettings["time"] != False):
            canModulateTime = blSettings["time"]["timeallow"]
        if(blSettings["date"] != False):
            canModulateDate = blSettings["date"]["dateallow"]
        if(blSettings["duration"] != False):
            canModulateDuration = blSettings["duration"]["durationallow"]
        if(blSettings["attendees"] != False):
            canModulateTime = blSettings["attendees"]["attendeesallow"]
            minAttendees = int(blSettings["attendees"]["minattendees"])

    finalPointList = []

    if(not(canModulateAttendees or canModulateDuration or canModulateDate or canModulateTime)):
        # Check if startDate and Time works, if not, return an empty list to Sierra
        if(time.time() != startTime.time()):
            return None
        if(time.date() != startTime.date()):
            return None
        attendees = masterMatrix.available_attendees(starttime, startingDuration) #(GET ATTENDEES FOR DURATION AND STARTTIME)
        if(len(attendees) < len(masterMatrix.attendees)):
            return None
        return [0][0,0,0,0]
    else:
        unconstrained_list = generate_unconstrained_list(masterMatrix)
        duration_list = generate_duration_list(canModulateDuration, granularity, startingDuration)
        durationIncrement = 0
        for duration in duration_list:
            for eventTime in unconstrained_list:
                if(not canModulateTime):
                    if(eventTime.time() != startTime.time()):
                        continue
                if(not canModulateDate):
                    if(eventTime.date() != startTime.date()):
                        continue
                attendees = masterMatrix.available_attendees(eventTime, duration);
                if(masterMatrix.is_required_attendees_busy(eventTime, duration)):
                    continue
                if(not canModulateAttendees):
                    if(len(attendees) < len(masterMatrix.attendees)):
                        continue
                if(len(attendees) < minAttendees):
                    continue
                diffDates = (datetime.combine(startTime.date(),time(0,0,0)) - datetime.combine(eventTime.date(), time(0,0,0))).days
                diffTimes = (datetime.combine(date(1,1,1),startTime.time()) - datetime.combine(date(1,1,1),eventTime.time())).total_seconds()
                diffTimes = math.ceil(diffTimes/(60*granularity)) #Only thing I don't know if works
                datetimePoint = [-1 * diffTimes,-1 * diffDates,durationIncrement,(len(masterMatrix.attendees) - len(attendees))]
                finalPointList.append(datetimePoint)
            durationIncrement += 1
    return finalPointList
        
def generate_unconstrained_list(masterMatrix):
    unconstrained_list = []
    for date in masterMatrix.dates:
        for time in masterMatrix.times:
            unconstrained_list.append(datetime.combine(date, time))
    
    return unconstrained_list;

def generate_duration_list(canModulateDuration, granularity, startingDuration):
    duration_list = [startingDuration]
    if(canModulateDuration):
        duration = startingDuration - granularity
        while(duration >= granularity):
            duration_list.append(duration)
            duration -= granularity
    return duration_list