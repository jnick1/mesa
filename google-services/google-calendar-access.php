<?php

require_once __DIR__ . '/google-services-header.php';
require_once __DIR__ . '/bing-maps-access.php';
require_once __DIR__ . '/services-sql-request.php';

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

access_token_check($client);

function access_token_check($client) {
    //Check if we have access token
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {//If we do, setup the client and service and move on
        $client->setAccessToken($_SESSION['access_token']);
        if ($client->isAccessTokenExpired()) {
            redirect_local('oauth2access.php');
        }
        $service = new Google_Service_Calendar($client);
        if (!isset($service)) {
            session_destroy();
            return NULL;
        }
        calendar_check($service, $client);
    } else { //If we do not, setup the redirect to get the token
        redirect_local('oauth2access.php');
    }
}

function calendar_check($service, $client) { //Now that service is set up, deal with calendars
    if ((isset($_SESSION['user_calendar_summaries']) && $_SESSION['user_calendar_summaries'])) {
        sql_load(); //Organizing event data now becomes useful
        
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
    redirect_local("user-calendar-query.php");
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
        $_SESSION['attendee_email'] = $calendar->summary;
    }
}

function retrieve_event_list($service, $user_calendar_list, $client) {
    $event_list = [];
    $optParams = array('singleEvents' => true,
        'orderBy' => 'startTime',
        'timeMin' => $_SESSION['sql_event_start'],
        'timeMax' => $_SESSION['sql_event_end']);

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
    $trimmed_event['attendee_email'] = $_SESSION['attendee_email'];
    $trimmed_event['start_time'] = $event->startTime;
    $trimmed_event['end_time'] = $event->endTime;
    $trimmed_event['location'] = $event->location;

    return $trimmed_event;
}

function calculate_travel_times($events) {
    $destination_location = $_SESSION['sql_event_location'];
    if($destination_location == ""){
        return $events;
    }
    foreach ($events as $event) {
        if($event['location'] != ""){
            $travel_time = 0; //retrieve_travel_time($event['location'], $destination_location);
            $event['travel_time'] = $travel_time;
        }
    }
}

function insert_mysql_info($events_output) {
    var_dump($events_output);



    session_destroy();
}

?>