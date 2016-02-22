<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/google-service-access.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
$client->setRedirectUri(HOST_URI . 'oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']); //Authenticate client with code
  $_SESSION['access_token'] = $client->getAccessToken(); //Store access token in session
  $redirect_uri = HOST_URI . 'google-service-access.php'; //Switch back to data retrieval
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>
