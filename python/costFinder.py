from datetime import datetime, timedelta
import heapq
from operator import itemgetter


def smallest_cost(point_list, priorities, original_event, granularity, location, calendar_set):
    """
    Finds and returns the 10 events with the smallest cost from the pointList
    :param point_list: List of points corresponding to events
    :param priorities: Dictionary of priorities
    :param original_event: Event object representation of the original event
    :param granularity: Granularity of search
    :param location: Location of the event
    :param calendar_set: Set of event data
    :return: String representation of the best 10 events according to cost
    """
    cost_list = []
    if point_list is None:
        return None
    else:
        output = "\"0\": { "
        for point in point_list:
            cost_list.append(vector_cost(point, priorities))
        cost_list = heapq.nsmallest(10, cost_list, key=itemgetter("cost"))  # should run in O(nlog(10))
        # sorted(cost_list, key=itemgetter("cost")) runs in O(nlogn)
        for item_id, item in enumerate(cost_list):
            string_output = "\"" + str(item_id) + "\": " + \
                            date_of_cost(item,
                                         original_event,
                                         granularity,
                                         item_id,
                                         location,
                                         calendar_set) + ","
            output += string_output
        output = output[0: len(output) - 1] + "}"
        return output


def vector_cost(point, priorities):
    """
    Converts points to cost
    :param point: Point representing a datetime's distance from original event
                  Format: time, date, duration, attendees
    :param priorities: Dictionary of priorities
    :return: Integer cost of a vector from the original to the event (scaled on priority)
    """
    diff_time = point[0]  # TODO convert to namedtuple
    diff_date = point[1]
    diff_dur = point[2]  # 0 = original duration, 2 = 2 granularity below duration, etc
    diff_attendees = point[3]  # 0 = Max People, 2 = 2 people under Max

    timeCost = abs(diff_time) * priorities["time"]
    dateCost = abs(diff_date) * priorities["date"]
    durCost = abs(diff_dur) * priorities["duration"]
    attendCost = abs(diff_attendees) * priorities["attendees"]

    cost = timeCost + dateCost + durCost + attendCost
    costobj = {"time": diff_time, "date": diff_date, "duration": diff_dur, "attendees": diff_attendees, "cost": cost}
    return costobj


def date_of_cost(solution_event, original_event, granularity, solution_id, location, calendar_set):
    """
    Returns the string date corresponding to the date point
    :param solution_event: Solution event for the search terms
    :param original_event: Original event searching for
    :param granularity: Granularity of search
    :param solution_id: ID/ position of solution
    :param location: Location of the event
    :param calendar_set: Set of calendar data
    :return:
    """
    start_time = original_event.start - timedelta(minutes=(granularity - original_event.start.minute % granularity) % granularity)
    starting_duration = (original_event.end - original_event.start).total_seconds() // 60
    starting_duration += (granularity - starting_duration % granularity) % granularity

    new_date = (start_time + timedelta(days=solution_event["date"])).date()
    new_time = (start_time + timedelta(minutes=solution_event["time"] * granularity)).time()
    new_duration = starting_duration - (solution_event["duration"] * granularity)
    
    new_end_time = datetime.combine(new_date,new_time) + timedelta(minutes=new_duration)
    attendees = calendar_set.available_attendees(datetime.combine(new_date, new_time), new_duration)

    return to_string(new_date, new_time, solution_event["cost"], solution_id, new_end_time, location, attendees)


def to_string(new_date, new_time, cost, solution_id, end, location, people):
    """
    Converts event into a string representation
    :param new_date: Solution date
    :param new_time: Solution time
    :param cost: Cost of the solution
    :param solution_id: solution number/rank
    :param end: Solution end
    :param location: Solution location
    :param people: Attendees to solution
    :return: String representation of an event
    """
    import json
    attendees = {}
    for person in people:
        attendees[person] = True
    jsonstring = {
        "start": datetime.combine(new_date, new_time).strftime("%Y-%m-%dT%H:%M:%SZ"),
        "end": end.strftime("%Y-%m-%dT%H:%M:%SZ"),
        "location": location,
        "cost": cost,
        "id": solution_id,
        "attendees": attendees
    }
    return json.dumps(jsonstring)
