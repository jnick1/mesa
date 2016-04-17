#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, date, time, timedelta
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
def smallest_cost(POINT, Priority, originalEvent, gran, location, Matrix):  
    costList = []
    if (POINT is None):
        return None
    else:
        output = "\"0\": { "
        for point in POINT:
            cost1 = vector_cost(point, Priority)
            costList.append(cost1)
        costList = sorted(costList, key=itemgetter("cost"))
        if(len(costList)>=10):
            for i in range (0, 10, 1): #solutions 0 through 9
                stringOutput = "\""+str(i)+"\": "+date_of_cost(costList[i], originalEvent, gran, i, location, Matrix)+","
                output += stringOutput
        else:
            i = 0
            for item in costList:
                stringOutput = "\""+str(i)+"\": "+date_of_cost(item, originalEvent, gran, i, location, Matrix)+","
                output += stringOutput
                i += 1
        output = output[0:len(output)-1]+"}"
        return output[0:len(output)-1]


#priority: date, granularity, attendies, duration, repeat, location, time 

def vector_cost(point, Priority):
    TIME = point[0] #this is in minutes? assume so for now
    DATE = point[1]
    DUR = point[2] #0 = original duration, 2 = 2 granularity below duration, etc
    ATTEND = point[3] #0 = Max People, 2 = 2 people under Max


    timeCost = abs(TIME) * Priority.get('time') #what if the time and such is the other direction away from the goal time?
    dateCost = abs(DATE) * Priority.get('date') #so take the absolute value
    durCost = abs(DUR) * Priority.get('duration')
    attendCost = abs(ATTEND) * Priority.get('attendees') 

    cost = timeCost + dateCost + durCost + attendCost
    costobj = {"time":TIME, "date":DATE, "duration":DUR, "attendees": ATTEND, "cost":cost}
    return costobj

def date_of_cost(objDate, originalEvent, granularity, solution, location, Matrix):
    VTime = objDate["time"]
    VDay = objDate["date"]
    VDur = objDate["duration"]
    Vcost = objDate["cost"]

    startTime = originalEvent.start - timedelta(minutes=originalEvent.start.minute%granularity)
    startingDuration = (originalEvent.end - startTime).seconds//60
    startingDuration = startingDuration + ((granularity - startingDuration%granularity)%granularity)
    defaultLoc = location

    #this assumes that the defaults are already in datetime
    defaultDate = startTime
    daysAway = timedelta(days = VDay)
    newDay = defaultDate + daysAway #works when its pos or neg 
    i = newDay.date()

    timeAway = timedelta(hours = VTime)
    newTime = startTime + timeAway
    j = newTime.time() #the time the event starts at 
    timeLess = VDur * granularity #amount of time less it is 
    D = startingDuration - timeLess #full duration of the event

    newEndTime = datetime.combine(i,j) + timedelta(minutes = D)
    people = Matrix.available_attendees(datetime.combine(i,j), D) 

    return to_string(i, j, Vcost, solution, newEndTime, defaultLoc, people)


    #work in progress, but the basic is still pretty good
def to_string(i, j, cost, sol, End, location, people):
    #just have to check whether or not to return the actual list of attendies who can make it
    import json
    attendees = {}
    for person in people:
        attendees[person] = True
    jsonstring = {
        "start":datetime.combine(i,j).strftime("%Y-%m-%dT%H:%M:%SZ"),
        "end":End.strftime("%Y-%m-%dT%H:%M:%SZ"),
        "location":location,
        "cost":cost,
        "id":sol,
        "attendees":attendees
    }
    return json.dumps(jsonstring)


            
        
        
        
  #  [10: "time", 200 : "durration"] #etc
    
   # deg get_nth(self, n, dictionary)
    #    for key in dictionary:
     #       return minikey
        
    #def modify_time(self, priority, discrete events, matrix, duration):
     #   for time in matrix:
      #      if not is_busy_for_duration(time, duration):
       #         good event [].append new event(time)
        #        cost[].append (cost of time)
                
         #   if reach matrix:
          #      return reached max ""
#solution sets []
#for number of solution sets
 #   matrix = subset [modified matrix]
  #  while
   # switch priority:
    #    good events []
     #   case "time":
      #      modify_time()
       # etc

#check to see if you can use miltidimensional lists/dictionaries
#4matrix = []#4 dimension matrix
 #       def get_lowest_priority():
            
            #get the priority on the list/changes depending on the 
            #make it a for loop for number of solution sets
            #check for cost matrix
            
        
        
