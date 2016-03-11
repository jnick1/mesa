<?php
require __DIR__ . '/google-services-header.php';

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

//Check if have access token
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {//If we do, setup the client and service and move on
    $client->setAccessToken($_SESSION['access_token']);
    $service = new Google_Service_Calendar($client);
} else { //If we do not, setup the redirect to get the token
    redirect_local('oauth2callback.php');
}

//Now that service is set up, deal with calendars
if ((isset($_SESSION['user_calendar_summaries']) && $_SESSION['user_calendar_summaries'])) {
    $calendar_list = $service->calendarList->listCalendarList()->getItems();
    $user_calendar_summaries = $_SESSION['user_calendar_summaries'];
    $user_calendar_list = [];
    foreach($user_calendar_summaries as $calendar_summary){
        foreach($calendar_list as $calendar){
            if($calendar->summary == $calendar_summary){
                array_push($user_calendar_list, $calendar);
            }
        }
    }
    $events_output = retrieve_events($service, $user_calendar_list);
} else {
    $calendar_list = $service->calendarList->listCalendarList()->getItems();
    $calendar_summaries = [];
    foreach($calendar_list as $calendar){
        array_push($calendar_summaries, $calendar->summary);
    }
    $_SESSION['calendar_summaries'] = $calendar_summaries;
    var_dump($_SESSION['calendar_summaries']);
    redirect_local("user-calendar-query.php");
}

session_unset();
session_destroy();

function retrieve_events($service, $user_calendar_list) {
    if(!isset($service)){
        return NULL;
    }
    
    $events_by_calendar = [];
    
    foreach ($user_calendar_list as $calendar) {
        $events = $service->events->listEvents($calendar->id)->getItems();
        $events_by_calendar[$calendar->summary] = $events;
    }
    var_dump($events_by_calendar);
    return $events_by_calendar; //Output results
}
?>
