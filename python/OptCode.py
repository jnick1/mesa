#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import numpty as np
pip install phpserialize 
phpserialize import 
import sys, json #for taking in data from php
if __name__ == "__main__":
    print "Hello World"
#using numpty for matrix

#necessary objects needed before starting the program
 Priority[7] = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
 DAYS[7] #specific days wanted
  
 #matrices necessary   check the row number because will might have it on years and I don't really want to deal with that nonsense
        #Note: make 2 matrixes for "Full Span" matrix for the year and the "Active Span" which is a weekly thing, 
        #convert the time to UTC
 
 
 #first, enter the necessary data
data = json.loads(blSettings)#look over blSettings later    


bannedtimesStart = data['blacklist']['earliest'] #start of times that we don't use
bannedtimesEnd = data['blacklist']['latest'] #start of times that we don't use
startDate = DTstart #when the calender starts at
CutOffDate = data['date']['furthest'] #don't go on beyond this point, double check this
preferedTime = data['time'] #the time that the person wants to have the specifically
preferedDate = data['date'] #day that the person wants, *go through code with new updated stuff*
timeLength = data['durration'] #how long the meeting is *so far for the max length* 
weekly = txRRule #how often per week people want to meet
minimumPeople = data['attendees']['minattendees'] #the minimum number of people needed for the meeting

searchWidth = CutOffDate-startDate

granularity = 60/15 #search it by what people wanted, else it's automatically 1 hour   
    
 
masterCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender for the final date selection, full week 7 days/24hrs
peopleCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender to keep track of the number of people
GoogleCalender = [ [ 0 for i in range(searchWidth) ] for j in range(24*granularity) ] #calender to import 
tempString = 0 #how many people are there/now long the string is

 if (   ): #when OGANIZER clicks "Find Times" Btn
 {
    data = json.loads(blAttendees)#list of users and email addresses, optional(false if have to be there), response status()
        #go to table users, find said user (pk user id), table calenders, get the calender data there that matches the user id here
        
    
    user = phpobject('WP_User', data)#'WP_User is the PHP function with the necessary information, data is the information necessary to transfer
    endTime = user.endTime  #reading the endTime from the PHP object, time to stop the search
    startTime = user.startTime #reading the startTime from the PHP object, where to start the search
    DayWeekMonth = user.DayWeekMonth #how long the input would be based on the number of days there are
    locationTime = data[''] #how long it take to reach the location spot, changes per user
    
    # Load the data that PHP will dump us (var_dump($resultData)
    for i in range (0, searchWidth):
        for j in xrange (0, 24*granularity, granularity):
            {
                try:
                    data = json.loads(sys.argv[i])[j]
                except:
                    print ("ERROR")
                    sys.exit(1)
                GoogleCalender[i][j] = data
            }
    #input the google calender 
    
    #adding their Goolge calender to the combined Master Calender
    for i in range (len(GoogleCalender)):
        for j in xrange(0, (24*granularity) - bannedtimes, granularity):
            if GoogleCalender[i][j] == '1':
                test = masterCalender[i][j]
                test += '1'
                masterCalender[i][j] = test
            else:
                test = masterCalender[i][j]
                test += '0'
                masterCalender[i][j] = test
    
    tempString ++
 }#END ATTENDIES IF STATEMENT
 
 numCalender[searchWidth][24*granularity] #calender to hold the amount of people at the event start
 returnCalender[searchWidth][24*granularity] #calender to return 
 durrationCal[searchWidth][24*granularity]
 List[maxPeople] #hold the number of people that the people can attend

for D in xrange(timeLength, 0, -15): #going through the durration times to decrease it too 
    for i in range (0, searchWidth):
        day = DAYS[i] #for specific day
        for j in xrange(startTime, (24*granularity) - bannedtimes, granularity): #Need to check on how to change incremtation in python
            if(j-locationTime >= 0): #so it stays within the calender
                if (masterCalender[day][j-locationTime] == 0):#travel time is free before hand
                    spot = False
                    #this way, if the perfered time is not in the middle, it will still performed the action 
                    while ( spot == False && preferedTime >=startTime  || spot == False && preferedTime <= endTime ):
                        if (preferedTime is None): #there is no preferedTimes
                            people = 0
                            for L in range (0, tempString-1): #for loop goes through the string's position
                                count = 0 #count if the person has free time or not
                                for m in range (j, j+D-1): #goes down through durration time starting at what j is. 
                                    String = masterCalender[i][m]
                                    if (String[L]!=0):
                                        count++ #adds to the count i if they can't do it
                                #done with m for loop
                                if (count == 0): #if the person is free throughout, the variable won't change
                                    people ++ #adds to the number of people that can attend at that spot
                            #ends L for loop
                            numCalender[day][j] = people #adding the people amount in the num calender
                            if (durrationCal[day][j] is None): #adding the durration time if case it is modulated
                                durrationCal[day][j] = timeLength
                            List.attend(people) #adds the amount of people into a list to sort through
                            spot = False
                        else if(masterCalender[day][preferedTime-locationTime] == 0): #there is a preferedTime
                            if(masterCalender[day][preferedTime] == 0): #modified perfered Time of day
                            {
                                people = 0
                                for L in range (0, tempString-1): #for loop goes through the string's position
                                    count = 0 #count if the person has free time or not
                                    for m in range (preferedTime, preferedTime + D-1): #goes down through durration time starting at what j is
                                        String = masterCalender[i][m]
                                        if (String[L]!=0):
                                            count++ #adds to the count i if they can't do it
                                    #done with m for loop
                                    if (count == 0): #if the person is free throughout, the variable won't change
                                        people ++ #adds to the number of people that can attend at that spot
                                    #ends L for loop
                                numCalender[day][preferedTime] = people #adding the people amount in the num calender
                                if (durrationCal[day][preferedTime] is None): #adding the durration time if case it is modulated
                                    durrationCal[day][preferedTime] = timeLength
                                List.attend(people) #adds the amount of people into a list to sort through
                                spot = True #get out of loop early
                            }
                        else:
                            preferedTime = preferedTime + (granularity*count* (-1^count))  #branches off hour by hour          
                            
    
List.reverse() #biggest number is on top, easier to find most people

done = False
count2 = 0
q=0
while(done == False):
    for i in range (len(numCalender)):
        if (i == CutOffDate):
            done = True
        else:
            for j in range (len(numCalender[i])):
                if(numCalender[i][j] == List[q]):
                    returnCalender[i][j] = -1
                    count2 ++
    if(count2 => weekly):
        done = True
    else:
        q++ #increment to the next biggest number in the list
  

#counting the cost
returnList = " " #making it as big as the amount of weekly times
for i in range (len(returnCalnder)):
    if (i == CutOffDate):
        break
    else:
        for j in range (len(returnCalender)):
            if (returnCalender[i][j] == -1):
                #checking the cost of the thing
                costTotal = 0 #if perfect, the cost would just stay 0
                timeCost = abs(j - preferedTime) #cost of how far away from the preferedTime it is
                if (numCalender[i][j] < minimumPeople):
                    temp = numCalender[i][j]
                    peoplCost = minimumPeople - temp
            
                seven = abs(preferedDay - i)
                if (seven % 7 == 0): #if its on the exact same day
                    dayCost = 0
                else:
                    if ((seven + 1)%7 ==0  || (seven + 6)%7 == 0): #one day off
                        dayCost = 1
                    else if ((seven + 2)%7 ==0  || (seven + 5)%7 == 0): ##two days off
                        dayCost = 2
                    else:
                        dayCost = 3
                
                durCost = abs(timeLength - durrationCal[i][j] )
                
                #adding the cost together
                cost = timeCost + peopleCost + dayCost + durCost
                StringFinal = "day: " + i + " StartTime: " + j + "EndTime: " + j+ durrationCal[i][j] + "Durration: " +durrationCal[i][j] 
                    +  "Location: " + locationTime +  " Cost: " + cost "/n"
                returnList += StringFinal


print returnList
    
#writing it to a text file
    for row in returnCalender:
        for column, data in enumerate(row):
            out += formats[column].format(data)
        out += "\n"

    with open("Times.txt","wt") as file:
        file.write(out)
