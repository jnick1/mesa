<?php

//====================================//
//========|   Event Colors   |========//
//====================================//

//this php document is used to generate css code for all of the event colors on the newevent.php page
//this is simply done by making the browser think that this is not, in fact, a php page, but rather a css page

header("Content-type: text/css; charset: UTF-8");

$colors = array(
    "blue"=>"rgb(164, 189, 252)",
    "boldblue"=>"rgb(84, 132, 237)",
    "boldgreen"=>"rgb(81, 183, 73)",
    "boldred"=>"rgb(220, 33, 39)",
    "default"=>"rgb(73, 134, 231)",
    "gray"=>"rgb(225, 225, 225)",
    "green"=>"rgb(122, 231, 191)",
    "orange"=>"rgb(255, 184, 120)",
    "purple"=>"rgb(219, 173, 255)",
    "red"=>"rgb(255, 136, 124)",
    "turquoise"=>"rgb(70, 214, 219)",
    "yellow"=>"rgb(251, 215, 91)"
);

$header = "#ne-evt-color-";
$background = " {\n    background-color: ";
$border = ":not(:hover) {\n    border-color: ";
$end = ";\n}\n";

foreach($colors as $name => $color) {
    echo $header.$name.$background.$color.$end;
    echo $header.$name.$border.$color.$end;
}

?>