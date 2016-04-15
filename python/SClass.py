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
    searchWidth = 0
    locationTime = 0
    preferedTime = 0
    TempPreferedTime = 0
    preferedDate = 0
    minimumPeople = 0
    granularity = 0
    mostPeople = 0
    BannedStart = 0
    BannedEnd = 0
    cost = 0
    
    def __init__(self, BannedStart, BannedEnd, timeLength, startDay, endDay, locationTime, preferedTime, minimumPeople, granularity, mostPeople, preferedDate):
        self.timeLength = timeLength
        self.searchWidth = endDay-startDay #will work with ints with time stamps or with date time objects to get a time delta object
        self.locationTime = locationTime
        self.preferedTime = preferedTime
        self.minimumPeople = minimumPeople
        self.granularity = granularity
        self.mostPeople = mostPeople
        self.preferedDate = preferedDate
        self.BannedStart = BannedStart
        self.BannedEnd = BannedEnd
    
    def getGranularity(self):
        return granularity
    
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
        
        
    def to_string(self, i, j, D):
        return "{'day':" + i + ",'StartTimre':" + j + "','EndTime':'" + j+D + "','Duratiion':'" + D + "','Location':'" + self.locationTime + "','Cost:" + self.cost + "]"
        
        
    def day_converter(self, date):
        
        year1 = date.split('-')[0]
        month1 = date.split('-')[1]
        day1 = date.split('-')[0]
        
        d1 = datetime.date(int(year1), int(month1), int(day1))
        
        return d1
        
        
    [10: "time", 200 : "durration"] #etc
    
    deg get_nth(self, n, dictionary)
        for key in dictionary:
            return minikey
        
    def modify_time(self, priority, discrete events, matrix):
        for time in matrix:
            if not is busy for duration(time, duration):
                good event [].append new event(time)
                cost[].append (cost of time)
                
            if reach matrix:
                return reached max ""
solution sets []
for number of solution sets
    matrix = subset [modified matrix]
    while
    switch priority:
        good events []
        case "time":
            modify_time()
        etc

#check to see if you can use miltidimensional lists/dictionaries
4matrix = []#4 dimension matrix
        def get_lowest_priority():
            
            #get the priority on the list/changes depending on the 
            #make it a for loop for number of solution sets
            #check for cost matrix
            
        
        
