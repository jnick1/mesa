import sys
import json
import functions
import classes
import pointListGenerator
import costFinder


def main():
    granularity = 15  #TODO allow change of granularity

    dt_start = sys.argv[1]
    dt_end = sys.argv[2]
    tx_location = sys.argv[3]
    tx_rrule = sys.argv[4]
    temp = open("C:/wamp/www/mesa/python/temp1.json", "r")
    bl_calendars = json.loads(temp.read())
    temp.close()
    temp = open("C:/wamp/www/mesa/python/temp2.json", "r")
    bl_settings = json.loads(temp.read())
    temp.close()

    rrule = functions.parse_rrule(tx_rrule)

    priorities = functions.parse_priorities(bl_settings)
    original_event = classes.Event("blevent", {"blEvent":
                                       {"start_time": dt_start.replace(" ", "T") + "Z",
                                        "end_time": dt_end.replace(" ", "T")+"Z",
                                        "location": tx_location,
                                        "travel_time": 0}})
    calendar_set = functions.construct_calendar_set(bl_calendars)
    point_list = pointListGenerator.construct_point_list(calendar_set,
                                                         granularity,
                                                         original_event,
                                                         bl_settings)

    cost_output = costFinder.smallest_cost(point_list,
                                           priorities,
                                           original_event,
                                           granularity,
                                           tx_location,
                                           calendar_set)
    print(cost_output)


if __name__ == "__main__":
    main()
