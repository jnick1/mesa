#!/usr/bin/env python2
# encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, timedelta, time, date
import math

def construct_point_list(calendarSet, granularity, baseEvent, blSettings):
    startEvent = baseEvent.start - timedelta(minutes=(granularity - baseEvent.start.minute % granularity) % granularity)
    startTime = startEvent.time()
    startDate = startEvent.date()
    startingDuration = (baseEvent.end - baseEvent.start).total_seconds() // 60
    startingDuration += (granularity - startingDuration % granularity) % granularity

    canModulateAttendees = True
    canModulateDuration = True
    canModulateDate = True
    canModulateTime = True
    minAttendees = 1
    if blSettings["useDefault"] is False:
        if blSettings["time"]:
            canModulateTime = blSettings["time"]["timeallow"]
        if blSettings["date"]:
            canModulateDate = blSettings["date"]["dateallow"]
        if blSettings["duration"]:
            canModulateDuration = blSettings["duration"]["durationallow"]
        if blSettings["attendees"]:
            canModulateTime = blSettings["attendees"]["attendeesallow"]
            minAttendees = int(blSettings["attendees"]["minattendees"])

    finalPointList = []

    if not (canModulateAttendees or canModulateDuration or canModulateDate or canModulateTime):
        #Check if original event works, if not, return None
        attendees = calendarSet.available_attendees(startEvent, startingDuration)
        if len(attendees) < len(calendarSet.attendees):
            return None
        finalPointList.append([0, 0, 0, 0])
        return finalPointList
    else:
        durationIncrement = 0
        durationList = generate_duration_list(canModulateDuration, granularity, startingDuration)
        # duration_list = (duration for duration in range(startingDuration,granularity, -1*granularity) if canModulateDuration) #may be faster
        lenMatrixAttendees = len(calendarSet.calendarList)  # externalize len call as much as possible
        for duration in durationList:
            searchPos = calendarSet.calculate_time_bound_start(granularity) - timedelta(minutes = granularity)
            searchEnd = calendarSet.calculate_time_bound_end(granularity)
            while searchPos < searchEnd:
                searchPos = searchPos + timedelta(minutes = granularity)
                searchPosTime = searchPos.time()
                if not canModulateTime and searchPosTime != startTime:
                    continue
                searchPosDate = searchPos.date()
                if not canModulateDate and searchPosDate != startDate:
                    continue
                #requiredBusy = tracker_check_required_busy(trackerRequiredBusy, masterMatrix, matrixDateTime, duration, granularity)
                requiredBusy = calendarSet.is_required_attendees_busy(searchPos, duration)
                if requiredBusy:
                    continue
                #availableAttendees = tracker_available_attendees(trackerAvailableAttendees, masterMatrix, matrixDateTime, duration)
                availableAttendees = calendarSet.available_attendees(searchPos, duration)
                lenAttendees = len(availableAttendees)
                if lenAttendees < minAttendees:
                    continue
                if not canModulateAttendees:
                    if lenAttendees < lenMatrixAttendees:
                        continue
                diffDates = (datetime.combine(startDate, time(0, 0, 0)) - datetime.combine(searchPosDate, time(0, 0, 0))).days
                diffTimes = (datetime.combine(date(1, 1, 1), startTime) - datetime.combine(date(1, 1, 1), searchPosTime)).total_seconds()
                diffTimes = math.ceil(diffTimes / (60 * granularity))
                datetimePoint = [-1 * diffTimes, -1 * diffDates, durationIncrement, lenMatrixAttendees - lenAttendees]
                finalPointList.append(datetimePoint)
                
            durationIncrement += 1
    return finalPointList


def generate_duration_list(canModulateDuration, granularity, startingDuration):
    duration_list = [startingDuration]
    if canModulateDuration:
        duration = startingDuration - granularity
        while duration >= granularity:
            duration_list.append(duration)
            duration -= granularity
    return duration_list