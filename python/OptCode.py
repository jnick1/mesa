#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import numpty as np
phpserialize import 
import sys, json #for taking in data from php
if __name__ == "__main__":
    print "Hello World"

#IMPORTANT!!!
#RE-WRITE IT SO THAT THE PRIORITY IS MANIPULATED ONLY



#using numpty for matrix

#necessary objects needed before starting the program
 #Priority[] = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
 DAYS[] #specific days wanted
 attendies[] = [] #list of people on the project, those who accept
  
 #matrices necessary   check the row number because will might have it on years and I don't really want to deal with that nonsense
        #Note: make 2 matrixes for "Full Span" matrix for the year and the "Active Span" which is a weekly thing, 
        #convert the time to UTC
 masterCalender = [ [ 0 for i in range(7) ] for j in range(24) ] #calender for the final date selection, full week 7 days/24hrs
 peopleCalender = [ [ 0 for i in range(7) ] for j in range(24) ] #calender to keep track of the number of people
 googleCalender[]
 googleCal = [ [ 0 for i in range(7) ] for j in range(24) ] #calender to import 
 
 #first, enter the necessary data
    f = open('WillsBasicInfo', 'r') #the order of the text file should be as the following: 
    
    searchWidth = f.readline() #how many days are available
    gran = f.readline()  #How many minutes do want to increment the search by hour, can also be wither 15mins or 1 mins depending on user input
    bannedtimes = f.readline() #banned granularity increments based on user input, ie not over 933 or something
    preferedTime = f.readline() #the time that the person wants to have the specifically
    timeLength = f.readline() #how long the meeting is
    locationTime = f.readline() #how long it take to reach the location spot
    weekly = f.readline() #how often per week people want to meet
    f.close()#closing the file
    grularity = gran/60 #search it by what people wanted, else it's automatically 1 hour   

    tempString = 0 #how many people are there/now long the string is
    
 if (   ): #when OGANIZER clicks "Find Times" Btn
 {
    user = phpobject('WP_User', data)#'WP_User is the PHP function with the necessary information, data is the information necessary to transfer
    endTime = user.endTime  #reading the endTime from the PHP object, time to stop the search
    startTime = user.startTime #reading the startTime from the PHP object, where to start the search
    DayWeekMonth = user.DayWeekMonth #how long the input would be based on the number of days there are
    
    
    # Load the data that PHP will dump us (var_dump($resultData)
    for(i=0; i<7; i++):
        for(j=0; j<24; j++):
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
        for j in xrange(0, (24/granularity) - bannedtimes, granularity):
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
 
 numCalender[][] #calender to hold the amount of people at the event start
 returnCalender[][] #calender to return 
 List[] #hold the number
  
for i in range (0, searchWidth):
    day = DAYS[i] #for specific day
    for j in xrange(startTime, (24/granularity) - bannedtimes, granularity): #Need to check on how to change incremtation in python
        if(j-locationTime >= 0): #so it stays within the calender
            if (masterCalender[day][j-locationTime] == 0):#travel time is free before hand
                spot = False
                #this way, if the perfered time is not in the middle, it will still performed the action 
                while ( spot == False && preferedTime >=  || spot == False && preferedTime <= end ):
                    if (preferedTime == null): #there is no preferedTimes
                        people = 0
                        for L in range (0, tempString-1): #for loop goes through the string's position
                            count = 0 #count if the person has free time or not
                            for m in range (j, j+timeLength-1): #goes down through durration time starting at what j is. 
                                String = masterCalender[i][m]
                                if (String[L]!=0):
                                    count++ #adds to the count i if they can't do it
                            #done with m for loop
                            if (count == 0): #if the person is free throughout, the variable won't change
                                people ++ #adds to the number of people that can attend at that spot
                        #ends L for loop
                        numCalender[day][j] = people #adding the people amount in the num calender
                        List.attend(people) #adds the amount of people into a list to sort through
                        spot = False
                    else if(masterCalender[day][preferedTime-locationTime] == 0): #there is a preferedTime
                        if(masterCalender[day][preferedTime] == 0): #modified perfered Time of day
                        {
                            people = 0
                            for L in range (0, tempString-1): #for loop goes through the string's position
                                count = 0 #count if the person has free time or not
                                for m in range (preferedTime, preferedTime + timeLength-1): #goes down through durration time starting at what j is
                                    String = masterCalender[i][m]
                                    if (String[L]!=0):
                                        count++ #adds to the count i if they can't do it
                                #done with m for loop
                                if (count == 0): #if the person is free throughout, the variable won't change
                                    people ++ #adds to the number of people that can attend at that spot
                                #ends L for loop
                            numCalender[day][preferedTime] = people #adding the people amount in the num calender
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
        for j in range (len(numCalender[i])):
                if(numCalender[i][j] == List[q]):
                    returnCalender[i][j] = -1
                    count2 ++
    if(count2 =< weekly):
        done = True
    else:
        q++ #increment to the next biggest number in the list
  
    
    
#writing it to a text file
    for row in returnCalender:
        for column, data in enumerate(row):
            out += formats[column].format(data)
        out += "\n"

    with open("Times.txt","wt") as file:
        file.write(out)
