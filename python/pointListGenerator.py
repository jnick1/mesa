from datetime import timedelta
from functions import diffdate, difftime
import math


def construct_point_list(calendar_set, granularity, base_event, bl_settings):
    """
    Constructs list of points representing the coordinates away from the original event
    :param calendar_set: Set of calendar event data
    :param granularity: Granularity of search
    :param base_event: Starting event to reference as origin
    :param bl_settings: Settings of search
    :return: list of points representing all possible events within the settings given
    """
    start_event = base_event.start - \
                  timedelta(minutes=((granularity -
                                      base_event.start.minute %
                                      granularity) %
                                     granularity))
    start_time = start_event.time()
    start_date = start_event.date()
    starting_duration = (base_event.end - base_event.start).total_seconds() // 60
    starting_duration += (granularity - starting_duration % granularity) % granularity

    can_modulate = interpret_modulatable(bl_settings)

    final_point_list = []

    if not (can_modulate["attendees"] or
            can_modulate["duration"] or
            can_modulate["date"] or
            can_modulate["time"]):
        # Now check if original event works, if not, return None
        attendees = calendar_set.available_attendees(start_event, starting_duration)
        if len(attendees) < len(calendar_set.attendees):
            return None
        final_point_list.append([0, 0, 0, 0])
        return final_point_list
    else:
        duration_list = generate_duration_list(can_modulate["duration"],
                                               granularity,
                                               starting_duration)
        len_matrix_attendees = len(calendar_set.calendarList)  # Externalize len call
        for duration_increment, duration in enumerate(duration_list):
            search_pos = calendar_set.calculate_time_bound_start(granularity) - \
                         timedelta(minutes=granularity)
            search_end = calendar_set.calculate_time_bound_end(granularity)
            while search_pos < search_end:
                search_pos = search_pos + timedelta(minutes=granularity)
                search_pos_time = search_pos.time()
                if not can_modulate["time"] and search_pos_time != start_time:
                    continue
                search_pos_date = search_pos.date()
                if not can_modulate["date"] and search_pos_date != start_date:
                    continue
                required_busy = calendar_set.is_required_attendees_busy(search_pos,
                                                                        duration)
                if required_busy:
                    continue
                available_attendees = calendar_set.available_attendees(search_pos,
                                                                       duration)
                len_attendees = len(available_attendees)
                if len_attendees < can_modulate["minAttendees"]:
                    continue
                if not can_modulate["attendees"]:
                    if len_attendees < len_matrix_attendees:
                        continue
                diff_dates = diffdate(start_date, search_pos_date)
                diff_times = math.ceil(difftime(start_time, search_pos_time) /
                                       (60 * granularity))
                datetime_point = [-1 * diff_times,
                                  -1 * diff_dates,
                                  duration_increment,
                                  len_matrix_attendees - len_attendees]
                final_point_list.append(datetime_point)
    return final_point_list


def generate_duration_list(can_modulate_duration, granularity, starting_duration):
    """
    Generates a list of durations to check through
    :param can_modulate_duration: If the duration is modulatable
    :param granularity: Granularity to decrease duration by
    :param starting_duration: Maximum duration to check
    :return: List of possible durations
    """
    duration_list = [starting_duration]
    if can_modulate_duration:
        duration = starting_duration - granularity
        while duration >= granularity:
            duration_list.append(duration)
            duration -= granularity
    return duration_list


def interpret_modulatable(bl_settings):
    """
    Expands bl_settings into a keyed list
    :param bl_settings: Settings from database
    :return: Keyed list expanded from settings in database
    """
    can_modulate = {"time": True,
                    "date": True,
                    "duration": True,
                    "attendees": True,
                    "minattendees": 1}
    if bl_settings["useDefault"] is False:
        if bl_settings["time"]:
            can_modulate["time"] = bl_settings["time"]["timeallow"]
        if bl_settings["date"]:
            can_modulate["date"] = bl_settings["date"]["dateallow"]
        if bl_settings["duration"]:
            can_modulate["duration"] = bl_settings["duration"]["durationallow"]
        if bl_settings["attendees"]:
            can_modulate["attendees"] = bl_settings["attendees"]["attendeesallow"]
            can_modulate["minattendees"] = int(bl_settings["attendees"]["minattendees"])
    return can_modulate
