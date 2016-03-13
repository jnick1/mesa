#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.
import numpty as np

if __name__ == "__main__":
    print "Hello World"

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
 
 
 if (   ): #person accepts
 {
    #first, enter the necessary data
    f = open('WillsBasicInfo', 'r') #the order of the text file should be as the following: 
    endTime = f.readline() #what is the time set to stop the search
    startTime = f.readline() #where to start the search
    searchWidth = f.readline() #how many days are available
    gran = f.readline()  #How many minutes do want to increment the search by hour, can also be wither 15mins or 1 mins depending on user input
    grularity = gran/60 #search it by the hour
    bannedtimes = f.readline() #banned granularity increments based on user input, ie not over 933 or something
    preferedTime = f.readline() #the time that the person wants to have the specifically
    location = f.readline() #where the place is at/want to meet
    f.close()#closing the file
    
    #having the priority set list seperate because idk if there will be exact results if its at the end of the other file
    g = open('PriorityTextFile', 'r') 
    for (i=0; i<7; i++):
        test = Priority[i]
        Priority[i] = test * g.readline() #each will get either LOW(1), MED(10), or HIGH(100) to determine the importance value
    g.close() #closing priority file
    
    #same as priority list
    k = open('specificDaysTextFile', 'r')
        DAYS = k.read().split(',') #insert number for specific day, 0=SUN, 1=MON, etc
    
    #input the google calender Trial 1
    with open('GoogleCalenderTest.txt','r') as h:
            for line in h:
                for word in line.split(): #delimiter is a space, word is now a list
                    print(word)  
    
    
    #input the google calender trial 2
    with open('GoogleCalenderTest.txt','r') as h:
    for line in h:
        for word in line.split():
                    googleCalender[].append(word)
    
         
    #temp specific calender for that person
    #normCalender = [ [ 0 for i in range(searchWidth) ] for j in range((24/granularity) - bannedtimes) ] 
    normCalender = [ [ 0 for i in range(7) ] for j in range(24) ]
    
    #moving their Goolge calender to a normCalender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity): #hard to tell what to increment j by because it varies with each person
        {
            if GoogleCalender[i][j] = '1':  #if there is an event in the google calender
                NormCalender[i][j] = 1 
            else:
                NormCalender[1][j] = 0          
        }
    }
    
    #saving the normal calender into a list to hold on too
    attendies.insert(NormCalender)
    #This is a guess, I really don't think that this would work
    #will do further research on it

    testCal = [ [ 0 for i in range(7) ] for j in range(24) ]
    #editing the Master Calender depending on the priority system
    for (i=7; i>0; i--):
        if (i = 7):#number of people attending
        {   attend = 0 # number of people who accepts
             for (i =0; i <searchwidth; i++):
                {for(j =0; j<24; j++):
                    {
                        Attendees = peopleCalender[i][j] + NormCalender[i][j] #adding the matrixes together
                        peopleCalender[i][j] = Attendees #storing it back for the next list
                    
                        for (i =0; i<length.info; i++): #don't know if its necessary or not, but will leave it in at the moment
                            {if (0 in Attendees):
                                attend +=1
                            }
                        testCal[i][j] = attend #numeric track of the people coming                         
                    }
                }        
        }
    else if (i = 6): #granularity
         #
    else if (i = 5): #location  
         #
    else if (i = 4): # of times repeated
         #
    else if (i = 3): #Duration of meeting
         #
    else if (i = 2): #Day of week
         {for (i=0; i<DAYS.length(); i++)
            {for (j = startTime; j<(24/granularity) - bannedtimes; i++): #do this for each hour 
               {day = DAYS[i] #reads number for the specific day to correlate with the matrix
                if(NormCalender[day][j] == 0): #search in day range
                {
                    points = testCal[day][j]
                    testCal[day][j] = points + Priority[2]
                }
               } 
            }
        }
    else if (i = 1): #Time of day
        {for (i = 0; i< searchwidth; i++): #do this for each day 
           {if(NormCalender[i][preferedTime] == 0): #original perfered Time of day
                {
                    points = testCal[i][preferedTime]
                    testCal[i][preferedTime] = points + Priority[1]
                }
            else:
                spot = False
                count = 1
                do:
                    { preferedTime = preferedTime + (count* (-1^count))#branching out hour by hour
                    if(array[i][preferedTime] == 0): #modified perfered Time of day
                        {
                            points = testCal[i][preferedTime]
                            testCal[i][preferedTime] = points + Priority[1]
                            spot = True #get out of loop early
                        }
            
                }while ( spot == False && preferedTime >=  || spot == False && preferedTime <= end ) 
                    #this way, if the perfered time is not in the middle, it will still performed the action
            }
        }
    
    
    List [] #used to hold the numbers in the matrix
    for(i = 0; i<7; i++):
        {
            for(j=0; j<24; j++): #should it be incremented by granularity or by 1? I'm not sure
            {
                info = masterCalender[i][j]
                List.insert(info)
            }
        }
    
    #sorting the list so that the biggest number is on top
    List.sort(reverse = True)
    
 }#end of attendee acceptance
 

def peopleCounting(A[][], empty[][]):
{for(i = 0; i<7; i++):
    {
        for(j=0; j<24; j++): #should it be incremented by granularity or by 1? I'm not sure
            { info = A[i][j]
              for (i =0; i<length.info; i++): #don't know if its necessary or not, but will leave it in at the moment
                    if (0 in info):
                        attend +=1
              empty[i][j] = attend
            }  
    }
    return
}

    
#picking the top numbered spots depending on the recursion
def multiSpots(Array List1[], Array matrix[][], weekly):
    {temp = 0;
    do:
        {for(i = 0; i<searchWidth; i++):
            {for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
                #checks, in order, if the number is in the top 5 spots, adds to list if so
                {if (matrix[i][j] == List1[0]):
                    matrix[i][j] = -1
                    reoccurance.insert("Top Priotity is " + i+ " at " + j + " time")
                    temp +=1
                else if (matrix[i][j] == List1[1]):
                    matrix[i][j] = -1
                    reoccurance.insert("Priotity is " + i+ " at " + j + " time")
                    temp +=1
                else if (matrix[i][j] == List1[2]):
                    matrix[i][j] = -1
                    reoccurance.insert("Priotity is " + i+ " at " + j + " time")
                    temp +=1
                else if (matrix[i][j] == List1[3]):
                    matrix[i][j] = -1
                    reoccurance.insert("Priotity is " + i+ " at " + j + " time")
                    temp +=1
                else if (matrix[i][j] == List1[4]):
                    matrix[i][j] = -1
                    reoccurance.insert("Priotity is " + i+ " at " + j + " time")
                    temp +=1
                } 
            }
        } while (weekly > temp)
        return
    }
    
    #IDEA: create a blank matrix to hold ONLY the picked numbers times to return
    
