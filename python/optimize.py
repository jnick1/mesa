import sys
import json
from functions import parse_rrule, parse_priorities, construct_calendar_set
from classes import Event
from pointListGenerator import construct_point_list
from costFinder import smallest_cost


def main():
    granularity = 15  # TODO allow change of granularity

    dt_start = sys.argv[1]
    dt_end = sys.argv[2]
    tx_location = sys.argv[3]
    tx_rrule = sys.argv[4]
    temp = open("C:/wamp/www/mesa/python/temp1.json", "r")  # TODO make relative path
    bl_calendars = json.loads(temp.read())
    temp.close()
    temp = open("C:/wamp/www/mesa/python/temp2.json", "r")
    bl_settings = json.loads(temp.read())
    temp.close()

    rrule = parse_rrule(tx_rrule)  # TODO create use for rrule

    priorities = parse_priorities(bl_settings)
    original_event = Event("blevent", {
        "blEvent": {"start_time": dt_start.replace(" ", "T") + "Z",
                    "end_time": dt_end.replace(" ", "T") + "Z",
                    "location": tx_location,
                    "travel_time": 0}})
    calendar_set = construct_calendar_set(bl_calendars)
    point_list = construct_point_list(calendar_set,
                                      granularity,
                                      original_event,
                                      bl_settings)

    cost_output = smallest_cost(point_list,
                                priorities,
                                original_event,
                                granularity,
                                tx_location,
                                calendar_set)
    print(cost_output)


if __name__ == "__main__":
    main()
