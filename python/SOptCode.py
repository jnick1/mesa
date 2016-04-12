#!/usr/bin/env python2
#encoding: UTF-8
import sys, json #for taking in data from php


fkEventid = sys.argv[1]

#using numpty for matrix
#necessary objects needed before starting the program
Priority = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
DAYS = [0, 1, 2, 3, 4, 5, 6] #specific days wanted

masterCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender for the final date selection, full week 7 days/24hrs
GoogleCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender to import 
tempString = 0 #how many people are there/now long the string i

locaArray = []

#first, enter the necessary data
data = json.loads(blSettings)
repeat = json.loads(txrRule)


bannedtimesStart = int(data['blacklist']['earliest']) #start of times that we don't use
bannedtimesEnd = int(data['blacklist']['latest']) #start of times that we don't use
startDate = int(json.loads(DTstart)) #when the calender starts at
CutOffDate = int(data['date']['furthest']) #don't go on beyond this point, double check this
preferedTime = int(data['time']) #the time that the person wants to have the specifically
preferedDate = int(data['date']) #day that the person wants, *go through code with new updated stuff*
timeLength = int(data['duration']) #how long the meeting is *so far for the max length* 
minimumPeople = int(data['attendees']['minattendees']) #the minimum number of people needed for the meeting
granularity = 60/15 #search it by what people wanted, else it's automatically 1 hour   
user1 = json.loads(blAttendees)#list of users and email addresses, optional(false if have to be there), response status()\
locationTime = 0
 

Param = MasterMatrix(timeLength, startDate, CutOffDate, locationTime, preferedTime, minimumPeople, granularity, len(user1), preferedDate)

print ("{data load, calendar retrival start/}n")        
for p in range (len(user1)):
    attend1 = user1[p]['responseStatus'] #see whether they acepted or not
    print ("{Got Response Status}/n")
    if (attend1 == True): #if they did accept
        
        email = user1[p]['email']
        print ("{Got Email}/n")
        sql = ('INSERT INTO {} (fkUserid, fkEventid) VALUES '
            '(%s, %s)'.format(self.db_scan_table))
        self.cursor.execute(sql, (email, fkEventid))
        print ("{Got ID}/n")
        #don't know if there is another step between searching for the calender and loading it. leave this as a reminder
        
        calTest = json.loads(blCalendar)#load calender that matches the id
        print ("{Got Calender}/n")
        tempString +=1
        for h in range (len(calTest)):
            for r in xrange(calTest[h][0], len(calTest[h])):
            #locationTime = calTest['h']['travel_time'] #how long it take to reach the location spot, changes per user, not main focus now
                startTime = calTest[h][r]['start_time'] #gets the day/time for the start time
                StartI = int(startTime.split('T')[0])
                EndI = int(startTime.split('T')[1])
                endTime = calTest[h][r]['end_time'] #gets the day/time for the end time
                StartJ = int(endTime.split('T')[0])
                EndJ = int(endTime.split('T')[1])
                
                Person1 = PersonalMatrixFunctions(StartJ, EndJ, StartI, EndI, Param.getGranularity() )
                Person1.eventMatrix()
                
                locaArray.append(Person1.getLocation)
                masterCalender= Person1.AddingMatrix(masterCalender, Person1.getStartTime, Person1.getEndTime, Person1.getGranularity)
                
            print ("{made matrix}/n")          
            #adding their Goolge calender to the combined Master Calender
            
     
    #END ATTENDIES IF STATEMENT
print ("{15 master calendar complete}/n")  


TestObject = PersonalMatrixFunctions() #assume this already is set up with the other stuff

print ("{search through calendar}/n") 
returnList = Param.findTimes(self, MasterMatrix, bannedtimesStart, bannedtimesEnd, granularity, locaArray)

print (json.dumps(returnList)) #printing it via JSON style

