<?php

require_once __DIR__ . '/google-services-header.php';

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

access_token_check($client);

function access_token_check($client) {
    //Check if we have access token
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {//If we do, setup the client and service and move on
        $client->setAccessToken($_SESSION['access_token']);
        if($client->isAccessTokenExpired()){
            redirect_local('oauth2access.php');
        }
        $service = new Google_Service_Calendar($client);
        if (!isset($service)) {
            break_session();
            return NULL;
        }
        calendar_check($service, $client);
    } else { //If we do not, setup the redirect to get the token
        redirect_local('oauth2access.php');
    }
}

function calendar_check($service,$client) {
//Now that service is set up, deal with calendars
    if ((isset($_SESSION['user_calendar_summaries']) && $_SESSION['user_calendar_summaries'])) {
        $user_calendar_list = collect_calendars_from_summaries($service);
        $events_output = retrieve_events($service, $user_calendar_list, $client);
        insert_mysql_info($events_output);
    } else {
        collect_summaries($service);
    }
}

function retrieve_events($service, $user_calendar_list, $client) {
    $events_by_calendar = [];

    foreach ($user_calendar_list as $calendar) {
        $events = $service->events->listEvents($calendar->id)->getItems();
        $events_by_calendar[$calendar->summary] = $events;
    }
    
    $client->revokeToken(); //Done with this client
    
    return $events_by_calendar; //Output results
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
            if ($calendar->summary == $calendar_summary) {
                array_push($user_calendar_list, $calendar);
            }
        }
    }
    
    return $user_calendar_list;
}

function insert_mysql_info($events_output) {
    var_dump($events_output);

    $connection = new mysqli("localhost", "root", "", "mesadb");
    $calendar_data;
    break_session();
}

?>