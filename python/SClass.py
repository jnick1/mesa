#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

from datetime import datetime, date, time

class PersonalMatrixFunctions:
    
    def __init__(self, StartTime, EndTime, StartDay, EndDay, granularity):
        self.StartTime = StartTime
        self.EndTime = EndTime
        self.StartDay = StartDay
        self.EndDay = EndDay
        self.granularity = granularity
        row = EndDay-StartDay
        col = EndTime-StartTime
        self.Matrix = [ [ "0" for j in range(col*self.granularity) ] for i in range(row) ]

    def getStartTime(self):
        return self.StartTime

    def getEndTime(self):
        return self.EndTime
    
    def getGranularity(self):
        return self.granularity
            
    def getTimeLength(self):
        return self.timeLength
        
    def getLocationTime(self):
        return self.locationTime
    
    def getSearchWidth(self):
        return self.searchWidth
    
    def getPreferedTime(self):
        return self.preferedTime
    
    def eventMatrix(self):
        for i in range (self.StartDay, self.EndDay):
            for j in xrange(self.StartTime, self.EndTime, self.granularity):
                self.Matrix[i][j] = '1'
            
    def InputMatrix(self, i, j):
        self.Matrix[i][j] = '1'
  
    def AddingMatrix(self, MasterMatrix, start, end, gran):
        for i in range (self.Matrix):
            for j in xrange(start, (24*gran)-end, gran):
                temp = MasterMatrix[i][j]
                MasterMatrix[i][j] = temp + self.Matrix[i][j]
        
        return MasterMatrix
    
    
    
class MasterMatrix:
    
    timeLength = 0
    preferedTime = 0
    TempPreferedTime = 0
    preferedDate = 0
    minimumPeople = 0
    
    locationTime = 0
    searchWidth = 0
    granularity = 0
    mostPeople = 0
    BannedStart = 0
    BannedEnd = 0
    cost = 0
    
    def __init__(self, BannedStart, BannedEnd, timeLength, startDay, endDay, locationTime, preferedTime, minimumPeople, granularity, mostPeople, preferedDate, locationPlace):
        self.timeLength = timeLength
        self.searchWidth = endDay-startDay #will work with ints with time stamps or with date time objects to get a time delta object
        self.locationTime = locationTime
        self.locationPlace = locationPlace
        self.preferedTime = preferedTime
        self.minimumPeople = minimumPeople
        self.granularity = granularity
        self.mostPeople = mostPeople
        self.preferedDate = preferedDate
        self.BannedStart = BannedStart
        self.BannedEnd = BannedEnd
    
    def get_prefered_time(self):
        return self.preferedTime
    
    def get_prefered_date(self):
        return self.preferedDate
    
    def get_minimumPeople(self):
        return self.minimumPeople
    
    def get_mostPeople(self):
        return self.mostPeople
    
    def get_timeLength(self):
        return self.timeLength
    
    def getGranularity(self):
        return self.granularity
    
    def get_Location(self):
        return self.locationPlace
    
    def findTimes(self, MasterMatrix, BannedStart, BannedEnd, granularity, locationArray):
        output = ""
        for D in xrange(self.timeLength, 0, -granularity): #going through the durration times to decrease it too 
            for i in range (0, self.searchWidth): #dates
                for j in xrange(BannedStart, (24*granularity) - BannedEnd, granularity): #Need to check on how to change incremtation in python
                    #if(j-self.locationTime >= 0): #so it stays within the calender
                        #if (MasterMatrix[i][j-selflocationTime] == 0):#travel time is free before hand
                            spot = False
                            #this way, if the perfered time is not in the middle, it will still performed the action
                            while ( spot == False and self.preferedTime >= BannedStart or spot == False and self.preferedTime <= BannedEnd ):
                                count+=1
                                String = MasterMatrix[i][j]
                                if (self.preferedTime == 0): #there is no preferedTimes
                                    trial = find_people_cost(MasterMatrix, i, j, D, String, locationArray)
                                    if (trial == False): #if teh findPeopleCost did not find a spot there
                                        spot = trial
                                    else:
                                        output+= trial
                                        spot = True
                                    # end PREFEREDTIME IS NONE if statement
                                elif (self.preferedTime != 0):
                                    trial =  findPeopleCost(MasterMatrix, i, self.TempPreferedTime, D, MasterMatrix[i][self.TempPreferedTime], locationArray)
                                    if(trial == False):
                                        spot = trial
                                    else:
                                        output +=trial
                                        spot = True
                                else:
                                    self.TempPreferedTime = self.TempPreferedTime + (granularity*count* (-1^count))  #branches off hour by hour       
        
        return output
        
    def find_people_cost(self, MasterMatrix, i, j, D, string, locationArray):
        people = 0
        for x in range (0, len(string)-1):
            count = 0 #count if the person has free time or not
            travelTime = locationArray[x]
            if(j-travelTime !=0):
                for m in range(j-travelTime, j+D-1):
                    String = MasterMatrix[i][m] #goes down through durration time starting at what j is. 
                    if (String[x] != 0):
                        count +=1 #adds the count i if they can't do it
                if (count == 0): #if the person is free throughout, the variable won't change
                    people +=1#adds to the number of people that can attend at that spot
        #ends v for loop
                  
        if (people > self.minimumPeople):
            costCount(i, j, people, D) #doing the costFunction
            return to_string(i, j, D)
        else:
            return False
        

    
    def cost_count(self, i, j, people, D):
            #TO DO: insert priority for the cost
            #check each priority to see how far away it is from where the most people can attend
            #min events has to be 10
            #make a temp matrix to use
            
        timeCost = abs(j - self.preferedTime)
        peopleCost = abs(self.mostPeople - people)
        dayCost=0
                        
        WD1 = self.preferedDate
        WD2 = day_converter(i)
            
        if (WD1.isoweekday() == WD2.isoweekday): #if its on the exact same day (monday, etc)
            dayCost = 0
        else:
            dayNum = abs(WD1.isoweekday() == WD2.isoweekday())
            if ( dayNum == 1  or dayNum == 6): #one day off
                dayCost = 1
            if ( dayNum == 2  or dayNum == 5): ##two days off
                dayCost.days = 2
            else:
                dayCost = 3
        durCost = abs(self.timeLength - D)
        self.cost = timeCost + peopleCost + dayCost + durCost
        #make case statement for "time", "attendees", "day" etc. 
        #try and save cost
        #get all points, dictionary of priorities, 
        
    def to_string(self, i, j, D):
        return "{'day':" + i + ",'StartTimre':" + j + "','EndTime':'" + j+D + "','Duratiion':'" + D + "','Location':'" + self.locationTime + "','Cost:" + self.cost + "]"
        
        
    def day_converter(self, date):
        
        year1 = date.split('-')[0]
        month1 = date.split('-')[1]
        day1 = date.split('-')[0]
        
        d1 = datetime.date(int(year1), int(month1), int(day1))
        
        return d1
    
        
class CostFunction:
        
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
        def make_object(self, timeAWAY, dateAWAY, duration, attendies, cost):
            #these two are where you need to check on the datetime stuff for sure
            self.VtimeAWAY =timeAWAY 
            self.VdateAWAY = dateAWAY
            #the rest are normal
            self.Vduration = duration
            self.Vattendies = attendies
            self.Vcost = cost
            
        def get_VtimeAWAY(self):
            return self.VtimeAWAY
        
        def get_VdateAWAY(self):
            return self.VdateAWAY
        
        def get_Vduration(self):
            return self.Vduration
        
        def get_Vattendies(self):
            return self.attendies
        
        def get_Vcost(self):
            return self.Vcost
    
        def get_key(item):
            return item[4]
    
    #note, i don't know if I will have the Defaults already, or if it will be pass to me, so 'til then I'm using it as an object
        def smallest_cost(self, POINT, Priority, Defaultsettings):  
            costList [len(POINT)]
            if (POINT is None):
                return None
            else:
                output = ""
                for i in range (len(POINT)):
                    cost1 = vector_cost(POINT[i], Priority)
                    costList.attend(cost1)
                sorted(costList, key=getKey)
                for i in range (0, 10, 1): #solutions 0 through 9
                    stringOutput = date_of_cost(costList[i], Defaultsettings, i)
                    output += stringOutput
                return output    
                
        
        #priority: date, granularity, attendies, duration, repeat, location, time 
    
        def vector_cost(self, point, Priority, Defaultsettings):
            self.TIME = point[1] #this is in minutes? assume so for now
            self.DATE = point[2]
            self.DUR = point[3] #0 = original duration, 2 = 2 granularity below duration, etc
            self.ATTEND = point[4] #0 = Max People, 2 = 2 people under Max
            
                                    
            timeCost = abs(TIME) * Priority.get('time') #what if the time and such is the other direction away from the goal time?
            dateCost = abs(DATE) * Priority.get('date') #so take the absolute value
            durCost = abs(DUR) * Priority.get('duration')
            attendCost = abs(ATTEND) * Priority.get('attendies') 
            
            cost = timeCost + dateCost + durCost + attendCost
            costobj = make_object(TIME, DATE, DUR, ATTEND, cost)
            return costobj
        
        def date_of_cost(self, objDate, Defaultsettings, solution):
            VTime = objDate.get_VtimeAWAY()
            VDay = objDate.get_VdateAWAY()
            VDur = objDate.get_Vduration()
            Vattend = objDate.get_Vattendies()
            Vcost = objDate.Vcost()
            
            defaultTime = Defaultsettings.get_prefered_time()
            defaultDate = Defaultsettings.get_prefered_date()
            defaultMax = Defaultsettings.get_mostPeople()
            defaultDur = Defaultsettings.get_timeLength()
            defaultLoc = Defaultsettings.get_location()
            granularity = Defaultsettings.getGranularity()
            
            #this assumes that the defaults are already in datetime
            daysAway = datetime.timedelta(days = VDay)
            newDay = defaultDate + daysAway #works when its pos or neg 
            i = newDay.date()
            
            timeAway = datetime.timedelta(hours = VTime)
            newTime = defaultTime + timeAway
            j = newTime.time() #the time the event starts at 
            
            timeLess = VDur * granularity #amount of time less it is 
            DTless = datetime.timedelta(hours = timeLess) #timeLes is datetime format
            D = defaultDur - DTless #full duration of the event
            
            EndTime = newTime + D
            End = EndTime.time()
            
            
            people = defaultMax - Vattend #check to see if wanted the list of actual people attending or just a number
                        
            return to_string(i, j, D, Vcost, solution, End, defaultLoc, people)
            
            
            #work in progress, but the basic is still pretty good
        def to_string(self, i, j, D, cost, sol, End, people):
            return "{'Solution':'" + sol + "','Day':" + i + ",'StartTime':" + j + "','EndTime':'" + End + "','Duration':'" + D + "','Location':'" + defaultLoc + "','Cost':" + cost + "','Attendees':" + people + "]"
            #just have to check whether or not to return the actual list of attendies who can make it
            
            
            
            
        
        
        
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
            
        
        
