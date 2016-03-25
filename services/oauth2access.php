<?php

require_once __DIR__ . '/google-services-header.php';

//Attendee begins here

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (isset($_GET['t'])) {
    $_SESSION['token_id'] = filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING);
    
} elseif (isset($_GET['code'])) {
    $client->authenticate(filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING)); //Authenticate client with code
    if ($client->isAccessTokenExpired()) {
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    }
    $_SESSION['access_token'] = $client->getAccessToken(); //Store access token in session
    redirect_local('google-calendar-access.php'); //Switch back to data retrieval
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}

