#!/usr/bin/env python2
#encoding: UTF-8

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

if __name__ == "__main__":
    print "Hello World"

 end = input('When to end') #what is the time set to stop the search
 start = input('When to start') #where to start the search
  searchWidth = input('How Many Days are available')
 gran = input('How many minutes do want to increment the search by?')  #hour, can also be wither 15mins or 1 mins depending on user input
 grularity = gran/60 #search it by the hour
 bannedtimes = input('What time increments are not allowed') #banned granularity increments based on user input
 location = "place"
 reoccurance = {} #list of the number of times it happens, and holds multiple meetings
 
 #matrices necessary
 masterCalender = [ [ 0 for i in range(7) ] for j in range(24) ] #calender for the final date selection, full week 7 days/24hrs
 normCalender = [ [ 0 for i in range(searchWidth) ] for j in range((24/granularity) - bannedtimes) ] #specific calender for that person
 
  
 attendies[] = [] #list of people on the project, those who accept
 attend = 0 # number of people who accepts
 
 if (   ): #person accepts
 {
    #moving their Goolge calender to a normCalender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity): #hard to tell what to increment j by because it varies with each person
        {
            if GoogleCalender[i][j] = 'event': 
                NormCalender[i][j] = 1
            else:
                NormCalender[1][j] = 0          
        }
    }
    
    #adding the normCal to the Master calender
    for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
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
 P[][];
 
 #Figuring out which has the most attendies
 def AdditionMatrix(A[][], masterCalender[][]):
{  
    For (int i =startdays; i <searchwidth; i++):
    {
        For(j =starttime; j<(24 hours / granularity)-bannedtimes; j++):
        {
            Attendees= A[i][j] + masterCalender[i][j]
            P[i][j] = Attendees
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
    
    
    List.sort(reverse = True)
    
    First = List[0]
    Second = List[1]
    Third = List[2]
    
    def findMostRequested(A[][]): #finding the time based on the most attendees reported
        for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            if (A[i][j] == First)
                A[i][j] = -1
                return 'Top Priority is [' + i + '], [' + j + ']'
        }
    }
    
    def find2ndMostRequested(A[][]): #finding the time based on the most attendees reported
        for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            if (A[i][j] == Second && A[i][j] != -1 )
                A[i][j] = -1
                return 'Second Priority is [' + i + '], [' + j + ']'
        }
    }
    #returning the spot as text for now until I know what to return it better
    def find3rdMostRequested(A[][]): #finding the time based on the most attendees reported
        for(i = 0; i<searchWidth; i++):
    {
        for(j=0; j<(24/granularity) - bannedtimes; j+granularity):
        {
            if (A[i][j] == Third && A[i][j] != -1 )
                A[i][j] = -1
                return 'Second Priority is [' + i + '], [' + j + ']'
        }
    }
    
    
    
    
    
    
    


    
 