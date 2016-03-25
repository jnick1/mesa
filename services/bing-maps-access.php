<?php
define('BING_SECRET_PATH', __DIR__ . '/../bing_secret.txt');
$_SESSION['bing-secret'] = readfile(BING_SECRET_PATH)[0];

function piece_http_request($origin_location, $destination_location){
    $request_url = "http://dev.virtualearth.net/REST/V1/Routes/Driving?". //Base url
            "wp.0=".urlencode($origin_location). //Filter address to match url-formatting
            "&wp.1=".urlencode($destination_location).
            "&routeAttributes=routeSummariesOnly&output=xml". //Setup XML and only route summaries
            "&key=".$_SESSION['bing-secret']; //Setup Bing key
    return $request_url;
}

function retrieve_travel_time($origin_location, $destination_location){
    $url = piece_http_request($origin_location, $destination_location);
    $output = file_get_contents($url);
    $response = new SimpleXMLElement($output);
    $travel_time = $response->ResourceSets->ResourceSet->Resources->Route->TravelDuration;
    return $travel_time;
}