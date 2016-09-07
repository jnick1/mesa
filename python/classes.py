import json
from datetime import datetime, date, time, timedelta


class CalendarSet:
    """
    Set of user calendar data, used to determine whether attendees are available
    at a certain time.
    """
    def __init__(self, calendar_list):
        self.calendar_list = calendar_list

    def is_required_attendees_busy(self, when, duration):
        """
        Checks if required attendees are busy
        :param when: Time to check
        :param duration: Duration after the time
        :return: True if a required attendee is busy,
                 False if no required attendees are busy
        """
        for attendee in self.calendar_list:
            if not self.calendar_list[attendee].optional and \
                    self.calendar_list[attendee].is_busy_for_duration(when, duration):
                return True
        return False

    def available_attendees(self, when, duration):
        """
        Returns all available attendees for a given duration
        :param when: Time to check
        :param duration: Duration after the time
        :return: A list of all available attendees at the given time
        """
        available_attendees = []
        for attendee in self.calendar_list:
            if not self.calendar_list[attendee].is_busy_for_duration(when, duration):
                available_attendees.append(attendee)
        return available_attendees

    def calculate_time_bound_start(self, granularity):
        """
        Calculates the earliest time in a CalendarSet
        :param granularity: Time interval to search with
        :return: Earliest time in the CalendarSet
        """
        start = datetime.max
        for attendee in self.calendar_list:
            earliest_in_calendar = datetime.combine(
                self.calendar_list[attendee].earliest_date(),
                self.calendar_list[attendee].calculate_time_bound_start(granularity))
            if earliest_in_calendar < start:
                start = earliest_in_calendar
        return start
    
    def calculate_time_bound_end(self, granularity):
        """
        Calculates the latest time in a CalendarSet
        :param granularity: Time interval to search with
        :return: Latest time in the CalendarSet
        """
        end = datetime.min
        for attendee in self.calendar_list:
            latest_in_calendar = datetime.combine(
                self.calendar_list[attendee].latest_date(),
                self.calendar_list[attendee].calculate_time_bound_end(granularity))
            if latest_in_calendar > end:
                end = latest_in_calendar
        return end


class Calendar:

    def __init__(self, bl_calendar, owner, optional):
        """
        Instantiates a new Calendar object from raw json data
        :param bl_calendar: raw json data of a user's calendar
        :param owner: owner of the calendar
        :param optional: if the owner is optional to the event or not
        """
        calendar = json.loads(bl_calendar)
        self.email = owner
        self.optional = optional
        self.events = []
        for event in calendar:
            self.events.append(Event("blevent", {"blEvent": event}))

    def __len__(self):
        """
        Calculates the number of events in the Calendar
        :return: the number of events in this Calendar object
        """
        return len(self.events)

    def __str__(self):
        """
        Creates a json-formatted string representation of the object
        :return: json-formatted string representing this Calendar object
        """
        output = "["
        for event in self.events:
            output += "{\"calendar_email\":\"" + self.email + "\"," + str(event) + "},"
        output = output[:-1] + "]"
        return output

    def calculate_time_bound_start(self, granularity):
        """
        Performs a more advanced/thorough search of the earliest time in a calendar
        While the below functions do well to find the earliest time that any
        event starts at in a calendar, they only consider when an event starts.
        If an event starts too close to the end of the day, i.e. 23:30:00, and
        runs until, say 01:00:00, the below methods won't consider the time
        between as the earliest time an event occurs (the desired answer of
        00:00:00 should be returned). This method corrects this.
        :param granularity: Spacing to round to in time interval: > 0, < 1440
        :return:
        """
        import copy
        prototime = self.earliest_time()
        start_date = self.earliest_date()
        end_date = self.latest_date()
        
        prototime = (datetime.combine(start_date, prototime) +
                     timedelta(minutes=((granularity - prototime.minute % granularity) %
                                        granularity))).time()
        starttime = copy.deepcopy(prototime)
        width = (end_date - start_date).days+2
        for i in range(width):
            while True:
                if self.is_busy(datetime.combine(start_date, prototime) +
                                timedelta(days=i)):
                    starttime = copy.deepcopy(prototime)
                if prototime == time(hour=0, minute=0):
                    break
                prototime = (datetime.combine(start_date, prototime) -
                             timedelta(minutes=granularity)).time()
            if starttime == time(hour=0, minute=0):
                break
            prototime = copy.deepcopy(starttime)
        return starttime

    def calculate_time_bound_end(self, granularity):
        """
        Performs a more advanced/thorough search of the latest time in a calendar
        Similar to calculate_time_bound_start, this method will perform a check
        for busy-ness to find the latest time any event in a calendar occurs.
        :param granularity: Spacing to round to in time interval: > 0, < 1440
        :return:
        """
        import copy
        prototime = self.latest_time()
        start_date = self.earliest_date()
        end_date = self.latest_date()
        
        prototime = (datetime.combine(start_date, prototime) -
                     timedelta(minutes=prototime.minute % granularity)).time()
        end_time = copy.deepcopy(prototime)
        width = (end_date - start_date).days+2
        for i in range(width):
            while True:
                if self.is_busy(datetime.combine(start_date, prototime) +
                                timedelta(days=i)):
                    end_time = copy.deepcopy(prototime)
                if prototime == (datetime.combine(start_date, time(hour=23, minute=59)) -
                                 timedelta(minutes=granularity - 1)).time():
                    break
                prototime = (datetime.combine(start_date, prototime) +
                             timedelta(minutes=granularity)).time()
                
            if end_time == (datetime.combine(start_date, time(hour=23, minute=59)) -
                            timedelta(minutes=granularity - 1)).time():
                break
            prototime = copy.deepcopy(end_time)
        return end_time

    def earliest_date(self):
        """
        Finds the earliest date in the Calendar object
        :return: Date object, the earliest start date of any event in this Calendar object
        """
        min_date = date.max
        for event in self.events:
            if event.start.date() < min_date:
                min_date = event.start.date()
        return min_date

    def earliest_time(self):
        """
        Finds the earliest time in the Calendar object
        :return: Time object, the earliest start time of any event in this Calendar object
        """
        min_time = time.max
        for event in self.events:
            if event.start.time() < min_time:
                min_time = event.start.time()
        return min_time

    def is_busy(self, when):
        """
        Calculates if the owner is busy at the specified time
        :param when: DateTime to check
        :return: True if any event in the Calendar occurs during the specified time
        """
        for event in self.events:
            if event.is_busy(when):
                return True
        return False
    
    def is_busy_for_duration(self, when, duration):
        """
        Checks if any events in this calendar occur over the specified time + duration
        :param when: DateTime to check
        :param duration: Duration to check
        :return: True if any event in the calendar occurs during the specified time for a
                 given duration
        """
        temp_event = Event("duration", {"start": when,
                                        "duration": duration,
                                        "location": "",
                                        "travelTime": 0})
        for event in self.events:
            if temp_event.conflict(event):
                return True
        return False

    def latest_date(self):
        """
        Finds the latest end date of any event in this Calendar object
        :return: A Date object with the latest end date of any event in this Calendar
        """
        max_date = date.min
        for event in self.events:
            if event.end.date() > max_date:
                max_date = event.end.date()
        return max_date

    def latest_time(self):
        """
        Finds the latest end time of any event in this Calendar object
        :return: A Time object with the latest end date of any event in this Calendar
        """
        max_time = time.min
        for event in self.events:
            if event.end.time() > max_time:
                max_time = event.end.time()
        return max_time


class Event:

    def __init__(self, inittype, args):
        """
        Instantiates a new Event object
        :param inittype: Type of initialization either "blevent" or "duration"
        :param args: Required args varies depending on inittype
            inittype: blevent
                blEvent                         json formatted string of event data
            inittype: duration
                duration                        int representing minutes
                location                        string
                start                           datetime object
                travelTime                      int representing minutes of travel time
        """
        constructors = {
            "blevent":       self.construct_from_blevent,
            "duration":      self.construct_from_duration
        }
        constructor = constructors.get(inittype, -1)
        
        if constructor != -1:
            constructor(args)
        else:
            raise ValueError("Invalid inittype passed. Please refer to documentation to see valid inittypes")

    def construct_from_blevent(self, args):
        """
        Constructs the event object based on raw event data
        :param args: The args would only have "blEvent", containing start_time, end_time,
                     location, and travel_time
        :return: None
        """
        self.start = datetime.strptime(args["blEvent"]["start_time"],
                                       "%Y-%m-%dT%H:%M:%SZ")
        self.end = datetime.strptime(args["blEvent"]["end_time"],
                                     "%Y-%m-%dT%H:%M:%SZ")
        self.location = args["blEvent"]["location"]
        self.travelTime = int(args["blEvent"]["travel_time"])

    def construct_from_duration(self, args):
        """
        Constructs the event object from the args
        :param args: The args contain start, duration, location, and travelTime
        :return: None
        """
        self.start = args["start"]
        self.end = args["start"]+timedelta(minutes=args["duration"])
        self.location = args["location"]
        self.travelTime = args["travelTime"]

    def __len__(self):
        """
        Calculates the duration of the event in seconds
        :return: The duration of the event in seconds
        """
        return (self.end - self.start).seconds

    def __str__(self):
        """
        Returns a rough (incomplete/unbounded) json formatted string representing the event
        :return: rough (incomplete/unbounded) json formatted string representing the event
        """
        output = "\"start_time\":\"" + self.start.strftime("%Y-%m-%dT%H:%M:%SZ") + \
                 "\",\"end_time\":\"" + self.end.strftime("%Y-%m-%dT%H:%M:%SZ") + \
                 "\",\"location\":\"" + self.location + \
                 ",\"travel_time\":" + str(self.travelTime) + ""
        return output

    def conflict(self, other):
        """
        Checks for conflict with this event and another event
        :param other: The other event to compare with
        :return: True if there is a conflict, False otherwise
        """
        if not isinstance(other, Event):
            raise TypeError("Erroneous argument type supplied. Please use an Event object")
        if (other.start <= self.start < other.end) or \
           (other.start < self.end < other.end) or \
           (self.start <= other.start and self.end >= other.end):
            return True
        return False

    def is_busy(self, when):
        """
        Checks if a given datetime occurs during this event
        :param when: datetime object to check
        :return: True if the datetime occurs during the event, False otherwise
        """
        if self.start <= when < self.end:
            return True
        return False
