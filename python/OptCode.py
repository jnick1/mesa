#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

if __name__ == "__main__":
    print "Hello World"

 #necessary objects needed before starting the program
 
 Priority[ ] = [1, 2, 3, 4, 5, 6, 7] #each one is a different function 
 reoccurance = {} #list of the number of times it happens, and holds multiple meetings
 attendies[] = [] #list of people on the project, those who accept
 attend = 0 # number of people who accepts
 
 #matrices necessary
 masterCalender = [ [ 0 for i in range(7) ] for j in range(24) ] #calender for the final date selection, full week 7 days/24hrs
 

 
 if (   ): #person accepts
 {
    #first, enter the necessary data
    f = open('WillsBasicInfo', 'r') #the order of the text file should be as the following: 
    end = f.readline() #what is the time set to stop the search
    start = f.readline() #where to start the search
    searchWidth = f.readline() #how many days are available
    gran = f.readline()  #How many minutes do want to increment the search by hour, can also be wither 15mins or 1 mins depending on user input
    grularity = gran/60 #search it by the hour
    bannedtimes = f.readline() #banned granularity increments based on user input, ie not over 933 or something
    location = f.readline() #where the place is at/want to meet
    f.close()#closing the file
    
    #having the priority set list seperate because idk if there will be exact results if its at the end of the other file
    g = open('PriorityTextFile', 'r') 
    for (i=0; i<7; i++)
        test = Priority[i]
        Priority[i] = test * g.readline() #each will get either LOW(1), MED(10), or HIGH(100) to determine the importance value
    g.close() #closing priority file
 
    #temp specific calender for that person
    normCalender = [ [ 0 for i in range(searchWidth) ] for j in range((24/granularity) - bannedtimes) ] 
    
    #need to learn to input the google calender, ask that tommorow meeting
    #moving their Goolge calender to a normCalender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity): #hard to tell what to increment j by because it varies with each person
        {
            if GoogleCalender[i][j] = 'event':  #if there is an event in the google calender
                NormCalender[i][j] = 1
            else:
                NormCalender[1][j] = 0          
        }
    }
    
    #saving the normal calender into a list to hold on too
    
    #This is a guess, I really don't think that this would work
    #will do further research on it
    
    
    #adding the normCal to the Master calender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            #
            if NormCalender[i][j] = 1: 
                Blank = masterCalender[i][j]
                Blank = Blank + '1'
                masterCalender[i][j] = Blank
            else:
                Blank = masterCalender[i][j]
                Blank = Blank + '0'
                masterCalender[i][j] = Blank        
        }
    }
    
 }
 
 
 
 #adding the matrixes together
 def AdditionMatrix(A[][], masterCalender[][]):
{  
    For (int i =startdays; i <searchwidth; i++):
    {
        For(j =starttime; j<(24 hours / granularity)-bannedtimes; j++):
        {
            Attendees= A[i][j] + masterCalender[i][j]
            masterCalender[i][j] = Attendees
        }
    }
}

    List []
    for(i = 0; i<7; i++):
    {
        for(j=0; j<24; j++): #should it be incremented by granularity or by 1? I'm not sure
        {
             info = masterCalender[i][j]
             for (i =0; i<length.info; i++): #don't know if its necessary or not, but will leave it in at the moment
                 if (0 in info):
                    attend +=1
             List.insert(attend)
        }
    }
    
    #sorting the list so that the biggest number is on top
    List.sort(reverse = True)
        
    #top three spots (code will change depending on the reoccurance)
    First = List[0]
    Second = List[1]
    Third = List[2]
    
    #finding the time based on the most attendees reported
    def findMostRequested(A[][]): 
        for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            if (A[i][j] == First)
                A[i][j] = -1
                return 'Top Priority is [' + i + '], [' + j + ']'
        }
    }
    
    #finding the time based on the most attendees reported
    def find2ndMostRequested(A[][]): 
        for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            if (A[i][j] == Second && A[i][j] != -1 )
                A[i][j] = -1
                return 'Second Priority is [' + i + '], [' + j + ']'
        }
    }
    #finding the time based on the most attendees reported
    def find3rdMostRequested(A[][]): 
        for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            if (A[i][j] == Third && A[i][j] != -1 )
                A[i][j] = -1
                return 'Second Priority is [' + i + '], [' + j + ']' 
               #returning the spot as text for now until I know what to return it better
        }
    }
    
    
    
    
    
    
    


    
 