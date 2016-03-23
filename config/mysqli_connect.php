<?php

// This file contains the database access information. 
// This file also establishes a connection to MySQL 
// and selects the database.

// Set the database access information as constants:
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'mesadb');

// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

if (!mysqli_set_charset($dbc, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($dbc));
}

function spam_scrubber($value) {
	// This function is useful for preventing spam in form results.  Should be used on all $_POST arrays.
	// To Use:  $scrubbed=array_map('spam_scrubber',ARRAY_NAME);  Where ARRAY_NAME might be equal to an array such as $_POST
	// Then set the item to an array, such as $scrubbed = array_map('spam_scrubber', $_POST);
	// Then refer to the item in the array as $scrubbed['item_name']

	// List of very bad values:
	
	$very_bad=array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	// IF any of the very bad strings are in the submitted value, return an empty string:
	foreach ($very_bad as $v) {
                if (stripos($value, $v) !== false){
                    return '';
                }
	}
	// Replace any newline characters with spaces:
	$value =strip_tags(str_replace(array( "\r", "\n","%0a", "%0d"), ' ', $value)); //strip_tags() will remove all HTML and PHP tags. Safe, but remove if HTML formatting required.
	return trim($value);
}

?>
