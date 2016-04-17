#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

import datetime

def construct_point_list(masterMatrix, granularity, baseEvent):
    startTime = baseEvent.start - -timedelta(minutes=start.minute%granularity)
    startingDuration = (baseEvent.end - startTime).seconds()/60
    startingDuration = startingDuration + (granularity - startingDuration%granularity)
    
    canModulateAttendees = true;
    canModulateDuration = true;
    canModulateDate = true;
    canModulateTime = true;

    finalPointList = []

    if(not(canModulateAttendees or canModulateDuration or canModulateDate or canModulateTime)):
        # Check if startDate and Time works, if not, return an empty list to Sierra
        if(time.time() != startTime.time()):
            return NULL
        if(time.date() != startTime.date()):
            return NULL
        attendees = masterMatrix #(GET ATTENDEES FOR DURATION AND STARTTIME)
        if(attendees.size() < masterMatrix.attendees):
            return NULL
        return [0][0,0,0,0]
    else:
        unconstrained_list = generate_unconstrained_list(masterMatrix)
        duration_list = generate_duration_list(canModulateDuration, granularity, startingDuration)

        for (durationIncrement, duration) in duration_list:
            for time in unconstrained_list:
                if(not canModulateTime):
                    if(time.time() != startTime.time()):
                        continue
                if(not canModulateDate):
                    if(time.date() != startTime.date()):
                        continue
                attendees = masterMatrix.availableAttendees(time, duration);
                if(masterMatrix.is_required_attendees_busy(time, duration)):
                    continue
                if(not canModulateAttendees):
                    if(attendees.size() < masterMatrix.attendees):
                        continue
                if(attendees.size() < minAttendees):
                    continue
                diffDates = startTime.date() - time.date()
                diffTimes = (startTime.time() - time.time())
                diffTimes = divmod(diffTimes, granularity) #Only thing I don't know if works
                datetimePoint = [diffTimes,diffDates.days,durationIncrement,(masterMatrix.attendees.size() - attendees.size)]
                finalPointList.append(datetimePoint);
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