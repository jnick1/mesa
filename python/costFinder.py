#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, timedelta
import heapq
from operator import itemgetter
        
#sum of distance on axix * priority of axis
# order is TIME, DATE, DURATION, ATTENDEES
#these are the points that differ from the default settings
#pointList, priorities, originalEvent, granularity, txLocation, modifiedMatrix)
def smallest_cost(pointList, priorities, originalEvent, granularity, location, Matrix):  
    costList = []
    if (pointList is None):
        return None
    else:
        output = "\"0\": { "
        for point in pointList:
            costList.append(vector_cost(point, priorities))
        costList = heapq.nsmallest(10, costList, key = itemgetter("cost")) #should run in O(nlog(10))
                                 #sorted(costList, key=itemgetter("cost")) #runs in O(nlogn)
        i = 0
        for item in costList:
            stringOutput = "\""+str(i)+"\": "+date_of_cost(item, originalEvent, granularity, i, location, Matrix)+","
            output += stringOutput
            i += 1
        output = output[0:len(output)-1]+"}"
        return output


#priority: date, granularity, attendees, duration, repeat, location, time 

def vector_cost(point, priorities):
    diffTime = point[0]
    diffDate = point[1]
    diffDur = point[2] #0 = original duration, 2 = 2 granularity below duration, etc
    diffAttendees = point[3] #0 = Max People, 2 = 2 people under Max

    timeCost = abs(diffTime) * priorities["time"] #what if the time and such is the other direction away from the goal time?
    dateCost = abs(diffDate) * priorities["date"] #so take the absolute value
    durCost = abs(diffDur) * priorities["duration"]
    attendCost = abs(diffAttendees) * priorities["attendees"]

    cost = timeCost + dateCost + durCost + attendCost
    costobj = {"time":diffTime, "date":diffDate, "duration":diffDur, "attendees": diffAttendees, "cost":cost}
    return costobj

def date_of_cost(objDate, originalEvent, granularity, solution, location, matrix):
    diffTime = objDate["time"]
    diffDay = objDate["date"]
    diffDur = objDate["duration"]
    totalCost = objDate["cost"]

    startTime = originalEvent.start - timedelta(minutes=(granularity - originalEvent.start.minute%granularity)%granularity)
    startingDuration = (originalEvent.end - originalEvent.start).total_seconds()//60
    startingDuration += (granularity - startingDuration % granularity) % granularity
    
    #this assumes that the defaults are already in datetime
    newDate = (startTime + timedelta(days = diffDay)).date() #works when its pos or neg 
    newTime = (startTime + timedelta(minutes = diffTime*granularity)).time()
    newDuration = startingDuration - (diffDur * granularity) #full duration of the event
    
    newEndTime = datetime.combine(newDate,newTime) + timedelta(minutes = newDuration)
    people = matrix.available_attendees(datetime.combine(newDate,newTime), newDuration) 

    return to_string(newDate, newTime, totalCost, solution, newEndTime, location, people)

def to_string(newDate, newTime, cost, sol, end, location, people):
    import json
    attendees = {}
    for person in people:
        attendees[person] = True
    jsonstring = {
        "start":datetime.combine(newDate,newTime).strftime("%Y-%m-%dT%H:%M:%SZ"),
        "end":end.strftime("%Y-%m-%dT%H:%M:%SZ"),
        "location":location,
        "cost":cost,
        "id":sol,
        "attendees":attendees
    }
    return json.dumps(jsonstring)
