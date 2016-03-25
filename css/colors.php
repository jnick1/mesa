<?php

$homedir = "../";

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

$colorids = array(
    1=>"rgb(164, 189, 252)",
    9=>"rgb(84, 132, 237)",
    10=>"rgb(81, 183, 73)",
    11=>"rgb(220, 33, 39)",
    9=>"rgb(73, 134, 231)",
    8=>"rgb(225, 225, 225)",
    2=>"rgb(122, 231, 191)",
    6=>"rgb(255, 184, 120)",
    3=>"rgb(219, 173, 255)",
    4=>"rgb(255, 136, 124)",
    7=>"rgb(70, 214, 219)",
    5=>"rgb(251, 215, 91)"
);

$header = "#ne-evt-color-";
$header2 = ".el-content-event-colorcircle";
$background = " {\n    background-color: ";
$border = ":not(:hover) {\n    border-color: ";
$end = ";\n}\n";

foreach($colors as $name => $color) {
    echo $header.$name.$background.$color.$end;
    echo $header.$name.$border.$color.$end;
}

foreach($colorids as $id => $color){
    echo $header2.$id.$background.$color.$end;
}