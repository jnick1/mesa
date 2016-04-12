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

#Todo: complete full class documentation
#
#CONSTRAINTS: matrices must have at least 1 day, and at least 2 times for all methods
#               to function properly (some exceptions exist, i.e. null matrix)
class Matrix:
    
    #instantiates a new Matrix object
    #   This method is, in essence, able to emulate the functionality of multiple
    #   constructors. What the method does is determine which constructor code
    #   to run, based off of inittype, and then it passes args to that constructor
    #   function.
    #
    #required args: varies
    #   inittype: construct_from_addition
    #       self.matrix, other.matrix, dates, times
    #   inittype: construct_from_additive_intersection:
    #       self other
    #   inittype: construct_from_bounds
    #       startdate, enddate, starttime, endtime, granularity
    #   inittype: construct_from_direct_assignment:
    #       self.matrix, self.dates, self.times
    #   inittype: construct_from_union:
    #       self, other
    #   inittype: null
    #       width, height
    def __init__(self, inittype, args):
        constructors = {
            "construct_from_addition":                  self.construct_from_addition,
            "construct_from_additive_intersection":     self.construct_from_additive_intersection,
            "construct_from_bounds":                    self.construct_from_bounds,
            "construct_from_direct_assignment":         self.construct_from_direct_assignment,
            "construct_from_union":                     self.construct_from_union,
            "null":                                     self.construct_null
        }
        constructor = constructors.get(inittype,-1)
        
        if(constructor != -1):
            constructor(args)
        else:
            raise ValueError("Invalid inittype passed. Please refer to documentation to see valid inittypes")
    
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
    
    #constructs a new Matrix object from the intersection of two other Matrix objects
    #   This method, while similar to construct_from_addition, is in fact, more
    #   general than construct_from_addition. This function is able to sum matrices
    #   of unequal dimensions using an alternative scheme for addition. As this
    #   method can sum matrices of unequal size, it will pad the space represented
    #   by A ∩ ~(A ∩ B) with zero-strings of appropriate length. This new
    #   scheme can be defined via the following:
    #
    #   A + B := A + A ∩ B
    #
    #   Note: this scheme assumes the definition of addition for Matrix objects
    #
    #required args: self, other
    #
    #See also: construct_from_union, construct_from_addition
    def construct_from_additive_intersection(self, args):
        A = args["self"]
        B = args["other"]
        print(A.length())
        print(B.length())
        if(math.isclose(A.length(),B.length())):
            for i in range(len(A.matrix)):
                for j in range(len(A.matrix[0])):
                    when = A.get_datetime_from_rowcol(i,j)
                    match = B.get_value_from_datetime(when)
                    if(match != -1):
                        A.matrix[i][j]+=str(match)
                    else:
                        A.matrix[i][j]+="0"
            self.matrix = A.matrix
            self.dates = A.dates
            self.times = A.times
        else:
            newargs = {
                "self.matrix":A.matrix,
                "other.matrix":B.matrix,
                "dates":(A.dates if len(A.dates)!=0 else B.dates),
                "times":(A.times if len(A.times)!=0 else B.times)
            }
            self.construct_from_addition(newargs)
        
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
    def construct_from_bounds(self, args):
        if(not (isinstance(args["startdate"], date) and isinstance(args["enddate"], date) and isinstance(args["starttime"], time) and isinstance(args["endtime"], time) and isinstance(args["granularity"], int))):
            raise TypeError("Erroneous argument type supplied")
        startdate = args["startdate"]
        enddate = args["enddate"]
        starttime = (datetime.combine(startdate, args["starttime"])+(timedelta(minutes=args["granularity"]-args["starttime"].minute%args["granularity"]) if args["starttime"].minute%args["granularity"]!=0 else timedelta(minutes=0))).time()
        endtime = args["endtime"]
        granularity = args["granularity"]
        rows = math.ceil(((datetime.combine(startdate,endtime)-datetime.combine(startdate,starttime)).seconds)/(granularity*60))
        cols = (datetime.combine(enddate,starttime)-datetime.combine(startdate,starttime)).days + (1 if (datetime.combine(startdate,endtime)-datetime.combine(startdate,starttime)).seconds!=0 else 0)
        self.matrix = [["0" for x in range(cols)] for x in range(rows)]
        self.dates = ["" for x in range(cols)]
        self.times = ["" for x in range(rows)]
        for j in range(cols):
            self.dates[j] = (datetime.combine(startdate,starttime)+timedelta(days=1*j)).date()
        for i in range(rows):
            self.times[i] = (datetime.combine(startdate,starttime)+timedelta(minutes=granularity*i)).time()
    
    #constructs a new Matrix object by directly assigning instance variables
    #   Intended for internal class use only, this method directly assigns
    #   all instance variables their values based on the provided arguments.
    #
    #required args: self.matrix, self.times, self.dates
    def construct_from_direct_assignment(self, args):
        self.times = args["self.times"]
        self.dates = args["self.dates"]
        self.matrix = args["self.matrix"]
    
    #constructs a new Matrix object from the union of two other Matrix objects
    #   This method, similar to construct_from_additive_intersection, defines an
    #   alternative scheme for addtion. Addtionally, this method is able to sum
    #   matrices of unequal dimensions. Furthermore, this method will automatically
    #   fill in the space represented by ~(A ∪ B) with zero-strings of appropriate
    #   length. As such, it will expand the dimensions of the resulting Matrix
    #   to be dimensions that encompass all elements in both A and B. This new
    #   scheme can be defined as:
    #
    #   A + B := A ∪ B
    #
    #   Note: this scheme assumes the definition of addition for Matrix objects
    #
    #required args: self, other
    #
    #See also: construct_from_additive_intersection, construct_from_addition
    def construct_from_union(self, args):
        A = args["self"]
        B = args["other"]
        if(math.isclose(A.length(),B.length())):
            dates = A.dates + B.dates
            times = A.times + B.times
            startdate = functions.mindate(dates)
            enddate = functions.maxdate(dates)
            starttime = functions.mintime(times)
            endtime = functions.maxtime(times)
            granularity = (A.times[1]-A.times[0]).seconds/60
            rows = math.ceil(((endtime-starttime).seconds)/(granularity*60))
            cols = (enddate-startdate).days + (1 if (endtime-starttime).seconds!=0 else 0)
            self.matrix = [["" for x in range(cols)] for x in range(rows)]
            self.dates = ["" for x in range(cols)]
            self.times = ["" for x in range(rows)]
            for j in range(cols):
                self.dates[j] = (startdate+timedelta(days=1*j))
            for i in range(rows):
                self.times[i] = (starttime+timedelta(minutes=granularity*i))
                for j in range(cols):
                    when = datetime.combine(self.dates[j], self.times[i])
                    Aval = A.get_value_from_datetime(when)
                    Bval = B.get_value_from_datetime(when)
                    if(Aval != -1):
                        self.matrix[i][j] += Aval
                    else:
                        self.matrix[i][j] += "0" * len(A.matrix[0][0])
                    if(Bval != -1):
                        self.matrix[i][j] += Bval
                    else:
                        self.matrix[i][j] += "0" * len(B.matrix[0][0])
        else:
            newargs = {
                "self.matrix":A.matrix,
                "other.matrix":B.matrix,
                "dates":(A.dates if len(A.dates)!=0 else B.dates),
                "times":(A.times if len(A.times)!=0 else B.times)
            }
            self.construct_from_addition(newargs)
    
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
    
    #performs addition of two Matrix objects (A + B)
    #   This method first verifies that both matrices are of equal dimensions,
    #   as otherwise matrix addtion would be undefined. See documentation for
    #   construct_from_addition for additional details
    def __add__(self, other):
        if(isinstance(other, Matrix)):
            args = {
                "self":self,
                "other":other,
            }
            return Matrix("construct_from_additive_intersection", args)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a Matrix object")
    
    #performs augmented assignment with addition
    #
    #See also: Matrix.__add__
    def __iadd__(self, other):
        return self.__add__(other)
    
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
    
    #returns the index of the column (date) at the specified date
    #
    #retuires: when must be a date object
    def get_col_index_from_time(self, when):
        if(isinstance(when, date)):
            return functions.index(self.dates, when)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a time object")
    
    #returns a date object for the given column index
    def get_date_from_col_index(self, col):
        return self.dates[col]
    
    #returns a datetime object at the intersection found at the specifed row and column
    def get_datetime_from_rowcol(self,row,col):
        return datetime.combine(self.dates[col], self.times[row])
    
    #returns the index of the row (time) at the specified time
    #
    #retuires: when must be a time object
    def get_row_index_from_date(self, when):
        if(isinstance(when, time)):
            return functions.index(self.times, when)
        else:
            raise TypeError("Erroneous argument type supplied. Please use a date object")
    
    #returns a time object for the given row index
    def get_time_from_row_index(self, row):
        return self.times[row]
    
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
                return -1
        else:
            raise TypeError("Erroneous argument type supplied. Please use a datetime object")
    
    #returns the value at a cell in the matrix given a row and column index
    def get_value_from_index(self,row,col):
        return self.matrix[row][col]
    
    #maps the shape of this Matrix object to a unique float
    #   This is an injective function from the set of shapes of an n x m matrix
    #   to the set of real numbers.
    def length(self):
        rows = str(len(self.matrix))
        cols = str(len(self.matrix[0]))
        return float(rows+"."+cols)
    
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
    
    #Sets all values of a cell at the given row and column to value
    #
    #Sample output:
    #   original[row][col]          = "10110100"
    #   modified[row][col][value=1] = "11111111"
    #
    #requires: value is either 0 or 1, e.g. not "000"
    def set_cell(self,row,col,value):
        self.matrix[row][col] = str(value) * len(self.matrix[row][col])
    
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
    #       calendar, startdate, enddate, starttime, endtime, granularity
    #   inittype: construct_from_blcalendar
    #       rawcalendar, owner, granularity
    def __init__(self, inittype, args):
        constructors = {
            "construct_from_blcalendar":    self.construct_from_blcalendar,
            "construct_from_calendar":      self.construct_from_calendar
        }
        constructor = constructors.get(inittype,-1)
        
        if(constructor != -1):
            constructor(args)
        else:
            raise ValueError("Invalid inittype passed. Please refer to documentation to see valid inittypes")
    
    #constructs a new CalendarMatrix object a calendar and various dimension parameters
    #   
    #
    #required args: calendar, startdate, enddate, starttime, endtime, granularity
    def construct_from_calendar(self, args):
        if(not isinstance(args["calendar"], Calendar)):
            raise TypeError("Incorrect class supplied at argument: calendar. Please use a Calendar object")
        Matrix.__init__(self, "construct_from_bounds", args)
        calendar = args["calendar"]
        granularity = args["granularity"]
        for event in calendar.events:
            for i in range(math.ceil(((event.end-event.start).seconds)/(granularity*60))):
                date = (event.start-timedelta(minutes=event.start.minute%15,seconds=event.start.second)+timedelta(minutes=granularity*i)).date()
                time = (event.start-timedelta(minutes=event.start.minute%15,seconds=event.start.second)+timedelta(minutes=granularity*i)).time()
                dateindex = functions.index(self.dates, date)
                timeindex = functions.index(self.times, time)
                if(dateindex!=-1 and timeindex!=-1):
                    self.matrix[timeindex][dateindex] = "1"
        self.attendees = args["calendar"].email
    
    #constructs a new CalendarMatrix object, automaticlly assuming dimensions based on calendar data
    #   
    #
    #required args: rawcalendar, owner, granularity
    def construct_from_blcalendar(self, args):
        owner = args["owner"]
        calendar = Calendar(args["rawcalendar"], owner)
        start = calendar.earliest_start()
        end = calendar.latest_end()
        starttime = start.time()
        endtime = end.time()
        newargs = {
            "calendar":calendar,
            "startdate":start,
            "enddate":end,
            "starttime":starttime,
            "endtime":endtime,
            "granularity":args["granularity"]
        }
        self.construct_from_calendar(newargs)
    
    #Sets the value of a cell for an attendee at the given row and column to value
    #
    #Sample output:
    #   original[row][col]                              = "00001000"
    #   modified[row][col]["second@email.com"][value=1] = "01001000"
    #
    #requires: value is either 0 or 1, e.g. not "000"
    def set_specific_cell(self,row,col,attendee,value):
        newval = list(self.matrix[row][col])
        i = functions.index(self.attendees, attendee)
        if(i != -1):
            newval[functions.index(self.attendees, attendee)] = value
            self.matrix[row][col] = "".join(newval)
        else:
            raise IndexError("Unable to find attendee in attendee list")

class Calendar:
    def __init__(self, blCalendar, owner):
        calendar = json.loads(blCalendar)
        self.email = owner
        self.events = []
        for event in calendar:
            self.events.append(_Event(event))
    
    #returns the number of events in this Calendar object
    def __len__(self):
        return len(self.events)
    
    #returns a json-formatted string representing this Calendar object
    def __str__(self):
        output = "["
        for event in self.events:
            output+="{\"calendar_email\":\""+self.email+"\","+str(event)+"},"
        output = output[:-1]+"]";
        return output
    
    #returns a datetime object representing the earliest start time of any event in this Calendar object
    def earliest_start(self):
        mindate = datetime.max
        for event in self.events:
            if(event.start<mindate):
                mindate = event.start
        return mindate
    
    #returns True if any event in the Calendar occurs during the specified time, otherwise False
    #
    #requires: when must be a datetime object
    def is_busy(self, when):
        for event in self.events:
            if(event.is_busy(when)):
                return True
        return False
    
    #returns a datetime object representing the latest end time of any event in this Calendar object
    def latest_end(self):
        maxdate = datetime.min
        for event in self.events:
            if(event.end > maxdate):
                maxdate = event.end
        return maxdate
        
class _Event:

    def __init__(self, blEvent):
        self.start = datetime.strptime(blEvent["start_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.end = datetime.strptime(blEvent["end_time"], "%Y-%m-%dT%H:%M:%SZ")
        self.location = blEvent["location"]
        self.travelTime = int(blEvent["travel_time"])

    def __str__(self):
        output = "\"start_time\":\""+self.start.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"end_time\":\""+self.end.strftime("%Y-%m-%dT%H:%M:%SZ")+"\",\"location\":\""+self.location+",\"travel_time\":"+str(self.travelTime)+""
        return output

    def is_busy(self, when):
        if(when > self.start and when < self.end):
            return True
        else:
            return False