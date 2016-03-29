<?php
//Solely used for updating paths easily
define('FILE_PATH', substr(__DIR__, 0, strpos(__DIR__, 'services') + 8) . "\\");
define('SECURE_PATH', substr(__DIR__, 0, strpos(__DIR__, 'wamp') + 4) . "\\secure/");

define('GOOGLE_PATH', 'google/');

define('GOOGLE_CALENDAR_ACCESS_PATH', GOOGLE_PATH . 'google-calendar-access.php');
define('GOOGLE_SERVICES_HEADER_PATH', GOOGLE_PATH . 'google-services-header.php');
define('GOOGLE_CALENDAR_CHOICE_PATH', GOOGLE_PATH . 'user-calendar-query.php');

define('BING_MAPS_ACCESS_PATH', 'bing/bing-maps-access.php');

define('OAUTH2_PATH', 'oauth2access.php');
define('ERROR_PATH', 'services-error.php');
define('SQL_ACCESS_PATH', 'services-sql-request.php');

//Files require the base path
define('CLIENT_SECRET_FILE', SECURE_PATH . 'client_secret.json');
define('BING_SECRET_FILE', SECURE_PATH . 'bing_secret.txt');
define('GOOGLE_API_FILE', FILE_PATH . '../vendor/autoload.php');