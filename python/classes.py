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
    #   inittype: construct_from_calendar
    #       startdate, enddate, starttime, endtime, granularity
    #   inittype: construct_from_addition
    #       self.matrix, other.matrix, dates, times, 
    #   inittype: null
    #       width, height
    def __init__(self, inittype, args):
        if(inittype == "construct_from_calendar"):
            self.construct_from_calendar(args)
        elif(inittype == "construct_from_addition"):
            self.construct_from_addition(args)
        elif(inittype == "null"):
            self.construct_null(args)
    
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
        starttime = datetime.combine(startdate.date(), args["starttime"])+(timedelta(minutes=args["granularity"]-args["starttime"].minute%args["granularity"]) if args["starttime"].minute%args["granularity"]!=0 else timedelta(minutes=0))
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
    #   is set to the values of times and dates, respectively, which will vary.
    #   
    #   Note: dates and times vary according to the following scheme:
    #       if self.dates of the first addend isn't empty, then dates is the first
    #       addend's self.dates, otherwise it is the second addend's self.dates
    #       This scheme is also followed for times
    #
    #required args: self.matrix, other.matrix, dates, times
    def construct_from_addition(self, args):
        self.dates = args["dates"]
        self.times = args["times"]
        self.matrix = [["0" for x in range(len(self.dates))] for x in range(len(self.times))]
        for i in range(len(self.times)):
            for j in range(len(self.dates)):
                self.matrix[i][j] = str(args["self.matrix"][i][j]) + str(args["other.matrix"][i][j])
    
    #constructs a new Matrix object with a "null" state
    #   This method constructs a new blank Matrix object. In order to be compatible
    #   with the definition of matrix addition, this method initializes self.matrix
    #   to be filled with 0-length strings. Furthermore, since dimensions are
    #   specified, this matrices may be added to other matrices of the same size
    #   with the result being the other matrix.
    #
    #properties:
    #   null+m = m
    #   m+null = m
    #   null+null = null
    #
    #required args: width, height
    def construct_null(self, args):
        self.dates = []
        self.times = []
        self.matrix = [["" for x in range(args["height"])] for x in range(args["width"])]
    
    #outputs the contents of this Matrix object in a standard form
    #
    #Sample output:
    #   [ 0 0 0 ]
    #   [ 1 0 0 ]
    #   [ 1 0 1 ]
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
    
    #outputs the contents of this Matrix object in a labeled form
    #
    #Sample output:
    #              2016-04-04 2016-04-05
    #   12:00:00 [     0          1     ]
    #   12:30:00 [     1          0     ]
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
    
    #maps the shape of this Matrix object to a unique float
    #   This is an injective function from the set of shapes of an n x m matrix
    #   to the set of real numbers.
    def __len__(self):
        rows = str(len(self.matrix))
        cols = str(len(self.matrix[0]))
        return float(rows+"."+cols)
    
    #performs addition of two Matrix objects (A + B)
    #   This method first verifies that both matrices are of equal dimensions,
    #   as otherwise matrix addtion would be undefined. See documentation for
    #   construct_from_addition for additional details
    def __add__(self, other):
        if(isinstance(other, Matrix)):
            if(len(self.matrix)==len(other.matrix)):
                args = {
                "self.matrix":self.matrix,
                "dates":(self.dates if len(self.dates)!=0 else other.dates),
                "times":(self.times if len(self.times)!=0 else other.times),
                "other.matrix":other.matrix,
                }
                return Matrix("construct_from_addition", args)
            else:
                raise IndexError("Matrix addition is not defined for matrices of unequal size. Please use matrices of equal dimensions")
        else:
            raise TypeError("Erroneous argument type supplied. Please use a Matrix object")
    
    #performs augmented assignment with addition
    #
    #See also: Matrix.__add__
    def __iadd__(self, other):
        return self.__add__(other)
    
    #returns the value at a cell in the matrix given a row and column index
    def get_value_from_index(self,row,col):
        return self.matrix[row][col]
    
    #returns the value at a cell in the matrix given the date and time 
    #
    #retuires: when must be a datetime object
    def get_value_from_datetime(self, when):
        if(isinstance(when, datetime)):
            row = functions.index(self.times, when.time())
            col = functions.index(self.dates, when.date())
            if(row!=-1 and col!=-1):
                return self.matrix[row][col]
            else:
                raise IndexError("Date and time not found within the bounds of this matrix")
        else:
            raise TypeError("Erroneous argument type supplied. Please use a datetime object")
    
    #returns the index of the row (time) at the specified time
    #
    #retuires: when must be a time object
    def get_row_index_from_date(self, when):
        if(isinstance(when, time)):
            return functions.index(self.times, when)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a date object")
        
    #returns the index of the column (date) at the specified date
    #
    #retuires: when must be a date object
    def get_col_index_from_time(self, when):
        if(isinstance(when, date)):
            return functions.index(self.dates, when)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a time object")
        
class CalendarMatrix(Matrix):
    
    #instantiates a new CalendarMatrix object
    #   This method, similar to Matrix.__init__, allows for multiple constructors
    #   to be called based off of what is passed to inittype. A CalendarMatrix is
    #   able to be constructed from either a Calendar object, or raw calendar data.
    #   
    #   Note: it cannot be pure raw calendar data, but rather the results of
    #       json.loads on raw blCalendar data, at the index of an attendee email
    #       address.
    #
    #required args: varies
    #   inittype: construct_from_calendar
    #       calendar, granularity
    #   inittype: construct_from_blcalendar
    #       rawcalendar, owner, granularity
    def __init__(self, inittype, args):
        if(inittype=="construct_from_calendar"):
            construct_from_calendar(args)
        elif(inittype=="construct_from_blcalendar"):
            newargs = {
                "calendar":Calendar(rawcalendar, owner),
                "granularity":args["granularity"]
            }
            construct_from_calendar(newargs)
    
    def construct_from_calendar(self, args):
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
            self.attendees = args["calendar"].email
        else:
            raise TypeError("Incorrect class supplied at argument: calendar. Please use a Calendar object")
    
    #outputs the contents of this CalendarMatrix object in a standard form
    #
    #See also: Matrix__str__
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