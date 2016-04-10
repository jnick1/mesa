<?php

require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;
require_once FILE_PATH . BING_MAPS_ACCESS_PATH;
require_once FILE_PATH . SQL_ACCESS_PATH;

if (!isset($_SESSION['event_id']) || !isset($_SESSION['token_id'])) {
    redirect_local(ERROR_PATH . "/?e=missing_token");
}

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_FILE);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

access_token_check($client);

function access_token_check($client) {
    //Check if we have access token
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {//If we do, setup the client and service and move on
        $client->setAccessToken($_SESSION['access_token']);
        if ($client->isAccessTokenExpired()) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
            exit();
        }
        $service = new Google_Service_Calendar($client);

        calendar_check($service, $client);
    } else { //If we do not, setup the redirect to get the token
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    }
}

function calendar_check($service, $client) { //Now that service is set up, deal with calendars
    if ((isset($_SESSION['user_calendar_summaries']) && $_SESSION['user_calendar_summaries'])) {
        sql_load_event_retrieval(); //Organizing event data now becomes useful

        $user_calendar_list = collect_calendars_from_summaries($service);
        $events_output = retrieve_event_list($service, $user_calendar_list, $client);
        insert_mysql_info($events_output);
    } else {
        collect_summaries($service);
    }
}

function collect_summaries($service) {
    $calendar_list = $service->calendarList->listCalendarList()->getItems();
    $calendar_summaries = [];
    foreach ($calendar_list as $calendar) {
        array_push($calendar_summaries, $calendar->summary);
    }
    $_SESSION['calendar_summaries'] = $calendar_summaries;
    redirect_local(GOOGLE_CALENDAR_CHOICE_PATH);
}

function collect_calendars_from_summaries($service) {
    $calendar_list = $service->calendarList->listCalendarList()->getItems();
    $user_calendar_summaries = $_SESSION['user_calendar_summaries'];
    $user_calendar_list = [];
    foreach ($user_calendar_summaries as $calendar_summary) {
        foreach ($calendar_list as $calendar) {
            check_for_attendee_email($calendar);

            if ($calendar->summary == $calendar_summary) {
                array_push($user_calendar_list, $calendar);
            }
        }
    }
    return $user_calendar_list;
}

//Retrieve email based upon primary calendar summary
function check_for_attendee_email($calendar) {
    if ($calendar->primary) {
        $_SESSION['calendar_email'] = $calendar->summary;
    }
}

function retrieve_event_list($service, $user_calendar_list, $client) {
    $event_list = [];
    $optParams = array('singleEvents' => true,
        'orderBy' => 'startTime',
        'timeMin' => $_SESSION['sql_search_start'],
        'timeMax' => $_SESSION['sql_search_end'],
        'timeZone' => 'UTC');
    
    $prev_checked_distances = [];
    foreach ($user_calendar_list as $calendar) {
        $events = $service->events->listEvents($calendar->id, $optParams)->getItems();
        foreach ($events as $event) {
            $trimmed_event = format_trim_event($event, $prev_checked_distances);
            if ($trimmed_event != NULL) {
                $event_list[] = $trimmed_event;
            }
        }
    }
    $client->revokeToken(); //Done with this client
    return $event_list; //Output results
}

function format_trim_event($event, &$prev_checked_distances) {
    
    $trimmed_event = [];
    $trimmed_event['calendar_email'] = $_SESSION['calendar_email'];
    if ($event->start->dateTime == NULL || $event->end->dateTime == NULL) {
        return NULL; //Ignore all-day events
    }
    $trimmed_event['start_time'] = $event->start->dateTime;
    $trimmed_event['end_time'] = $event->end->dateTime;
    $trimmed_event['location'] = $event->location;
    
    $destination_location = $_SESSION['sql_event_location'];
    
    if ($event->location != "" && $destination_location != "") {
        if(isset($prev_checked_distances[$event->location])){ //Minimize Bing API calls
            $trimmed_event['travel_time'] = $prev_checked_distances[$event->location];
        } else {
            $travel_time = retrieve_travel_time($event->location, $destination_location);
            $trimmed_event['travel_time'] = $travel_time;
            $prev_checked_distances[$event->location] = $travel_time;
        }
    } else {
        $trimmed_event['travel_time'] = 0;
    }
    return $trimmed_event;
}

function insert_mysql_info($events_array) {
    $serialized_events = (string) json_encode($events_array);
    insert_event_data($serialized_events);
    unset_session_variables();
    $_SESSION['calendarsaved'] = array("messagetype" => "notifications", "message" => "Success! Your calendar data has been saved. Thank you for using MESA. You may now close the page.");
    redirect_local("../index.php");
    exit();
}

function unset_session_variables(){
    unset($_SESSION['token_id']);
    unset($_SESSION['event_id']);
    unset($_SESSION['sql_attendee_email']);
    unset($_SESSION['access_token']);
    unset($_SESSION['calendar_summaries']);
    unset($_SESSION['user_calendar_summaries']);
    unset($_SESSION['sql_event_id']);
    unset($_SESSION['sql_event_location']);
    unset($_SESSION['sql_search_start']);
    unset($_SESSION['sql_search_end']);
    unset($_SESSION['calendar_email']);
}
