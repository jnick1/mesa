#!/usr/bin/env python2
#encoding: UTF-8
print ("test")
import sys
import json #for taking in data from php
from functions import parseRRule

dtStart = sys.argv[1]
dtEnd = sys.argv[2]
txLocation = sys.argv[3]
txRRule = sys.argv[4]

temp = open("C:/wamp/www/mesa/python/temp1.json", "r")
calendars = json.loads(temp.read())
temp.close()
temp = open("C:/wamp/www/mesa/python/temp2.json", "r")
blSettings = json.loads(temp.read())
temp.close()
print(blSettings)

RRule = parseRRule(txRRule)
print (RRule)
#using numpty for matrix
<<<<<<< HEAD
print "{START}/n"
#necessary objects needed before starting the program
Priority = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
print "{1}/n"
DAYS = [0, 1, 2, 3, 4, 5, 6] #specific days wanted
print "{2}/n"
  
=======
print ("START/n")
#necessary objects needed before starting the program
Priority = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
#DAYS = [0] * 7 #specific days wanted

startDate = dtStart #when the calender starts at

>>>>>>> refs/remotes/origin/master
#matrices necessary   check the row number because will might have it on years and I don't really want to deal with that nonsense
        #Note: make 2 matrixes for "Full Span" matrix for the year and the "Active Span" which is a weekly thing, 
        #convert the time to UTC

#first, enter the necessary data
<<<<<<< HEAD
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
 
=======
if(blSettings["useDefault"]!=True):
    bannedtimesStart = blSettings['blacklist']['earliest'] #start of times that we don't use
    bannedtimesEnd = blSettings['blacklist']['latest'] #start of times that we don't use
    CutOffDate = blSettings['date']['furthest'] #don't go on beyond this point, double check this
    preferedTime = blSettings['time'] #the time that the person wants to have the specifically
    preferedDate = blSettings['date'] #day that the person wants, *go through code with new updated stuff*
    timeLength = blSettings['durration'] #how long the meeting is *so far for the max length* 
    minimumPeople = blSettings['attendees']['minattendees'] #the minimum number of people needed for the meeting
else:
    bannedtimesStart = "00:00:00"
    bannedtimesEnd = "23:59:59"
    CutOffDate = ""
    
    
>>>>>>> refs/remotes/origin/master

Param = MasterMatrix(timeLength, startDate, CutOffDate, locationTime, preferedTime, minimumPeople, granularity, len(user1), preferedDate)


print "{12}/n"
masterCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender for the final date selection, full week 7 days/24hrs
GoogleCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender to import 
tempString = 0 #how many people are there/now long the string is
print "{13}/n"

<<<<<<< HEAD
=======
user1 = json.loads(blAttendees)#list of users and email addresses, optional(false if have to be there), response status()
        #go to table users, find said user (pk user id), table calenders, get the calender data there that matches the user id here

print ("data load, calendar retrival start/n")
for l in range (len(user1)):
    attend1 = user1[l]['responseStatus'] #see whether they acepted or not
    if (attend1 == True): #if they did accept
>>>>>>> refs/remotes/origin/master
        
print "{14}/n"
print "{data load, calendar retrival start}/n"        
for p in range (len(user1)):
    attend1 = user1[p]['responseStatus'] #see whether they acepted or not
    print "{Got Response Status}/n"
    if (attend1 == True): #if they did accept
        
<<<<<<< HEAD
        email = user1[p]['email']
        print "{Got Email}/n"
        sql = ('INSERT INTO {} (fkUserid, fkEventid) VALUES '
            '(%s, %s)'.format(self.db_scan_table))
        self.cursor.execute(sql, (email, fkEventid))
        print "{Got ID}/n"
=======
>>>>>>> refs/remotes/origin/master
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
<<<<<<< HEAD
print "{15 master calendar complete}/n"  

=======
print ("master calendar complete/n")  
numCalender[searchWidth][24*granularity] #calender to hold the amount of people at the event start
returnCalender[searchWidth][24*granularity] #calender to return 
durrationCal[searchWidth][24*granularity]
List[maxPeople] #hold the number of people that the people can attend

print ("search through calendar/n") 
for D in xrange(timeLength, 0, -15): #going through the durration times to decrease it too 
    for i in range (0, searchWidth):
        day = i #DAYS[i] for specific day, code it to fix it later
        for j in xrange(startTime, (24*granularity) - bannedtimes, granularity): #Need to check on how to change incremtation in python
            if(j-locationTime >= 0): #so it stays within the calender
                if (masterCalender[day][j-locationTime] == 0):#travel time is free before hand
                    spot = False
                    #this way, if the perfered time is not in the middle, it will still performed the action 
                    while ( spot == False and preferedTime >= startTime or spot == False and preferedTime <= endTime ):
                        if (preferedTime is None): #there is no preferedTimes
                            people = 0
                            for L in range (0, tempString-1): #for loop goes through the string's position
                                count = 0 #count if the person has free time or not
                                for m in range (j, j+D-1): #goes down through durration time starting at what j is. 
                                    String = masterCalender[i][m]
                                    if (String[L]!=0):
                                        count+=1 #adds to the count i if they can't do it
                                #done with m for loop
                                if (count == 0): #if the person is free throughout, the variable won't change
                                    people +=1 #adds to the number of people that can attend at that spot
                            #ends L for loop
                            numCalender[day][j] = people #adding the people amount in the num calender
                            if (durrationCal[day][j] is None): #adding the durration time if case it is modulated
                                durrationCal[day][j] = timeLength
                            List.attend(people) #adds the amount of people into a list to sort through
                            spot = False
                            # end PREFEREDTIME IS NONE if statement
                        if(masterCalender[day][preferedTime-locationTime] == 0): #there is a preferedTime
                            if(masterCalender[day][preferedTime] == 0): #modified perfered Time of day                  
                                for L in range (0, tempString-1): #for loop goes through the string's position
                                    count = 0 #count if the person has free time or not
                                    for m in range (preferedTime, preferedTime + D-1): #goes down through durration time starting at what j is
                                        String = masterCalender[i][m]
                                        if(String[L]!=0):
                                            count+=1 #adds to the count i if they can't do it
                                    #done with m for loop
                                    if(count == 0): #if the person is free throughout, the variable won't change
                                        people +=1 #adds to the number of people that can attend at that spot
                                    #ends L for loop
                                numCalender[day][preferedTime] = people #adding the people amount in the num calender
                                if (durrationCal[day][preferedTime] is None): #adding the durration time if case it is modulated
                                    durrationCal[day][preferedTime] = timeLength
                                List.attend(people) #adds the amount of people into a list to sort through
                                spot = True #get out of loop early
                        else:
                            preferedTime = preferedTime + (granularity*count* (-1^count))  #branches off hour by hour          
                     

print ("found spot options/n") 
>>>>>>> refs/remotes/origin/master

TestObject #assume this already is set up with the other stuff

<<<<<<< HEAD
print "{search through calendar}/n" 
returnList = Param.findTimes(self, MasterMatrix, TestObject.getStartTime, TestObject.getEndTime, TestObject.granularity)

print (json.dumps(returnList)) #printing it via JSON style

    

=======
print ("searching for people in spots/n") 
done = False
C2 = 0
q=0
while(done == False):
    for i in range (len(numCalender)):
        if (i == CutOffDate):
            done = True
        else:
            for j in range (len(numCalender[i])):
                if(numCalender[i][j] == List[q]):
                    returnCalender[i][j] = -1
                    C2 +=1
    if(C2 >= weekly):
        done = True
    else:
        q+=1 #increment to the next biggest number in the list
  
print ("found most people spots /n finding cost of them ") 

#counting the cost
returnList = "" #making it as big as the amount of weekly times
for i in range (len(returnCalnder)):
    if (i == CutOffDate):
        break
    else:
        for j in range (len(returnCalender)):
            if (returnCalender[i][j] == -1):
                #checking the cost of the thing
                cost = 0 #if perfect, the cost would just stay 0
                timeCost = abs(j - preferedTime) #cost of how far away from the preferedTime it is
                if (numCalender[i][j] < minimumPeople):
                    temp = numCalender[i][j]
                    peopleCost = minimumPeople - temp
            
                seven = abs(preferedDay - i)
                if (seven % 7 == 0): #if its on the exact same day
                    dayCost = 0
                else:
                    if ((seven + 1)%7 ==0  or (seven + 6)%7 == 0): #one day off
                        dayCost = 1
                    if ((seven + 2)%7 ==0  or (seven + 5)%7 == 0): ##two days off
                        dayCost = 2
                    else:
                        dayCost = 3
                
                durCost = abs(timeLength - durrationCal[i][j] )
                
                #adding the cost together
                cost = timeCost + peopleCost + dayCost + durCost
                StringFinal = "{day:" + i + ",StartTime:" + j + ",EndTime:" + j+ durrationCal[i][j] + ",Duration:" +durrationCal[i][j] +  ",Location:" + locationTime +  ",Cost:" + cost + "}"
                returnList += StringFinal

print (json.dumps(returnList)) #printing it via JSON style
print (returnList)    #printing it normal style
    
>>>>>>> refs/remotes/origin/master
