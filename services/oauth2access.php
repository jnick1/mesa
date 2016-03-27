<?php
require_once __DIR__ . '/paths-header.php';
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;
require_once FILE_PATH . SQL_ACCESS_PATH;


//Attendee begins here

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_FILE);
if (!isset($_SESSION['create-event']) || $_SESSION['create-event'] == false) {
    $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
    retrieve_calendar_data($client);
} elseif ($_SESSION['create-event'] == true) {
    $client->addScope(Google_Service_Calendar::CALENDAR);
    create_calendar_event($client);
} else {
    //Figure out what to do if create-event is set to something random
}

function retrieve_calendar_data($client) {
    if (isset($_GET['t']) && isset($_GET['e'])) {
        $_SESSION['token_id'] = filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING);
        $_SESSION['event_id'] = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    } elseif (isset($_GET['code'])) {
        $client->authenticate(filter_input(INPUT_GET, 'code', FILTER_SANITIZE_URL)); //Authenticate client with code
        if ($client->isAccessTokenExpired()) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        }
        $_SESSION['access_token'] = $client->getAccessToken(); //Store access token in session
        redirect_local(GOOGLE_CALENDAR_ACCESS_PATH);
    } else {
        redirect_local(ERROR_PATH . "/?e=missing_token");
    }
}

function create_calendar_event($client){
    
}