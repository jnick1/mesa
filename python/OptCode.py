#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import numpty as np

if __name__ == "__main__":
    print "Hello World"

#IMPORTANT!!!
#RE-WRITE IT SO THAT THE PRIORITY IS MANIPULATED ONLY
BY 


#using numpty for matrix

#necessary objects needed before starting the program
 Priority[] = [1, 2, 3, 4, 5, 6, 7] #each one is a different function
 DAYS[] #specific days wanted
 reoccurance = {} #list of the number of times it happens, and holds multiple meetings
 attendies[] = [] #list of people on the project, those who accept
  
 #matrices necessary
 masterCalender = [ [ 0 for i in range(7) ] for j in range(24) ] #calender for the final date selection, full week 7 days/24hrs
 peopleCalender = [ [ 0 for i in range(7) ] for j in range(24) ] #calender to keep track of the number of people
 googleCalender[]
 googleCal = [ [ 0 for i in range(7) ] for j in range(24) ] #calender to import 
 
 #first, enter the necessary data
    f = open('WillsBasicInfo', 'r') #the order of the text file should be as the following: 
    endTime = f.readline() #what is the time set to stop the search
    startTime = f.readline() #where to start the search
    searchWidth = f.readline() #how many days are available
    gran = f.readline()  #How many minutes do want to increment the search by hour, can also be wither 15mins or 1 mins depending on user input
    bannedtimes = f.readline() #banned granularity increments based on user input, ie not over 933 or something
    preferedTime = f.readline() #the time that the person wants to have the specifically
    durrationTime = f.readline() #how long the meeting is
    location = f.readline() #where the place is at/want to meet
    weekly = f.readline() #how often per week people want to meet
    f.close()#closing the file
    grularity = gran/60 #search it by what people wanted, else it's automatically 1 hour
    
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
 
 if (   ): #person accepts
 {
    #input the google calender 
    with open('GoogleCalenderTest.txt','r') as h:
    for line in h:
        for word in line.split():
                    googleCalender[].append(word)
    h.close() 
    
    #moving their Goolge calender to a normCalender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity): #hard to tell what to increment j by because it varies with each person
        {
            if GoogleCalender[i][j] = '1':  #if there is an event in the google calender
                peopleCalender[i][j] += '1' 
            else:
                peopleCalender[1][j] += '0'          
        }
    }
     attendies.insert(peopleCalender)
    #saving the calender into a list to hold on too (hopefully)
    
 }#END ATTENDIES IF STATEMENT
    

    #adjust this based on time and such
for (i=7; i>0; i--):
        if (i = 7):#number of people attending
            {peopleCounting(searchwidth, granularity, bannedtimes, peopleCalender)}
    else if (i = 6): #granularity
         #
    else if (i = 5): #location  
         #
    else if (i = 4): # of times repeated
         #
    else if (i = 3): #Duration of meeting
         #
    else if (i = 2): #Day of week
        {DayLocation ( DAYS, granlarity, bannedtimes, masterCalender, NormCalender, Priority)
        }
    else if (i = 1): #Time of day
    {    TimeLocation (DAYS, NormCalender, MasterCalender, Priority, preferedTime)
    }
    
    List [] #used to hold the numbers in the matrix
    for(i = 0; i<7; i++):
        {
            for(j=0; j<(24/granularity) - bannedtimes; j+granularity): 
            {
                info = masterCalender[i][j]
                List.insert(info)
            }
        }
    #sorting the list so that the biggest number is on top
    List.sort(reverse = True)
    
    returnCalender[][]
    #pick the top spots and return them to a matrix
    k = 0
    l = 0
    do{
        {for(i = 0; i<searchWidth; i++):
            {for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
                #checks for the top spots
                {if (masterCalender[i][j] == List1[l]):
                    returnCalender[i][j] = masterCalender[i][j]
                    k++
                } 
            }
        }
        l = l+1
    } while(k<(weekly*2))
    
    
    #writing it to a text file
    for row in returnCalender:
        for column, data in enumerate(row):
            out += formats[column].format(data)
        out += "\n"

    with open("Times.txt","wt") as file:
        file.write(out)
     
    
    
    
 }#end of attendee acceptance

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
Start = startTime
timeLength = durrationTime
spot = false
count = 0

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
    
     
}while(j!<(24/granularity) - bannedtimes)
    


#For {for(i = 0; i<searchWidth; i++)
#   {for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
#       for(location
#          for(recursion
#               for(day
#                   for(time
#                       for(people
#meeting duration time practice


