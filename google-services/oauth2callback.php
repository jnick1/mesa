<?php
require __DIR__ . '/google-services-header.php';

$client = new Google_Client();
$client->setAuthConfigFile(CLIENT_SECRET_PATH);
//$client->setRedirectUri(HOST_URI . 'oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']); //Authenticate client with code
    $_SESSION['access_token'] = $client->getAccessToken(); //Store access token in session
    redirect_local('google-service-access.php'); //Switch back to data retrieval
    
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}
?>
