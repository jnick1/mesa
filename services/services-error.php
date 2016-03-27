<?php
session_start();
switch (filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING)){
    case "invalid_token":
        echo 'Token was invalid or has already been used.';
        break;
    case "invalid_event":
        echo 'Event was invalid or has been removed.';
        break;
    case "invalid_email":
        echo 'Email found was invalid. This is due to an unknown error. Please try the link again.';
        break;
    case "missing_token":
        echo 'URL does not include access token.';
        break;
    case "missing_event":
        echo 'URL does not include event id.';
        break;
    case "sql_connection":
        echo 'SQL database connection error';
        break;
    default:
        echo 'Unknown error, please try again';
        break;
}
session_destroy();

