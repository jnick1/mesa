<?php
require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates

function piece_http_request($origin_location, $destination_location){
    $bing_secret = file_get_contents(BING_SECRET_FILE);
    $request_url = "http://dev.virtualearth.net/REST/V1/Routes/Driving?". //Base url
            "wp.0=".urlencode($origin_location). //Filter address to match url-formatting
            "&wp.1=".urlencode($destination_location).
            "&routeAttributes=routeSummariesOnly&output=xml". //Setup XML and only route summaries
            "&key=".$bing_secret;
    return $request_url;
}

function retrieve_travel_time($origin_location, $destination_location){
    $url = piece_http_request($origin_location, $destination_location);
    $headers = get_headers($url, 1); //Check for good response
    if($headers[0] == 'HTTP/1.1 200 OK'){
        $output = file_get_contents($url);
        $response = new SimpleXMLElement($output);
        $travel_time = (integer) $response->ResourceSets->ResourceSet->Resources->Route->TravelDuration;
        return $travel_time;
    } else {
        return 0;
    }
}