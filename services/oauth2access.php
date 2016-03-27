<?php

require_once __DIR__ . '/paths-header.php';
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;
require_once FILE_PATH . SQL_ACCESS_PATH;


//Attendee begins here

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_FILE);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
retrieve_calendar_data($client);

function retrieve_calendar_data($client) {
    $t = filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING);
    $e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
    $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_URL);
    if (isset($t) && isset($e)) {
        $_SESSION['token_id'] = $t;
        $_SESSION['event_id'] = $e;
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    } elseif (isset($code)) {
        $client->authenticate($code); //Authenticate client with code
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
