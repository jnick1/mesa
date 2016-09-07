from datetime import datetime, time, date


def construct_calendar_set(bl_calendar):
    """
    Constructs calendar set from calendar data
    :param bl_calendar: Calendar data blob from database
    :return: CalendarSet representing calendar data
    """
    import classes
    attendees = bl_calendar["attendance"]
    attendees_calendar_data = {}
    for attendee in attendees:
        attendees_calendar_data[attendee] = classes.Calendar(bl_calendar[attendee], attendee, attendees[attendee])
    calendar_set = classes.CalendarSet(attendees_calendar_data)
    return calendar_set


def binary_index(item_list, search):
    """
    Performs binary search for an object in a sorted item_list
    :param item_list: item_list to search
    :param search: object to search for
    :return: index of the object
    """
    # return _rbinary_index(item_list, 0, len(item_list)-1, search)
    start = 0
    end = len(item_list) - 1
    while start < end:
        mid = (start+end)//2
        if item_list[mid] == search:
            return mid
        elif item_list[mid] < search:
            start = mid+1
        else:
            end = mid-1
    return -1


def is_number(test):
    """
    Checks if the object is a number
    :param test: The object to test
    :return: True if the object is a number, False otherwise
    """
    try:
        float(test)
        return True
    except ValueError:
        return False


def maxdate(dates):
    """
    Finds the latest date in a list of dates (might be able to be replaced by max())
    :param dates: List of dates
    :return: Latest date
    """
    from datetime import date
    maxdate = date.min
    for when in dates:
        if when > maxdate:
            maxdate = when
    return maxdate


def maxtime(times):
    """
    Finds the latest time in a list of times (might be able to be replaced by max())
    :param times: List of times
    :return: Latest time
    """
    from datetime import time
    maxtime = time.min
    for when in times:
        if when > maxtime:
            maxtime = when
    return maxtime


def mindate(dates):
    """
    Finds the earliest date in a list of dates (might be able to be replaced by min())
    :param dates: List of dates
    :return: Earliest date
    """
    from datetime import date
    mindate = date.max
    for when in dates:
        if when < mindate:
            mindate = when
    return mindate


def mintime(times):
    """
    Finds the earliest time in a list of times (might be able to be replaced by min())
    :param times: List of times
    :return: Earliest time
    """
    from datetime import time
    mintime = time.max
    for when in times:
        if when < mintime:
            mintime = when
    return mintime


def diffdate(date_a, date_b):
    return (datetime.combine(date_a, time(0, 0, 0)) -
            datetime.combine(date_b, time(0, 0, 0))).days


def difftime(time_a, time_b):
    return (datetime.combine(date(1, 1, 1), time_a) -
            datetime.combine(date(1, 1, 1), time_b)).total_seconds()


def parse_priorities(bl_settings):
    """
    Parses blSettings into a dictionary of priorities
    :param bl_settings: Blob of settings from database
    :return: Dictionary of priorities
    """
    priorities = {
        "time":         1,
        "date":         2,
        "duration":     3,
        "repeat":       4,
        "location":     5,
        "granularity":  6,
        "attendees":    7,
    }
    if not bl_settings["useDefault"]:
        if bl_settings["time"]:
            priorities["time"] *= int(bl_settings["time"]["prioritization"])
        if bl_settings["date"]:
            priorities["date"] *= int(bl_settings["date"]["prioritization"])
        if bl_settings["duration"]:
            priorities["duration"] *= int(bl_settings["duration"]["prioritization"])
        if bl_settings["repeat"]:
            priorities["repeat"] *= int(bl_settings["repeat"]["prioritization"])
        if bl_settings["location"]:
            priorities["location"] *= int(bl_settings["location"]["prioritization"])
        if bl_settings["attendees"]:
            priorities["attendees"] *= int(bl_settings["attendees"]["prioritization"])
    return priorities


def parse_rrule(tx_rrule):
    """
    Parses txRRule into a dictionary
    :param tx_rrule: Text for recurrence rule
    :return: Dictionary representation of the recurrence rule
    """
    if tx_rrule != "":
        rules = tx_rrule.split(";")
        rrule = {}
        for rule in rules:
            if rule != "":
                keyval = rule.split("=")
                if keyval[1].isdigit():
                    rrule[keyval[0]] = int(keyval[1])
                else:
                    rrule[keyval[0]] = keyval[1]
        return rrule
    else:
        return tx_rrule


def strpdate(string, new_format):
    """
    Converts a string representing a date into a date based on a given format
    :param string: String representing a date
    :param new_format: Format of the datetime conversion
    :return: DateTime object representing the string passed in
    """
    from datetime import datetime
    new_format += "T%H:%M:%S"
    return datetime.strptime(string + "T00:00:00", new_format).date()


def strptime(string, new_format):
    """
    Converts a string representing a time into a time based on a given format
    :param string: String representing a time
    :param new_format: Format of the datetime conversion
    :return:
    """
    from datetime import datetime
    new_format = "%Y-%m-%dT" + new_format
    return datetime.strptime("2016-01-01T" + string, new_format).time()


def swap(a, b):
    """
    Returns a tuple of swapped values
    :param a: First element
    :param b: Second element
    :return: A tuple where the first element is b and the second element is a (deepcopy)
    """
    import copy
    return copy.deepcopy(b), copy.deepcopy(a)
