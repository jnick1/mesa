#!/usr/bin/env python2
# encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, timedelta, time, date
import math


def construct_point_list(masterMatrix, granularity, baseEvent, blSettings):
    startEvent = baseEvent.start - timedelta(minutes=(granularity - baseEvent.start.minute % granularity) % granularity)
    startTime = startEvent.time()
    startDate = startEvent.date()
    startingDuration = (baseEvent.end - baseEvent.start).total_seconds() // 60
    startingDuration += (granularity - startingDuration % granularity) % granularity

    trackerRequiredBusy = {}
    trackerAvailableAttendees = {}

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
        # Check if start works, if not, return an empty list to Sierra
        attendees = masterMatrix.available_attendees(startEvent, startingDuration)
        if len(attendees) < len(masterMatrix.attendees):
            return None
        finalPointList.append([0, 0, 0, 0])
        return finalPointList
    else:
        durationIncrement = 0
        durationList = generate_duration_list(canModulateDuration, granularity, startingDuration)
        # duration_list = (duration for duration in range(startingDuration,granularity, -1*granularity) if canModulateDuration) #may be faster
        dates = masterMatrix.dates
        times = masterMatrix.times
        lenMatrixAttendees = len(masterMatrix.attendees)  # externalize len call as much as possible
        for duration in durationList:
            for matrixDate in dates:
                for matrixTime in times:
                    if not canModulateTime and matrixTime != startTime:
                        continue
                    if not canModulateDate and matrixDate != startDate:
                        continue
                    matrixDateTime = datetime.combine(matrixDate, matrixTime)
                    requiredBusy = tracker_check_required_busy(trackerRequiredBusy, masterMatrix, matrixDateTime,
                                                               duration, granularity)
                    if requiredBusy:
                        continue
                    lenAttendees = len(tracker_available_attendees(trackerAvailableAttendees, masterMatrix, matrixDateTime, duration))
                    if lenAttendees < minAttendees:
                        continue
                    if not canModulateAttendees:
                        if lenAttendees < lenMatrixAttendees:
                            continue
                    diffDates = (datetime.combine(startDate, time(0, 0, 0)) - datetime.combine(matrixDate, time(0, 0, 0))).days
                    diffTimes = (datetime.combine(date(1, 1, 1), startTime) - datetime.combine(date(1, 1, 1), matrixTime)).total_seconds()
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


def tracker_check_required_busy(tracker, masterMatrix, eventDateTime, duration, granularity):
    # Tracker format: {eventDateTime: duration free}
    eventDateTimeStr = str(eventDateTime)
    if eventDateTimeStr in tracker and duration <= tracker[eventDateTimeStr]:
        return False
    requiredBusy = masterMatrix.is_required_attendees_busy(eventDateTime, duration)
    if not requiredBusy:  # If all required are free (A.K.A. masterMatrix.is_required_attendees_busy returns False) for a certain eventDateTime and duration, they're free for eventDateTime with smaller duration
        if eventDateTimeStr in tracker:
            if duration > tracker[eventDateTimeStr]:
                tracker[eventDateTimeStr] = duration
        else:
            tracker[eventDateTimeStr] = duration
        fill_tracker_from_duration(tracker, eventDateTime, duration, granularity)
    return requiredBusy


def fill_tracker_from_duration(tracker, eventDateTime, originalDuration, granularity):
    # Note: recursion does not work, too many calls required
    durationList = generate_duration_list(True, granularity, originalDuration)
    durationIncrement = timedelta(minutes=granularity)
    for durationIndex, duration in enumerate(durationList):
        nextTime = eventDateTime
        for _ in range(0, durationIndex):
            nextTime += durationIncrement
            if str(nextTime) in tracker:
                if duration > tracker[str(nextTime)]:
                    tracker[str(nextTime)] = duration
            else:
                tracker[str(nextTime)] = duration


def tracker_available_attendees(tracker, masterMatrix, eventDateTime, duration):
    # If an attendee is free for eventDateTime and duration, they're free for eventDateTime with smaller duration
    eventDateTimeStr = str(eventDateTime)
    available = []
    if eventDateTimeStr in tracker:
        for attendee in masterMatrix.attendees:
            if attendee["email"] in tracker[eventDateTimeStr]:
                available.append(attendee["email"])
            else:
                attendeeAvailable = masterMatrix.attendee_available(eventDateTime, duration, attendee["email"])
                if attendeeAvailable:
                    available.append(attendee["email"])
                    tracker[eventDateTimeStr][attendee["email"]] = True
    else:
        available = masterMatrix.available_attendees(eventDateTime, duration)
        for availableAttendee in available:
            tracker[eventDateTimeStr] = {availableAttendee: True}
    return available
