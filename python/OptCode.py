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
  
 #matrices necessary
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

    tempString = 0
 if (   ): #when OGANIZER clicks "Find Times" Btn
 {
    user = phpobject('WP_User', data)#'WP_User is the PHP function with the necessary information, data is the information necessary to transfer
    endTime = user.endTime  #reading the endTime from the PHP object, time to stop the search
    startTime = user.startTime #reading the startTime from the PHP object, where to start the search
        
    # Load the data that PHP will dump us (var_dump($resultData)
    for(i=0; i<7; i++):
        for(j=0; j<24; j++):
            {
                try:
                    data = json.loads(sys.argv[i])[j]
                except:
                    print ("ERROR")
                    sys.exit(1)
                googleCalender[i][j] = data
            }
    #input the google calender 
    
    #moving their Goolge calender to a normCalender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity): #hard to tell what to increment j by because it varies with each person
        {
            if GoogleCalender[i][j] = '1':  #if there is an event in the google calender
                NormCalender[i][j] = '1' 
                peopleCalender[i][j] += '1' 
            else:
                peopleCalender[1][j] += '0'
                NormCalender[i][j] = '0' 
        }
    }
    
for(i = 0; i<searchWidth; i++):
    for(j=start; j<(24/granularity) - bannedtimes; j+granularity):
        day = DAYS[i] #for specific day
        if(j-locationTime >= 0): #so it stays within the calender
            if (NormCalender[day][j-locationTime] == 0):#travel time is free
                spot = False
                do:{
                    if (preferedTime == null): #there is no preferedTimes
                        if (NormCalender[day][j] == 0):
                            do{
                                count = 0
                                for (k=startTime; k<timeLength; k+granularity):
                                    {if(NormCalender[day][k] == '0'):
                                        count +=1
                                    }
                                if(count == timeLength):
                                {
                                    masterCalender[day][startTime] = -1 #marking the available start time, combining it for everyone
                                }
                                else:
                                    Start +=granularity
                                }while(j<(24/granularity) - bannedtimes)
                            spot = True #get out of loop early
                    else if(NormCalender[day][preferedTime-locationTime] == 0): #there is a preferedTime
                        if(NormCalender[day][preferedTime] == 0): #modified perfered Time of day
                        {
                            do{
                                count = 0
                                for (k=preferedTime; k<timeLength; k+granularity):
                                    {if(NormCalender[day][k] == '0'):
                                        count +=1
                                    }
                                if(count == timeLength):
                                {
                                    masterCalender[day][preferedTime] = -1 #marking the available start time, combining it for everyone
                                }
                                else:
                                    Start +=granularity
                                }while(j<(24/granularity) - bannedtimes)
                            spot = True #get out of loop early
                        }
                    else:
                        preferedTime = preferedTime + (granularity*count* (-1^count))  #branches off hour by hour          
                    }while ( spot == False && preferedTime >=  || spot == False && preferedTime <= end ) 
                    #this way, if the perfered time is not in the middle, it will still performed the action
                    
     #attendies.insert(peopleCalender) do i really need to put it in a list now?
    #saving the calender into a list to hold on too (hopefully)
    
    tempString ++
 }#END ATTENDIES IF STATEMENT
 
 numCalender[][] #calender to hold the amount of people at the event start
 returnCalender[][] #calender to return 
 List[] #hold the number
  
for (i=0; i<7; i++):
    for(j=0; j<(24/granularity); j+granularity):
        people = 0
        for(L=0; L<tempString; L++): #for loop goes through the string's position
            count = 0 #count if the person has free time or not
            for (m=j; m< j + timeLength; m+granularity): #goes down through durration time starting at what j is
                String = peopleCalender[i][m]
                if (String[L]!=0):
                    count++ #adds to the count i if they can't do it
                #done with m for loop
            if (count == 0): #if the person is free throughout, the variable won't change
                people ++ #adds to the number of people that can attend at that spot
            #ends L for loop
        numCalender[i][j] = people #adding the people amount in the num calender
        List.attend(people) #adds the amount of people into a list to sort through
    #end j for loop
#end i for loop  
    
List.sort(reverse) #biggest number is on top, easier to find most people

done = False
count2 = 0
q=0
do{
    for(i = 0; i<7; i++):
            for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
                if(numCalender[i][j] == List[q]):
                    returnCalender[i][j] = -1
                    count2 ++
    if(count2 =< weekly):
        done = True
    else:
        q++ #increment to the next biggest number in the list
  }while(done = False) #so it has the minimum number of recursion times
    
#writing it to a text file
    for row in returnCalender:
        for column, data in enumerate(row):
            out += formats[column].format(data)
        out += "\n"

    with open("Times.txt","wt") as file:
        file.write(out)
