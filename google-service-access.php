<?php
require_once __DIR__ . '/vendor/autoload.php';
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

session_start();

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) { //Check if have access token
  $client->setAccessToken($_SESSION['access_token']);
  $event_service = new Google_Service_Calendar($client);
  $optParams = array('orderBy' => "startTime");
  $events_list = $event_service->events->listEvents('primary'); //Gets all events in player's calendar
  echo json_encode($events_list); //Output Json results, temporary
  session_unset();
  session_destroy();
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //Redirect to ask user authentication
}
?>

