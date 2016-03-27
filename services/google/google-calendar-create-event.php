<?php

//Separate from original Oauth authentication completely, might not be able to, though. Will test separately for now.

require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;
require_once FILE_PATH . SQL_ACCESS_PATH;

$e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
if (isset($e)) {
    $_SESSION['event_id'] = $e;
    $service = setup_client_service();
    $blOptiSuggestion = retrieve_event_creation_data($event_id);
    $event_data = unserialize($blOptiSuggestion);
    $event = create_event_from_data($event_data, $service);
    $service->events->insert('primary', $event, array('sendNotifications' => true));
} else {
    redirect_local(ERROR_PATH . "/?e=missing_event");
}

function setup_client_service() {
    $client = new Google_Client();
    $credentials = SERVICE_ACCOUNT_FILE;
    $client->setAuthConfig($credentials);
    
    $service = new Google_Service_Calendar($client);
    return $service;
}

function create_event_from_data($event_data) {
    $event_data['start']['dateTime'] = format_date_from_sql($event_data['start']['dateTime']);
    $event_data['end']['dateTime'] = format_date_from_sql($event_data['end']['dateTime']);
    
    $event = new Google_Service_Calendar_Event($event_data);
    return $event;
}
