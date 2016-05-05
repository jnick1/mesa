#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, timedelta
import heapq
from operator import itemgetter
        
    #sum of distance on axix * priotiy of axis
    #Will gets me the point list, Jacob gets me
    # order is TIME, DATE, DURATION, ATTENDE
        #these are the points that differ from the default settings
        #start time axis is 5: so 5 * priorityof TIME
        #etc, then add then all together for each point
        # POINT[1] = list of size 4
        #calculate cost, 
        #make a list of events with all data + cost
        #after getting all possible points, find the with the lowest 10 dates in the matrix with that cost
        #
        #note look at 3.4 datetime, be more type aware
        
    #pointList, priorities, originalEvent, granularity, txLocation, modifiedMatrix)
    #note, i don't know if I will have the Defaults already, or if it will be pass to me, so 'til then I'm using it as an object
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
        if(len(costList)>=10):
            for i in range (0, 10): #solutions 0 through 9
                stringOutput = "\""+str(i)+"\": "+date_of_cost(costList[i], originalEvent, granularity, i, location, Matrix)+","
                output += stringOutput
        else:
            i = 0
            for item in costList:
                stringOutput = "\""+str(i)+"\": "+date_of_cost(item, originalEvent, granularity, i, location, Matrix)+","
                output += stringOutput
                i += 1
        output = output[0:len(output)-1]+"}"
        return output


#priority: date, granularity, attendees, duration, repeat, location, time 

def vector_cost(point, priorities):
    TIME = point[0]
    DATE = point[1]
    DUR = point[2] #0 = original duration, 2 = 2 granularity below duration, etc
    ATTEND = point[3] #0 = Max People, 2 = 2 people under Max

    timeCost = abs(TIME) * priorities["time"] #what if the time and such is the other direction away from the goal time?
    dateCost = abs(DATE) * priorities["date"] #so take the absolute value
    durCost = abs(DUR) * priorities["duration"]
    attendCost = abs(ATTEND) * priorities["attendees"]

    cost = timeCost + dateCost + durCost + attendCost
    costobj = {"time":TIME, "date":DATE, "duration":DUR, "attendees": ATTEND, "cost":cost}
    return costobj

def date_of_cost(objDate, originalEvent, granularity, solution, location, Matrix):
    VTime = objDate["time"]
    VDay = objDate["date"]
    VDur = objDate["duration"]
    Vcost = objDate["cost"]

    startTime = originalEvent.start - timedelta(minutes=(granularity - originalEvent.start.minute%granularity)%granularity)
    startingDuration = (originalEvent.end - originalEvent.start).total_seconds()//60
    startingDuration += (granularity - startingDuration % granularity) % granularity
    
    #this assumes that the defaults are already in datetime
    newDate = (startTime + timedelta(days = VDay)).date() #works when its pos or neg 
    newTime = (startTime + timedelta(minutes = VTime*granularity)).time()
    newDuration = startingDuration - (VDur * granularity) #full duration of the event
    
    newEndTime = datetime.combine(newDate,newTime) + timedelta(minutes = newDuration)
    people = Matrix.available_attendees(datetime.combine(newDate,newTime), newDuration) 

    return to_string(newDate, newTime, Vcost, solution, newEndTime, location, people)

def to_string(newDate, newTime, cost, sol, end, location, people):
    #just have to check whether or not to return the actual list of attendees who can make it
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
