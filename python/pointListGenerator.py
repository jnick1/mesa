#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, timedelta, time, date
import math

def construct_point_list(masterMatrix, granularity, baseEvent, blSettings):
    startTime = baseEvent.start - timedelta(minutes=(granularity - baseEvent.start.minute%granularity)%granularity)
    startingDuration = (baseEvent.end - baseEvent.start).total_seconds()//60
    startingDuration = startingDuration + (granularity - startingDuration%granularity)%granularity
    trackerRequiredBusy = {}
    trackerAvailableAttendees = {}
    
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
        attendees = masterMatrix.available_attendees(startTime, startingDuration) #(GET ATTENDEES FOR DURATION AND STARTTIME)
        if(len(attendees) < len(masterMatrix.attendees)):
            return None
        return [0][0,0,0,0]
    else:
        durationIncrement = 0
        duration_list = generate_duration_list(canModulateDuration, granularity, startingDuration)
        for duration in duration_list:
            for matrixDate in masterMatrix.dates:
                for matrixTime in masterMatrix.times:
                    eventTime = datetime.combine(matrixDate, matrixTime)
                    if(not canModulateTime):
                        if(eventTime.time() != startTime.time()):
                            continue
                    if(not canModulateDate):
                        if(eventTime.date() != startTime.date()):
                            continue
                    #requiredBusy = masterMatrix.is_required_attendees_busy(eventTime, duration)
                    requiredBusy = tracker_check_required_busy(trackerRequiredBusy, masterMatrix, eventTime, duration, granularity)
                    if(requiredBusy):
                        continue
                    #attendees = masterMatrix.available_attendees(eventTime, duration)
                    attendees = tracker_available_attendees(trackerAvailableAttendees, masterMatrix, eventTime, duration);
                    if(len(attendees) < minAttendees):
                        continue
                    if(not canModulateAttendees):
                        if(len(attendees) < len(masterMatrix.attendees)):
                            continue
                    diffDates = (datetime.combine(startTime.date(),time(0,0,0)) - datetime.combine(eventTime.date(), time(0,0,0))).days
                    diffTimes = (datetime.combine(date(1,1,1),startTime.time()) - datetime.combine(date(1,1,1),eventTime.time())).total_seconds()
                    diffTimes = math.ceil(diffTimes/(60*granularity))
                    datetimePoint = [-1 * diffTimes,-1 * diffDates,durationIncrement,(len(masterMatrix.attendees) - len(attendees))]
                    finalPointList.append(datetimePoint)
            durationIncrement += 1
    return finalPointList

def generate_duration_list(canModulateDuration, granularity, startingDuration):
    duration_list = [startingDuration]
    if(canModulateDuration):
        duration = startingDuration - granularity
        while(duration >= granularity):
            duration_list.append(duration)
            duration -= granularity
    return duration_list

def tracker_check_required_busy(tracker, masterMatrix, eventTime, duration, granularity):
    #If all required are free for a certain eventTime and duration, they're free for eventTime with smaller duration
    eventTimeStr = str(eventTime)
    if eventTimeStr in tracker:
        if(tracker[eventTimeStr]): #No need to check duration because all durations are in descending order
            nextEventTime = eventTime + timedelta(minutes=granularity) #calculate next time within duration
            tracker[str(nextEventTime)] = True #set also true because still within same previous duration
            return True
    busy = masterMatrix.is_required_attendees_busy(eventTime, duration)
    tracker[eventTimeStr] = busy
    return busy

def tracker_available_attendees(tracker, masterMatrix, eventTime, duration):
    #If an attendee is free for eventTime and duration, they're free for eventTime with smaller duration
    eventTimeStr = str(eventTime)
    available = []
    if eventTimeStr in tracker:
        for attendee in masterMatrix.attendees:
            if (attendee["email"] in tracker[eventTimeStr] and tracker[eventTimeStr][attendee["email"]]):
                available.append(attendee["email"])
            else:
                attendeeAvailable = masterMatrix.attendee_available(eventTime, duration, attendee["email"])
                if(attendeeAvailable):
                    available.append(attendee["email"])
                tracker[eventTimeStr][attendee["email"]] = attendeeAvailable
    else:
        available = masterMatrix.available_attendees(eventTime, duration)
        for availableAttendee in available:
            tracker[eventTimeStr] = {availableAttendee: True}
    return available