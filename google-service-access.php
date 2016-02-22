<?php
require_once __DIR__ . '/vendor/autoload.php';
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('HOST_URI', 'http://' . $_SERVER['HTTP_HOST'] . '/mesa/');

session_start();

global $client;
$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) { //Check if have access token
    $client->setAccessToken($_SESSION['access_token']);
    retrieve_events($client, 'primary');
} else {
    $redirect_uri = HOST_URI . 'oauth2callback.php'; //Assumes mesa will be in a folder mesa, can be changed
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //Redirect to ask user authentication
}
session_unset();
session_destroy();

/*
 * Parameters:
 *  client - the client to retrieve data from
 * Return values:
 *  Returns json-formatted events in verifier's calendar
 */

function retrieve_events($client) {
    $service = new Google_Service_Calendar($client);
    $calendar_list = $service->calendarList->listCalendarList()->getItems();
    $events_by_calendar = array();
    foreach ($calendar_list as $calendar) {
        $events = $service->events->listEvents($calendar->id)->getItems();
        $events_by_calendar[$calendar->id] = $events;
    }
    var_dump($events_by_calendar);
    return $events_by_calendar; //Output results
}
?>
