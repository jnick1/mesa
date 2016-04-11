#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="Jacob"
__date__ ="$Apr 10, 2016 3:30:29 AM$"

import json
import math
from datetime import datetime, date, time, timedelta
import functions

class Matrix:
    #instantiates a new Matrix object
    #   This method is, in essence, able to emulate the functionality of multiple
    #   constructors. What the method does is determine which constructor code
    #   to run, based off of inittype, and then it passes args to that constructor
    #   function.
    #
    #required args: varies
    #   inittype:construct_from_calendar
    #       startdate, enddate, starttime, endtime, granularity
    #   inittype:construct_from_addition
    #       self.dates, self.times, self.matrix, other.matrix
    def __init__(self, inittype, args):
        if(inittype == "construct_from_calendar"):
            self.construct_from_calendar(args)
        elif(inittype == "construct_from_addition"):
            self.construct_from_addition(args)
    
    #constructs a new Matrix from a calendar
    #   This method uses calendar data to construct a new Matrix object, insofar as that
    #   it needs to be passed data that would come from a calendar. This method does not
    #   parse out the various needed arguments from a Calendar object, as that will be
    #   taken care of in a different method in the Calendar class.
    #
    #   Note: this method does not fill in the matrix slots with 1's when a user is busy,
    #       it only constructs a matrix of the proper size based on the arguments passed.
    #       Additionally, it also generates the labels used in self.dates and self.times.
    #
    #required args: startdate, enddate, starttime, endtime, granularity
    def construct_from_calendar(self, args):
        if(not (isinstance(args["startdate"], datetime) and isinstance(args["enddate"], datetime) and isinstance(args["starttime"], time) and isinstance(args["endtime"], time) and isinstance(args["granularity"], int))):
            raise TypeError("Erroneous argument type supplied")
        startdate = args["startdate"]
        enddate = args["enddate"]
        starttime = datetime.combine(startdate.date(), args["starttime"])
        endtime = datetime.combine(startdate.date(), args["endtime"])
        granularity = args["granularity"]
        rows = math.ceil(((endtime-starttime).seconds)/(granularity*60))
        cols = (enddate-startdate).days + (1 if (enddate-startdate).seconds%86400!=0 else 0)
        self.matrix = [["0" for x in range(cols)] for x in range(rows)]
        self.dates = [0 for x in range(cols)]
        self.times = [0 for x in range(rows)]
        for j in range(cols):
            self.dates[j] = (startdate+timedelta(days=1*j)).date()
        for i in range(rows):
            self.times[i] = (starttime+timedelta(minutes=granularity*i)).time()
    
    #constructs a new Matrix object from the addition of two other Matrix objects
    #   This method essentially defines matrix addition for the Matrix object.
    #   According to our aggreed upon definition of matrix addition, this method
    #   returns a matrix where each element is a concatenation of the elements
    #   of the addends in the same position. For example: 
    #   s[i][j] = str(a1[i][j]) + str(a2[i][j])
    #   In addition to this, it is important to note that self.times and self.dates
    #   is set to the values of self.times and self.dates, respectively, of the
    #   first addend.
    #
    #required args: self.dates, self.times, self.matrix, other.matrix
    def construct_from_addition(self, args):
        self.dates = args["self.dates"]
        self.times = args["self.times"]
        self.matrix = [["0" for x in range(len(self.dates))] for x in range(len(self.times))]
        for i in range(len(self.times)):
            for j in range(len(self.dates)):
                self.matrix[i][j] = str(args["self.matrix"][i][j]) + str(args["other.matrix"][i][j])
    
    def __str__(self):
        output = ""
        for row in range(len(self.matrix)):
            output+="[ "
            for col in range(len(self.matrix[0])):
                output+=str(self.matrix[row][col])+" "
            output+="]"
            if(row!=len(self.matrix)-1):
                output+="\n"
        return output
    
    def print_labeled(self):
        datelabelpadding_before = ((" " * int(math.floor((len(self.matrix[0][0])-len(str(self.dates[0])))/2))) if len(str(self.dates[0])) < len(self.matrix[0][0]) else "")
        datelabelpadding_after = ((" " * int(math.ceil((len(self.matrix[0][0])-len(str(self.dates[0])))/2))) if len(str(self.dates[0])) < len(self.matrix[0][0]) else "")
        valuepadding_before = ((" " * int(math.floor((len(str(self.dates[0]))-len(self.matrix[0][0]))/2))) if len(self.matrix[0][0]) < len(str(self.dates[0])) else "")
        valuepadding_after = ((" " * int(math.ceil((len(str(self.dates[0]))-len(self.matrix[0][0]))/2))) if len(self.matrix[0][0]) < len(str(self.dates[0])) else "")
        output = "           " #timelabelpadding: length of "HH:MM:SS [ " in spaces
        for i in range(len(self.dates)):
            output+=datelabelpadding_before+str(self.dates[i])+datelabelpadding_after+" "
        output+="\n"
        for row in range(len(self.matrix)):
            output+=str(self.times[row])+" [ "
            for col in range(len(self.matrix[0])):
                output+=valuepadding_before + str(self.matrix[row][col]) + valuepadding_after + " "
            output+="]"
            if(row!=len(self.matrix)-1):
                output+="\n"
        return output
    
    def __len__(self):
        rows = str(len(self.matrix))
        cols = str(len(self.matrix[0]))
        return float(rows+"."+cols)
    
    def __add__(self, other):
        if(isinstance(other, Matrix)):
            if(len(self.matrix)==len(other.matrix)):
                args = {
                "self.matrix":self.matrix,
                "self.dates":self.dates,
                "self.times":self.times,
                "other.matrix":other.matrix,
                }
                return Matrix("construct_from_addition", args)
            else:
                raise IndexError("Matrix addition is not defined for matrices of unequal size. Please use matrices of equal dimensions")
        else:
            raise TypeError("Erroneous argument type supplied. Please use a Matrix object")
    
    def get_value_from_index(self,row,col):
        return self.matrix[row][col]
    
    def get_value_from_datetime(self, when):
        if(isinstance(when, datetime)):
            row = functions.index(self.times, when.time())
            col = functions.index(self.dates, when.date())
            return self.matrix[row][col]
        else:
            raise TypeError("Erroneous argument type supplied. Please use a datetime object")
        
    def get_row_index_from_date(self, when):
        if(isinstance(when, date)):
            return functions.index(self.dates, when)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a date object")
        
    def get_col_index_from_time(self, when):
        if(isinstance(when, time)):
            return functions.index(self.times, when)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a time object")
        
class CalendarMatrix(Matrix):
    def __init__(self, args):
        if(isinstance(args["calendar"], Calendar)):
            Matrix.__init__(self, "construct_from_calendar", args)
            calendar = args["calendar"]
            granularity = args["granularity"]
            for event in calendar.events:
                for i in range(math.ceil(((event.end-event.start).seconds)/(granularity*60))):
                    date = (event.start-timedelta(minutes=event.start.minute%15,seconds=event.start.second)+timedelta(minutes=granularity*i)).date()
                    time = (event.start-timedelta(minutes=event.start.minute%15,seconds=event.start.second)+timedelta(minutes=granularity*i)).time()
                    dateindex = functions.index(self.dates, date)
                    timeindex = functions.index(self.times, time)
                    if(dateindex!=-1 and timeindex!=-1):
                        self.matrix[timeindex][dateindex] = 1
        else:
            raise TypeError("Incorrect class supplied at argument: calendar. Please use a Calendar object")
    
    def __str__(self):
        return Matrix.__str__(self)

class Calendar:
    def __init__(self, blCalendar, owner):
        calendar = json.loads(blCalendar)
        self.email = owner
        self.events = []
        for event in calendar:
            self.events.append(_Event(event))
            
    def __str__(self):
        output = "["
        for event in self.events:
            output+="{\"calendar_email\":\""+self.email+"\","+str(event)+"},"
        output = output[:-1]+"]";
        return output
    
class _Event:

    def __init__(self, blEvent):
        self.start = datetime.strptime(blEvent["start_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.end = datetime.strptime(blEvent["end_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.location = blEvent["location"]
        self.travelTime = int(blEvent["travel_time"])

    def __str__(self):
        output = "\"start_time\":\""+self.start.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"end_time\":\""+self.end.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"location\":\""+self.location+",\"travel_time\":"+str(self.travelTime)+""
        return output

    def isBusy(self, when):
        if(when > self.start and when < self.end):
            return True
        else:
            return False