#!/usr/bin/env python2
#encoding: UTF-8
import sys, json #for taking in data from php

fkEventid = sys.argv[1]

#using numpty for matrix
print "{START}/n"
#necessary objects needed before starting the program
Priority = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
print "{1}/n"
DAYS = [0, 1, 2, 3, 4, 5, 6] #specific days wanted
print "{2}/n"
  
#matrices necessary   check the row number because will might have it on years and I don't really want to deal with that nonsense
        #Note: make 2 matrixes for "Full Span" matrix for the year and the "Active Span" which is a weekly thing, 
        #convert the time to UTC

#first, enter the necessary data
print "{3}/n"
data = json.loads(blSettings)
print "{4}/n"
repeat = json.loads(txrRule)
print "{5}/n"

print "{6}/n"
bannedtimesStart = int(data['blacklist']['earliest']) #start of times that we don't use
print "{7}/n"
bannedtimesEnd = int(data['blacklist']['latest']) #start of times that we don't use
startDate = int(json.loads(DTstart)) #when the calender starts at
CutOffDate = int(data['date']['furthest']) #don't go on beyond this point, double check this
print "{8}/n"
preferedTime = int(data['time']) #the time that the person wants to have the specifically
preferedDate = int(data['date']) #day that the person wants, *go through code with new updated stuff*
print "{9}/n"
timeLength = int(data['duration']) #how long the meeting is *so far for the max length* 
minimumPeople = int(data['attendees']['minattendees']) #the minimum number of people needed for the meeting
print "{10}/n"
granularity = 60/15 #search it by what people wanted, else it's automatically 1 hour   
user1 = json.loads(blAttendees)#list of users and email addresses, optional(false if have to be there), response status()\
print "{11}/n"
locationTime = 0
 

Param = MasterMatrix(timeLength, startDate, CutOffDate, locationTime, preferedTime, minimumPeople, granularity, len(user1), preferedDate)


print "{12}/n"
masterCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender for the final date selection, full week 7 days/24hrs
GoogleCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender to import 
tempString = 0 #how many people are there/now long the string is
print "{13}/n"

        
print "{14}/n"
print "{data load, calendar retrival start}/n"        
for p in range (len(user1)):
    attend1 = user1[p]['responseStatus'] #see whether they acepted or not
    print "{Got Response Status}/n"
    if (attend1 == True): #if they did accept
        
        email = user1[p]['email']
        print "{Got Email}/n"
        sql = ('INSERT INTO {} (fkUserid, fkEventid) VALUES '
            '(%s, %s)'.format(self.db_scan_table))
        self.cursor.execute(sql, (email, fkEventid))
        print "{Got ID}/n"
        #don't know if there is another step between searching for the calender and loading it. leave this as a reminder
        
        calTest = json.loads(blCalendar)#load calender that matches the id
        print "{Got Calender}/n"
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
                        
            for i in range (StartI, EndI):
                for j in xrange (StartJ, EndJ, granularity):
                    GoogleCalender[i][j] = '1'
            print "{made matrix}/n"          
            #adding their Goolge calender to the combined Master Calender
            for i in range (len(GoogleCalender)):
                for j in xrange(bannedtimesStart, (24*granularity) - bannedtimesEnd, granularity):
                    if GoogleCalender[i][j] == '1':
                        test = masterCalender[i][j]
                        test += '1'
                        masterCalender[i][j] = test
                    else:
                        test = masterCalender[i][j]
                        test += '0'
                        masterCalender[i][j] = test
            print "{added to masterCal}/n"
    #END ATTENDIES IF STATEMENT
print "{15 master calendar complete}/n"  


TestObject #assume this already is set up with the other stuff

print "{search through calendar}/n" 
returnList = Param.findTimes(self, MasterMatrix, TestObject.getStartTime, TestObject.getEndTime, TestObject.granularity)

print (json.dumps(returnList)) #printing it via JSON style

    

