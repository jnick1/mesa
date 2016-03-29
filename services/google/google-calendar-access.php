<?php
require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;
require_once FILE_PATH . BING_MAPS_ACCESS_PATH;
require_once FILE_PATH . SQL_ACCESS_PATH;

if(!isset($_SESSION['event_id']) || !isset($_SESSION['token_id'])){
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
        $finalized_event_list = calculate_travel_times($events_output);
        insert_mysql_info($finalized_event_list);
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
        'timeMin' => $_SESSION['sql_event_start'],
        'timeMax' => $_SESSION['sql_event_end'],
        'timeZone' => 'UTC');

    foreach ($user_calendar_list as $calendar) {
        $events = $service->events->listEvents($calendar->id, $optParams)->getItems();
        foreach ($events as $event) {
            $trimmed_event = format_trim_event($event);
            $event_list[] = $trimmed_event;
        }
    }
    $client->revokeToken(); //Done with this client
    return $event_list; //Output results
}

function format_trim_event($event) {
    $trimmed_event = [];
    $trimmed_event['calendar_email'] = $_SESSION['calendar_email'];
    $trimmed_event['start_time'] = $event->start->dateTime;
    $trimmed_event['end_time'] = $event->end->dateTime;
    $trimmed_event['location'] = $event->location;

    return $trimmed_event;
}

function calculate_travel_times($events) {
    $destination_location = $_SESSION['sql_event_location'];

    $final_events = array();
    foreach ($events as $event) {
        if($event['location'] != "" && $destination_location != ""){
            $travel_time = retrieve_travel_time($event['location'], $destination_location);
            $event['travel_time'] = $travel_time;
        } else {
            $event['travel_time'] = 0;
        }
        $final_events[] = $event;
    }
    return $final_events;
}

function insert_mysql_info($events_array) {
    $serialized_events = serialize($events_array);
    insert_event_data($serialized_events);
    session_destroy();
    
    session_start();
    $_SESSION['calendarsaved'] = array("messagetype"=>"notifications", "message"=>"Success! Your calendar data has been saved. Thank you for using MESA.");
    redirect_local("../index.php");
//Page for providing calendar data
}

?>