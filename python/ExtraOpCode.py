#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

if __name__ == "__main__":
    print "Hello World"

 numCalender[][] #calender to hold the amount of people at the event start
 returnCalender[][] #calender to return 
 List[] #hold the number
 
 list_of_lists = [ [1, 2, 3], [4, 5, 6], [7, 8, 9]]
for list in list_of_lists:
    for x in list:
        print x
 
 numCalender[searchWidth][24*granularity] #calender to hold the amount of people at the event start
returnCalender[searchWidth][24*granularity] #calender to return 
durationCal[searchWidth][24*granularity]
List[len(user1)] #hold the number of people that the people can attend
 
 #moving their Goolge calender to a normCalender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity): #hard to tell what to increment j by because it varies with each person
        {
            if GoogleCalender[i][j] = '1':  #if there is an event in the google calender
                NormCalender[i][j] = '1' 
                masterCalender[i][j] += '1' 
            else:
                masterCalender[1][j] += '0'
                NormCalender[i][j] = '0' 
        }
    }                  
                   
    #attempt 1 for shifting through code
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
                                    peopleCalender[day][startTime] = -1 #marking the available start time, combining it for everyone
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
                                    peopleCalender[day][preferedTime] = -1 #marking the available start time, combining it for everyone
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
                    
#recursive method to find the durration time
for (i=0; i<7; i++):
    for(j=0; j<(24/granularity); j+granularity):
        if(peopleCalender[i][j] == -1):
            #move on here
            people = 0
            for(L=0; L<tempString; L++): #for loop goes through the string's position
                count = 0 #count if the person has free time or not
                for (m=j; m< j + timeLength; m+granularity): #goes down through durration time starting at what j is
                    String = masterCalender[i][m]
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
 

def DayLocation ( DAYS, granlarity, bannedtimes, masterCalender, NormCalender, Priority)
{for (i=0; i<DAYS.length(); i++)
            {for (j=0; j<(24/granularity) - bannedtimes; j+granularity): #do this for each hour 
               {day = DAYS[i] #reads number for the specific day to correlate with the matrix
                if(NormCalender[day][j] == 0): #search in day range
                {
                    points = masterCalender[day][j]
                    masterCalender[day][j] = points + Priority[2]
                }
               } 
            }
}
    
def TimeLocation (DAYS, NormCalender, MasterCalender, Priority, preferedTime, granularity)
{for (i = 0; i<DAYS.length(); i++): #do this for each day 
            {day = DAYS[i]
            if(NormCalender[day][preferedTime] == 0): #original perfered Time of day
                {
                    points = masterCalender[day][preferedTime]
                    masterCalender[day][preferedTime] = points + Priority[1]
                }
            else:
                spot = False
                count = 1
                do:
                    { preferedTime = preferedTime + (granularity*count* (-1^count))#branching out hour by hour
                    if(NormCalender[day][preferedTime] == 0): #modified perfered Time of day
                        {
                            points = masterCalender[i][preferedTime]
                            masterCalender[day][preferedTime] = points + Priority[1]
                            spot = True #get out of loop early
                        }
                    else:
                        count++            
                    }while ( spot == False && preferedTime >=  || spot == False && preferedTime <= end ) 
                    #this way, if the perfered time is not in the middle, it will still performed the action
            }
        }

def peopleCounting(searchwidth, granularity, bannedtimes, peopleCalender):
    {    attend = 0 # number of people who accepts
            for (i =0; i <searchwidth; i++):
                {for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
                    {
                        Attendees = peopleCalender[i][j]
                                           
                        for (i =0; i<length.info; i++): #don't know if its necessary or not, but will leave it in at the moment
                            {if (0 in Attendees):
                                attend +=1
                            }
                        
                        masterCalender[i][j] = attend
                    }
                }
    }

def durrationLocation (granularity, bannedtimes, startTime, durrationTime, peopleCalender, masterCalender):
{
    Start = startTime
    timeLength = durrationTime
    spot = false
    count = 0
for (i =0; i <searchwidth; i++):
    {for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        do{
            for (k=Start; k<timeLength; k+granularity):
                {if(peopleCalender[i][k] == '0'):
                    count +=1
                }
            if(count == timeLength):
                {
                    masterCalender[i][Start] = -1
                }
            else:
                Start +=granularity
            }while(j<(24/granularity) - bannedtimes)
    }
}

#writing it to a text file
    for row in returnCalender:
        for column, data in enumerate(row):
            out += formats[column].format(data)
        out += "\n"

    with open("Times.txt","wt") as file:
        file.write(out)
        

for D in xrange(timeLength, 0, -15): #going through the durration times to decrease it too 
    for i in range (0, searchWidth):
        day = i #DAYS[i] for specific day, code it to fix it later
        for j in xrange(bannedtimesStart, (24*granularity) - bannedtimesEnd, granularity): #Need to check on how to change incremtation in python
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
                            if (durationCal[day][j] is None): #adding the durration time if case it is modulated
                                durationCal[day][j] = timeLength
                            List.attend(people) #adds the amount of people into a list to sort through
                            spot = True
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
                                if (durationCal[day][preferedTime] is None): #adding the durration time if case it is modulated
                                    durationCal[day][preferedTime] = timeLength
                                List.attend(people) #adds the amount of people into a list to sort through
                                spot = True #get out of loop early
                        else:
                            preferedTime = preferedTime + (granularity*count* (-1^count))  #branches off hour by hour          
                     

print "{found spot options}/n" 

List.reverse() #biggest number is on top, easier to find most people

print "{searching for people in spots}/n" 
done = False
C2 = 0
q=0
while(done == False):
    for i in range (len(numCalender)):
        if (i == CutOffDate):
            done = True
        else:
            for j in range (len(numCalender[i])):
                if (numCalender[i][j] > minimumPeople):
                    if(numCalender[i][j] == List[q]):
                        returnCalender[i][j] = -1
                        C2 +=1
    if(C2 >= weekly):
        done = True
    else:
        q+=1 #increment to the next biggest number in the list
  
print "{found most people spots /n finding cost of them}" 

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
                if (numCalender[i][j] < len(user1)): #edit this so that it costs how many priority people couldn't attend
                    temp = numCalender[i][j]
                    peopleCost = len(user1) - temp
            
                seven = abs(preferedDate - i)
                if (seven % 7 == 0): #if its on the exact same day
                    dayCost = 0
                else:
                    if ((seven + 1)%7 ==0  or (seven + 6)%7 == 0): #one day off
                        dayCost = 1
                    if ((seven + 2)%7 ==0  or (seven + 5)%7 == 0): ##two days off
                        dayCost = 2
                    else:
                        dayCost = 3
                
                durCost = abs(timeLength - durationCal[i][j] )
                
                #adding the cost together
                cost = timeCost + peopleCost + dayCost + durCost
                StringFinal = "{day:" + i + ",StartTime:" + j + ",EndTime:" + j+ durationCal[i][j] + ",Durration:" +durationCal[i][j] +  ",Location:" + locationTime +  ",Cost:" + cost + "}"
                returnList += StringFinal


print (json.dumps(returnList)) #printing it via JSON style
print returnList    #printing it normal style    
      
if(repeat[FREQ] == 'WEEKLY'): #how often per week people want to meet
    weekly = 1
if (repeat[FREQ] == 'daily'):
    weekly = 7
#MAY OR MAY NOT USE DEPENDING
    #having the priority set list seperate because idk if there will be exact results if its at the end of the other file
    #g = open('PriorityTextFile', 'r') 
    #for (i=0; i<7; i++):
    #    test = Priority[i]
    #    Priority[i] = test * g.readline() #each will get either LOW(1), MED(10), or HIGH(100) to determine the importance value
    #g.close() #closing priority file
    #same as priority list
    #k = open('specificDaysTextFile', 'r')
    #    DAYS = k.read().split(',') #insert number for specific day, 0=SUN, 1=MON, etc
    #k.close() #closing day list
    
    #input the google calender via text file 
    #with open('GoogleCalenderTest.txt','r') as h:
    #for line in h:
    #    for word in line.split():
    #                googleCalender[].append(word)
    #h.close() 