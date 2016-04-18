<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$homedir = "../";
require_once $homedir."config/mysqli_connect.php";
$ti = 1;

//these should get their values from a failed attempt at a POST request
$errors = [];
$warnings = [];
$notifications = [];

$scrubbed = array_map("spam_scrubber", $_POST);
include $homedir."includes/protocols/signout.php";
include $homedir."includes/protocols/deleteaccount.php";

if(empty($_SESSION["pkUserid"])){
    header("location: $homedir"."index.php");
}

include $homedir."includes/protocols/changeemail.php";
include $homedir."includes/protocols/changepassword.php";

include $homedir."includes/protocols/editevent.php";
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="<?php echo $homedir;?>favicon.png" sizes="128x128">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/colors.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/datepicker.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/details.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ne.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ne-evt.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.structure.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.theme.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
        <script type="text/javascript" src="<?php echo $homedir."java/ne-accordion.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-buttons.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-colors-selector.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-guest.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-notifications-sizechange.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-repeat.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-settings.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-textarea-resize.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-time.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-ui-placeholder.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ne-visibility.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant: New Event</title>
    </head>
    <body>
        <div id="wpg"<?php echo ((isset($scrubbed["editevent"]) && isset($scrubbed["pkEventid"]))?" data-eventid=\"".$scrubbed["pkEventid"]."\"":""); ?><?php echo ((isset($scrubbed["editevent"]) && isset($blOptiSuggestion))?" data-optiran=\"true\"":""); ?>>
            <div id="ne-header" class="ui-container-section <?php echo "uluru".rand(1,8); ?>">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
                <div id="ne-top-buttons">
                    <div class="wrapper-btn-all wrapper-btn-general">
                        <div id="ne-btn-back" title="Return to previous page"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Back
                        </div>
                    </div>
                    <div class="wrapper-btn-all wrapper-btn-action">
                        <div id="ne-btn-send" title="Send event signup to all guests"<?php echo " tabindex=\"".$ti++."\"";?>>
                            SEND
                        </div>
                    </div>
                    <div id="ne-btn-findtimes-wrapper" class="wrapper-btn-all wrapper-btn-action">
                        <div id="ne-btn-findtimes" title="Run a search for the best available times for all attendees"<?php echo " tabindex=\"".$ti++."\"";?>>
                            FIND TIMES
                        </div>
                    </div>
                    <div class="wrapper-btn-all wrapper-btn-general">
                        <div id="ne-btn-save" title="Save event for later modification"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Save
                        </div>
                    </div>
                </div>
            </div>
            <div id="ne-top-time" class="ui-container-section">
                <div id="ne-top-title">
                    <input id="ne-evt-title" name="ne-evt-title" class="ui-textinput ui-placeholder" title="Event title" type="text" placeholder="Untitled event"<?php echo " tabindex=\"".$ti++."\"";?><?php echo (isset($nmTitle))?" value=\"$nmTitle\"":""; ?>>
                </div>
                <div id="ne-top-timegroup">
                    <span id="ne-top-time-startgroup">
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-date-start" name="ne-evt-date-start" class="ui-textinput ui-date" title="From date"<?php echo (isset($dtStart))?" value=\"".substr($dtStart,5,2)."/".substr($dtStart,8,2)."/".substr($dtStart,0,4)."\"":""; ?><?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-time-start" name="ne-evt-time-start" class="ui-textinput ui-time ne-top-time" title="From time" data-jq-dropdown="#ne-dropdown-timestart"<?php echo (isset($dtStart))?" value=\"".substr($dtStart,11,5)."\"":""; ?><?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                    </span>
                    <span id="ne-top-time-to">
                        to
                    </span>
                    <span id="ne-top-time-endgroup">
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-time-end" name="ne-evt-time-end" class="ui-textinput ui-time ne-top-time" title="To time" data-jq-dropdown="#ne-dropdown-timeend"<?php echo (isset($dtEnd))?" value=\"".substr($dtEnd,11,5)."\"":""; ?><?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-date-end" name="ne-evt-date-end" class="ui-textinput ui-date" title="To date"<?php echo (isset($dtEnd))?" value=\"".substr($dtEnd,5,2)."/".substr($dtEnd,8,2)."/".substr($dtEnd,0,4)."\"":""; ?><?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                    </span>
                </div>
                <div id="ne-top-repeat">
                    <?php
                    $settings = "";
                    if(isset($scrubbed["pkEventid"])) { 
                        $settings = json_decode($blSettings,true); 
                    }
                    ?>
                    <span id="ne-settings-top-wrapper">
                        <input id="ne-evt-settingsbox" name="ne-evt-settingsbox" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo $settings["useDefault"]?"":" checked"; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                        <label id="ne-label-settingsbox" class="ne-label" for="ne-evt-settingsbox">
                            <?php if(isset($scrubbed["pkEventid"])) {  echo $settings["useDefault"]?"Advanced settings":"Advanced settings:"; } else { echo "Advanced settings"; }?>
                        </label>
                    </span>
                    <span id="ne-settings-display" class="ui-header<?php if(isset($scrubbed["pkEventid"])) {  echo $settings["useDefault"]?" wpg-nodisplay":""; } else { echo " wpg-nodisplay"; }?>">Active</span>
                    <span id="ne-settings-edit" class="ui-revisitablelink<?php if(isset($scrubbed["pkEventid"])) { echo $settings["useDefault"]?" wpg-nodisplay":""; } else { echo " wpg-nodisplay"; }?>">Edit</span>
                    <span id="ne-repeat-top-wrapper">
                        <input id="ne-evt-repeatbox" name="ne-evt-repeatbox" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { if($txRRule!=""){ echo " checked"; } } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                        <label id="ne-label-repeatbox" class="ne-label" for="ne-evt-repeatbox">
                            <?php if(isset($scrubbed["pkEventid"])) { if($txRRule!=""){ echo "Repeat: "; } else { echo "Repeat..."; } } else { ?>Repeat...<?php } ?>
                        </label>
                    </span>
                    <span id="ne-repeat-summary-display" class="ui-header<?php if(isset($scrubbed["pkEventid"])) { if($txRRule==""){ echo " wpg-nodisplay"; } } else { echo " wpg-nodisplay"; }?>"><?php if(isset($scrubbed["pkEventid"])) { echo $txRRule; } else { echo "Daily"; }?></span>
                    <span id="ne-repeat-edit" class="ui-revisitablelink<?php if(isset($scrubbed["pkEventid"])) { if($txRRule==""){ echo " wpg-nodisplay"; } } else { echo " wpg-nodisplay"; }?>">Edit</span>
                </div>
            </div>
            <div id="ne-container-details" class="ui-container-section">
                <div id="ne-container-guests">
                    <div id="ne-guests">
                        <div class="ne-guests-container">
                            <div class="ui-header">
                                Add guests
                            </div>
                            <div>
                                <div class="ui-container-inline">
                                    <input id="ne-guests-emailinput" class="ui-textinput" placeholder="Enter guest email addresses" title="Enter guest email addresses"<?php echo " tabindex=\"".$ti++."\"";?>>
                                </div>
                                <div id="ne-guests-addbutton-wrapper" class="wrapper-btn-all wrapper-btn-general ui-container-inline">
                                    <div id="ne-guests-addbutton"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Add
                                    </div>
                                </div>
                                <div id="ne-guests-guestaddedtext" class="ui-container-inline ui-unselectabletext">
                                    Guest added
                                </div>
                            </div>
                            <div class="ui-separator"></div>
                        </div>
                        <div id="ne-guests-container-list" class="ne-guests-container">
                            <div id="ne-guests-legend" class="ui-smallfont">
                                Click the <div class="goog-icon goog-icon-guest-required ui-container-inline"></div> icons below to mark as optional.
                            </div>
                            <div id="ne-guests-list">
                                <div id="ne-guests-header" class="ui-header">
                                    Guests
                                    <div id="ne-btn-email" class="ui-container-inline" title="Send calendar access request to all guests">
                                        <div class="ui-container-inline goog-icon goog-icon-gmail"></div>
                                        <span class="ui-smallfont">
                                            Send calendar request
                                        </span>
                                    </div>
                                </div>
                                <div id="ne-guests-repsonses" class="ui-smallfont">
                                    <?php
                                    if(!empty($dtRequestSent)){
                                        $guestsYes = 0;
                                        $guestsMaybe = 0;
                                        $guestsNo = 0;
                                        $guestsWaiting = 0;
                                        
                                        $attendees = json_decode($blAttendees, true);
                                        foreach($attendees as $value){
                                            switch($value["responseStatus"]){
                                                case "needsAction":
                                                    if(time() - strtotime($dtStart)>=0) {
                                                        $guestsNo++;
                                                    } else {
                                                        $guestsWaiting++;
                                                    }
                                                    break;
                                                case "declined":
                                                    $guestsNo++;
                                                    break;
                                                case "tentative":
                                                    $guestsMaybe++;
                                                    break;
                                                case "accepted":
                                                    $guestsYes++;
                                                    break;
                                            }
                                        }
                                        
                                        echo "Yes: $guestsYes, Maybe: $guestsMaybe, No: $guestsNo, Awaiting: $guestsWaiting";
                                    }
                                    ?>
                                </div>
                                <div id="ne-guests-table">
                                    <div id="ne-guests-table-body">
                                        <?php if(!isset($scrubbed["pkEventid"])) { ?>
                                        <div id="<?php echo $_SESSION["email"] ?>" class="ne-evt-guest" data-required="true" title="<?php echo $_SESSION["email"] ?>">
                                            <div class="ne-guests-guestdata">
                                                <div class="ne-guests-guestdata-content ui-container-inline">
                                                    <span class="goog-icon goog-icon-guest-required ui-container-inline ne-guest-required" title="Click to mark this attendee as optional"></span>
                                                    <div class="ui-container-inline ne-guest-response-icon-wrapper">
                                                        <div class="ne-guest-response-icon"></div>
                                                    </div>
                                                    <div id="<?php echo $_SESSION["email"] ?>@display" class="ne-guest-name-wrapper ui-container-inline">
                                                        <span class="ne-guest-name ui-unselectabletext"><?php echo $_SESSION["email"] ?></span>
                                                    </div>
                                                    <div class="ui-container-inline ne-guest-delete">
                                                        <div class="goog-icon goog-icon-x-small" title="Remove this guest from the event"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else {
                                            $attendees = json_decode($blAttendees, true);
                                            foreach($attendees as $value){
                                            ?>
                                        <div id="<?php echo $value["email"]; ?>" class="ne-evt-guest" data-required="<?php echo !$value["optional"]?"true":"false"; ?>" data-responseStatus="<?php echo $value["responseStatus"]; ?>" title="<?php echo $value["email"]; ?>">
                                            <div class="ne-guests-guestdata">
                                                <div class="ne-guests-guestdata-content ui-container-inline">
                                                    <span class="goog-icon <?php echo ($value["optional"]?"goog-icon-guest-optional":"goog-icon-guest-required");?> ui-container-inline ne-guest-required" title="Click to mark this attendee as optional"></span>
                                                    <div class="ui-container-inline ne-guest-response-icon-wrapper">
                                                        <div class="ne-guest-response-icon goog-icon
                                                            <?php 
                                                            if($dtRequestSent!==NULL){
                                                            switch($value["responseStatus"]) {
                                                                case "needsAction":
                                                                    echo " goog-icon-guest-maybe"; 
                                                                    break;
                                                                case "accepted":
                                                                    echo " goog-icon-guest-yes"; 
                                                                    break;
                                                                case "declined":
                                                                    echo " goog-icon-guest-no"; 
                                                                    break;
                                                                case "tentative":
                                                                    echo " goog-icon-guest-maybe";
                                                                    break;
                                                            }
                                                            ?>" title="<?php 
                                                            switch($value["responseStatus"]) {
                                                                case "needsAction":
                                                                    echo "This guest has not yet responded"; 
                                                                    break;
                                                                case "accepted":
                                                                    echo "This guest has responded"; 
                                                                    break;
                                                                case "declined":
                                                                    echo "This guest has declined to attend"; 
                                                                    break;
                                                                case "tentative":
                                                                    echo "This guest has indicated they may attend";
                                                                    break;
                                                            }
                                                            } else {
                                                                echo "\"";
                                                            }?>">
                                                        </div>
                                                    </div>
                                                    <div id="<?php echo $value["email"] ?>@display" class="ne-guest-name-wrapper ui-container-inline">
                                                        <span class="ne-guest-name ui-unselectabletext"><?php echo $value["email"] ?></span>
                                                    </div>
                                                    <div class="ui-container-inline ne-guest-delete">
                                                        <div class="goog-icon goog-icon-x-small" title="Remove this guest from the event"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="ui-separator"></div>
                        </div>
                        <div class="ne-guests-container">
                            <div class="ui-header">
                                Guests can
                            </div>
                            <div>
                                <label class="ne-guests-container-checkbox ui-unselectabletext">
                                    <input id="ne-evt-guests-seeguestlist" name="guestsettings" value="seeguestlist" type="checkbox" class="ui-checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo ($isGuestList==1?" checked":""); } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                    see guest list
                                </label>
                            </div>
                            <div id="ne-guests-invitewarning" class="ui-smallfont">
                                Guests may be able to view the guest list if changes to this event are made via a 3rd-party client. 
                                <a href="https://support.google.com/calendar/bin/answer.py?answer=3046349&amp;hl=en" class="ui-revisitablelink" target="_blank">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ne-details">
                    <table class="ui-table">
                        <tbody>
                            <tr>
                                <th>
                                    Where
                                </th>
                                <td>
                                    <input id="ne-evt-where" name="ne-evt-where"class="ui-textinput" placeholder="Enter a location"<?php echo " tabindex=\"".$ti++."\"";?><?php echo (isset($txLocation))?" value=\"".$txLocation."\"":""; ?>>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Description
                                </th>
                                <td>
                                    <textarea id="ne-evt-description" name="ne-evt-description" class="ui-textinput" rows="3"<?php echo " tabindex=\"".$ti++."\"";?>><?php echo (isset($txDescription))?$txDescription:""; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="ui-separator"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Event color
                                </th>
                                <td>
                                    <div id="ne-evt-color-default" name="ne-evt-color-default" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==0)?" details-eventcolors-selected":""; } else { echo " details-eventcolors-selected"; }?>" title="default"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==0) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } } else {?> <div class="goog-icon goog-icon-colors-checkmark-white"></div> <?php } ?></div>
                                    <div id="details-color-separator"></div>
                                    <div id="ne-evt-color-boldblue" name="ne-evt-color-boldblue" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==9)?" details-eventcolors-selected":""; } ?>" title="bold blue"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==9) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-blue" name="ne-evt-color-blue" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==1)?" details-eventcolors-selected":""; } ?>" title="blue"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==1) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-turquoise" name="ne-evt-color-turquoise" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==7)?" details-eventcolors-selected":""; } ?>" title="turquoise"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==7) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-green" name="ne-evt-color-green" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==2)?" details-eventcolors-selected":""; } ?>" title="green"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==2) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-boldgreen" name="ne-evt-color-boldgreen" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==10)?" details-eventcolors-selected":""; } ?>" title="boldgreen"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==10) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-yellow" name="ne-evt-color-yellow" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==5)?" details-eventcolors-selected":""; } ?>" title="yellow"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==5) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-orange" name="ne-evt-color-orange" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==6)?" details-eventcolors-selected":""; } ?>" title="orange"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==6) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-red" name="ne-evt-color-red" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==4)?" details-eventcolors-selected":""; } ?>" title="red"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==4) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-boldred" name="ne-evt-color-boldred" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==11)?" details-eventcolors-selected":""; } ?>" title="boldred"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==11) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-purple" name="ne-evt-color-purple" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==3)?" details-eventcolors-selected":""; } ?>" title="purple"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==3) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                    <div id="ne-evt-color-gray" name="ne-evt-color-gray" class="details-eventcolors<?php if(isset($scrubbed["pkEventid"])) { echo ($nColorid==8)?" details-eventcolors-selected":""; } ?>" title="gray"><?php if(isset($scrubbed["pkEventid"])) { if($nColorid==8) { ?><div class="goog-icon goog-icon-colors-checkmark-white"></div><?php } }?></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Notifications
                                </th>
                                <td>
                                    <div id="wrapper-notifications">
                                        <?php 
                                        $noNotifs = "";
                                        if(empty($scrubbed["pkEventid"])) {
                                            $noNotifs = " class=\"wpg-nodisplay\"";
                                        } else {
                                            $temp  = json_decode($blNotifications, true);
                                            if(count($temp["overrides"])>0){
                                                $noNotifs = " class=\"wpg-nodisplay\"";
                                            }
                                        }
                                        ?>
                                        <div id="details-notifications-none"<?php echo $noNotifs; ?>>
                                            No notifications set
                                        </div>
                                        <?php
                                        if(empty($scrubbed["pkEventid"])) {
                                        ?>
                                        <div id="details-notifications-1" class="details-notifications">
                                            <select id="ne-evt-notifications-1" name="ne-evt-notifications-1" class="ui-select" title="Notification type">
                                                <option value="popup">Pop-up</option>
                                                <option value="email">Email</option>
                                            </select>
                                            <input id="ne-evt-notifications-time-1" name="ne-evt-notifications-time-1" class="details-notifications-remindertime ui-textinput" value="30" title="Reminder time">
                                            <select id="ne-evt-notifications-timetype-1" name="ne-evt-notifications-timetype-1" class="ui-select" title="Reminder time">
                                                <option value="1">minutes</option>
                                                <option value="60">hours</option>
                                                <option value="1440">days</option>
                                                <option value="10080">weeks</option>
                                            </select>
                                            <div id="details-notifications-x-1" class="details-notifications-x goog-icon goog-icon-x-small" title="Remove notification"></div>
                                        </div>
                                        <?php } else { 
                                            $notifs = json_decode($blNotifications,true);
                                            foreach ($notifs["overrides"] as $key => $value) {
                                                $time = (int) $value["minutes"];
                                                $increment = ($time%10080==0?"weeks":($time%1440==0?"days":($time%60==0?"hours":"minutes")));
                                                $minutes = ($time%10080==0?$time/10080:($time%1440==0?$time/1440:($time%60==0?$time/60:$time)));
                                            ?>
                                        <div id="details-notifications-<?php echo $key+1; ?>" class="details-notifications">
                                            <select id="ne-evt-notifications-<?php echo $key+1; ?>" name="ne-evt-notifications-<?php echo $key+1; ?>" class="ui-select" title="Notification type">
                                                <option value="popup"<?php if($value["method"]=="popup") { echo " selected"; } ?>>Pop-up</option>
                                                <option value="email"<?php if($value["method"]=="email") { echo " selected"; } ?>>Email</option>
                                            </select>
                                            <input id="ne-evt-notifications-time-<?php echo $key+1; ?>" name="ne-evt-notifications-time-<?php echo $key+1; ?>" class="details-notifications-remindertime ui-textinput" value="<?php echo $minutes; ?>" title="Reminder time">
                                            <select id="ne-evt-notifications-timetype-<?php echo $key+1; ?>" name="ne-evt-notifications-timetype-<?php echo $key+1; ?>" class="ui-select" title="Reminder time">
                                                <option value="1"<?php if($increment=="minutes") { echo " selected"; } ?>>minutes</option>
                                                <option value="60"<?php if($increment=="hours") { echo " selected"; } ?>>hours</option>
                                                <option value="1440"<?php if($increment=="days") { echo " selected"; } ?>>days</option>
                                                <option value="10080"<?php if($increment=="weeks") { echo " selected"; } ?>>weeks</option>
                                            </select>
                                            <div id="details-notifications-x-<?php echo $key+1; ?>" class="details-notifications-x goog-icon goog-icon-x-small" title="Remove notification"></div>
                                        </div>
                                        <?php 
                                            }
                                        } ?>
                                    </div>
                                    <?php 
                                        $noNotifsAdd = "";
                                        if(!empty($scrubbed["pkEventid"])) {
                                            $temp  = json_decode($blNotifications, true);
                                            if(count($temp["overrides"])==5){
                                                $noNotifsAdd = " class=\"wpg-nodisplay\"";
                                            }
                                        }
                                        ?>
                                    <div id="details-notifications-add"<?php echo $noNotifsAdd ?>>
                                        <span id="details-notifications-addlink" class="ui-revisitablelink" <?php echo " tabindex=\"".$ti++."\"";?>>Add a notification</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="ui-separator"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Show me as
                                </th>
                                <td>
                                    <label for="ne-evt-available" >
                                        <input id="ne-evt-available" class="ui-radiobtn" type="radio" name="ne-evt-availability" value="available"<?php if(isset($scrubbed["pkEventid"])) { echo ($isBusy==0?" checked":""); } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                        Available
                                    </label>
                                    <label for="ne-evt-busy" >
                                        <input id="ne-evt-busy" class="ui-radiobtn" type="radio" name="ne-evt-availability" value="busy"<?php if(isset($scrubbed["pkEventid"])) { echo ($isBusy==1?" checked":""); } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                        Busy
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Visibility
                                </th>
                                <td>
                                    <label for="ne-evt-visibility-default" >
                                        <input id="ne-evt-visibility-default" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="default"<?php if(isset($scrubbed["pkEventid"])) { echo ($enVisibility=="default"?" checked":""); } else { echo "checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                        Calendar Default
                                    </label>
                                    <label for="ne-evt-visibility-public" >
                                        <input id="ne-evt-visibility-public" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="public"<?php if(isset($scrubbed["pkEventid"])) { echo ($enVisibility=="public"?" checked":""); } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                        Public
                                    </label>
                                    <label for="ne-evt-visibility-private" >
                                        <input id="ne-evt-visibility-private" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="private"<?php if(isset($scrubbed["pkEventid"])) { echo ($enVisibility=="private"?" checked":""); } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                        Private
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <div class="ui-smallfont">
                                        <span id="details-visibility-info-default"<?php if(isset($scrubbed["pkEventid"])) { echo ($enVisibility!="default"?" class=\"wpg-nodisplay\"":""); } ?>>
                                            By default this event will follow the <span id="goog-sharing-settings" class="ui-revisitablelink">sharing settings</span> of this calendar: event details will be visible to anyone who can see details of other events in this calendar.
                                        </span>
                                        <span id="details-visibility-info-public"<?php if(isset($scrubbed["pkEventid"])) { echo ($enVisibility!="public"?" class=\"wpg-nodisplay\"":""); } else { echo " class=\"wpg-nodisplay\""; } ?>>
                                            Making this event public will expose all event details to anyone who has access to this calendar, even if they can't see details of other events.
                                        </span>
                                        <span id="details-visibility-info-private"<?php if(isset($scrubbed["pkEventid"])) { echo ($enVisibility!="private"?" class=\"wpg-nodisplay\"":""); } else { echo " class=\"wpg-nodisplay\""; } ?>>
                                            Making this event private will hide all event details from anyone who has access to this calendar, unless they have "Make changes to events" level of access or higher.
                                        </span>
                                        <a href="https://support.google.com/calendar?p=event_visibility&amp;hl=en" class="ui-revisitablelink" target="_blank">Learn more</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            include $homedir."includes/pageassembly/footer.php";
            ?>
        </div>
        <div id="ne-dropdown-timestart" class="jq-dropdown jq-dropdown-scroll">
            <div class="jq-dropdown-panel">
                <?php
                for($i=0;$i<48;$i++){
                    $time = date("g:ia", strtotime((floor($i/2)).":".(($i%2)*30)));
                    echo "<div class=\"ui-dropdown-item ne-dropdown-timestart-item\">".$time."</div>";
                }
                ?>
            </div>
        </div>
        <div id="ne-dropdown-timeend" class="jq-dropdown jq-dropdown-scroll">
            <div id="ne-dropdown-timeend-panel" class="jq-dropdown-panel">
                <?php //using javascript to fill in here based on current value in #ne-evt-time-start ?>
            </div>
        </div>
        <div id="ne-repeat-wrapper" class="ui-popup">
            <div id="ne-repeat-dialogbox" class="ui-dialogbox">
                <div id="ne-repeat-header">
                    <span class="ui-header">Repeat</span>
                    <span id="ne-repeat-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                </div>
                <div id="ne-repeat-table-wrapper">
                    <table class="ui-table">
                        <tbody>
                            <tr id="ne-repeat-table-0">
                                <th>
                                    Repeats:
                                </th>
                                <td>
                                    <select id="ne-evt-repeat-repeats" name="ne-evt-repeat-repeats" class="ui-select"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <option value="0">Daily</option>
                                        <option value="1">Every weekday (Monday to Friday)</option>
                                        <option value="2">Every Monday, Wednesday, and Friday</option>
                                        <option value="3">Every Tuesday and Thursday</option>
                                        <option value="4">Weekly</option>
                                        <option value="5">Monthly</option>
                                        <option value="6">Yearly</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-1">
                                <th>
                                    Repeat every:
                                </th>
                                <td>
                                    <select id="ne-evt-repeat-repeatevery" name="ne-evt-repeat-repeatevery" class="ui-select"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <?php
                                        for($i=1;$i<=30;$i++){
                                            echo "<option value=\"$i\">$i</option>\n";
                                        }
                                        ?>
                                    </select>
                                    <span id="ne-label-repeat-repeatevery">
                                        <?php if(empty($scrubbed["pkEventid"])) { echo "days"; } ?>
                                    </span>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-2"<?php if(empty($scrubbed["pkEventid"])){ ?> class="wpg-nodisplay"<?php } ?>>
                                <th>
                                    Repeats on:
                                </th>
                                <td>
                                    <div>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-0" class="ne-label-repeat-repeatson" title="Sunday">
                                                <input id="ne-evt-repeat-repeatson-0" name="ne-evt-repeat-repeatson-0" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Sunday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                S
                                            </label>
                                        </span>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-1" class="ne-label-repeat-repeatson" title="Monday">
                                                <input id="ne-evt-repeat-repeatson-1" name="ne-evt-repeat-repeatson-1" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Monday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                M
                                            </label>
                                        </span>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-2" class="ne-label-repeat-repeatson" title="Tuesday">
                                                <input id="ne-evt-repeat-repeatson-2" name="ne-evt-repeat-repeatson-2" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Tuesday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                T
                                            </label>
                                        </span>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-3" class="ne-label-repeat-repeatson" title="Wednesday">
                                                <input id="ne-evt-repeat-repeatson-3" name="ne-evt-repeat-repeatson-3" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Wednesday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                W
                                            </label>
                                        </span>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-4" class="ne-label-repeat-repeatson" title="Thursday">
                                                <input id="ne-evt-repeat-repeatson-4" name="ne-evt-repeat-repeatson-4" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Thursday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                T
                                            </label>
                                        </span>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-5" class="ne-label-repeat-repeatson" title="Friday">
                                                <input id="ne-evt-repeat-repeatson-5" name="ne-evt-repeat-repeatson-5" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Friday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                F
                                            </label>
                                        </span>
                                        <span class="ui-container-inline">
                                            <label for="ne-evt-repeat-repeatson-6" class="ne-label-repeat-repeatson" title="Saturday">
                                                <input id="ne-evt-repeat-repeatson-6" name="ne-evt-repeat-repeatson-6" class="ui-checkbox ne-repeat-repeatson-checkbox" title="Saturday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                S
                                            </label>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-3"<?php if(empty($scrubbed["pkEventid"])){ ?> class="wpg-nodisplay"<?php } ?>>
                                <th>
                                    Repeat by:
                                </th>
                                <td>
                                    <span>
                                        <label for="ne-evt-repeat-repeatby-dayofmonth" title="Repeat by day of the month">
                                            <input id="ne-evt-repeat-repeatby-dayofmonth" name="ne-evt-repeat-repeatby" title="Repeat by day of the month" type="radio"<?php if(empty($scrubbed["pkEventid"])){ echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                            day of the month
                                        </label>
                                    </span>
                                    <span>
                                        <label for="ne-evt-repeat-repeatby-dayofweek" title="Repeat by day of the week">
                                            <input id="ne-evt-repeat-repeatby-dayofweek" name="ne-evt-repeat-repeatby" title="Repeat by day of the week" type="radio"<?php echo " tabindex=\"".$ti++."\"";?>>
                                            day of the week
                                        </label>
                                    </span>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-4">
                                <th>
                                    Starts on:
                                </th>
                                <td>
                                    <input id="ne-evt-repeat-startson" name="ne-evt-repeat-startson" class="" type="text" disabled<?php echo " tabindex=\"".$ti++."\"";?>>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-5">
                                <th>
                                    Ends:
                                </th>
                                <td>
                                    <span class="ui-container-block">
                                        <label for="ne-evt-endson-never" title="Ends never">
                                            <input id="ne-evt-endson-never" name="ne-evt-endson" title="Ends never" type="radio"<?php if(empty($scrubbed["pkEventid"])){ echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                            Never
                                        </label>
                                    </span>
                                    <span class="ui-container-block">
                                        <input id="ne-evt-endson-after" name="ne-evt-endson" title="Ends after a number of occurrences" type="radio"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <label for="ne-evt-endson-after" title="Ends after a number of occurrences">
                                            After 
                                            <input id="ne-evt-endson-occurances" name="ne-evt-endson-occurances" class="ui-textinput" size="3" title="Occurrences"<?php if(empty($scrubbed["pkEventid"])){ echo " disabled"; } ?><?php echo " tabindex=\"".$ti++."\"";?>> 
                                            occurrences
                                        </label>
                                    </span>
                                    <span class="ui-container-block">
                                        <input id="ne-evt-endson-on" name="ne-evt-endson" title="Ends on a specified date" type="radio"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <label for="ne-evt-endson-on" title="Ends on a specified date">
                                            On 
                                            <input id="ne-evt-endson-date" name="ne-evt-endson-date" class="ui-textinput" size="10" title="Specified date"<?php if(empty($scrubbed["pkEventid"])){ echo " disabled"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                        </label>
                                    </span>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-6">
                                <th>
                                    Summary:
                                </th>
                                <td id="ne-repeat-summary" class="ui-header">
                                    Daily
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="ne-repeat-btns">
                    <div class="wrapper-btn-general wrapper-btn-all">
                        <div id="ne-repeat-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Done
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all">
                        <div id="ne-repeat-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ne-settings-wrapper" class="ui-popup">
            <div id="ne-settings-dialogbox" class="ui-dialogbox">
                <div id="ne-settings-header">
                    <span class="ui-header">Advanced settings</span>
                    <span id="ne-settings-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                    <div id="ne-settings-usedefault-wrapper" title="Uncheck to enable custom settings">
                        <label id="ne-label-settings-usedefault" for="ne-evt-settings-usedefault">
                            <input id="ne-evt-settings-usedefault" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo $settings["useDefault"]?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                            Use default settings
                        </label>
                    </div>
                </div>
                <div id="ne-settings-table-wrapper">
                    <table id="ne-settings-supertable">
                        <tbody>
                            <tr>
                                <td>
                                    <table class="ui-table">
                                        <tbody>
                                            <tr id="ne-settings-table-0">
                                                <th>
                                                    Time of day
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-timegate" class="ui-label" for="ne-evt-settings-timegate">
                                                        <input id="ne-evt-settings-timegate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["time"])?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom time settings
                                                    </label>
                                                    <table id="ne-settings-time-table"<?php if(empty($settings["time"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-time-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-timeallow" for="ne-evt-settings-timeallow">
                                                                        <input id="ne-evt-settings-timeallow" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["time"])) { echo $settings["time"]["timeallow"]?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow time modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-time-table-1"<?php if(!empty($settings["time"]) && empty($settings["time"]["timeallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-time-prior-low" >
                                                                            <input id="ne-evt-settings-time-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-time-prior" value="1"<?php if(!empty($settings["time"])) { echo $settings["time"]["prioritization"]==1?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-time-prior-med" >
                                                                            <input id="ne-evt-settings-time-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-time-prior" value="10"<?php if(!empty($settings["time"])) { echo $settings["time"]["prioritization"]==10?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-time-prior-hig" >
                                                                            <input id="ne-evt-settings-time-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-time-prior" value="100"<?php if(!empty($settings["time"])) { echo $settings["time"]["prioritization"]==100?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="ne-settings-table-1">
                                                <th>
                                                    Date
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-daygate" for="ne-evt-settings-daygate">
                                                        <input id="ne-evt-settings-daygate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["date"])?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom day settings
                                                    </label>
                                                    <table id="ne-settings-day-table"<?php if(empty($settings["date"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-day-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-dayallow" for="ne-evt-settings-dayallow">
                                                                        <input id="ne-evt-settings-dayallow" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["date"])) { echo $settings["date"]["dateallow"]?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow day modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-day-table-1"<?php if(!empty($settings["date"]) && empty($settings["date"]["dateallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-date-prior-low" >
                                                                            <input id="ne-evt-settings-date-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-date-prior" value="1"<?php if(!empty($settings["date"])) { echo $settings["date"]["prioritization"]==1?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-date-prior-med" >
                                                                            <input id="ne-evt-settings-date-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-date-prior" value="10"<?php if(!empty($settings["date"])) { echo $settings["date"]["prioritization"]==10?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-date-prior-hig" >
                                                                            <input id="ne-evt-settings-date-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-date-prior" value="100"<?php if(!empty($settings["date"])) { echo $settings["date"]["prioritization"]==100?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-day-table-2"<?php if(!empty($settings["date"]) && empty($settings["date"]["dateallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    <label id="ne-label-settings-maxdate" for="ne-evt-settings-maxdate">
                                                                        Furthest search date
                                                                        <input id="ne-evt-settings-maxdate" class="ui-date ui-textinput"<?php if(!empty($settings["date"])) { echo " data-date=\"".(substr($settings["date"]["furthest"],5,2)."/".substr($settings["date"]["furthest"],8,2)."/".substr($settings["date"]["furthest"],0,4))."\""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table class="ui-table">
                                        <tbody>
                                            <tr id="ne-settings-table-2">
                                                <th>
                                                    Meeting Duration
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-durationgate" for="ne-evt-settings-durationgate">
                                                        <input id="ne-evt-settings-durationgate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["duration"])?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom duration settings
                                                    </label>
                                                    <table id="ne-settings-duration-table"<?php if(empty($settings["duration"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-duration-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-durationallow" for="ne-evt-settings-durationallow">
                                                                        <input id="ne-evt-settings-durationallow" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["duration"])) { echo $settings["duration"]["durationallow"]?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow duration modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-duration-table-1"<?php if(!empty($settings["duration"]) && empty($settings["duration"]["durationallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-duration-prior-low" >
                                                                            <input id="ne-evt-settings-duration-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-duration-prior" value="1"<?php if(!empty($settings["duration"])) { echo $settings["duration"]["prioritization"]==1?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-duration-prior-med" >
                                                                            <input id="ne-evt-settings-duration-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-duration-prior" value="10"<?php if(!empty($settings["duration"])) { echo $settings["duration"]["prioritization"]==10?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-duration-prior-hig" >
                                                                            <input id="ne-evt-settings-duration-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-duration-prior" value="100"<?php if(!empty($settings["duration"])) { echo $settings["duration"]["prioritization"]==100?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-duration-table-2"<?php if(!empty($settings["duration"]) && empty($settings["duration"]["durationallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    <label id="ne-label-settings-minduration" for="ne-evt-settings-minduration">
                                                                        Minimum duration
                                                                        <input id="ne-evt-settings-minduration" class="ui-textinput ui-time"<?php if(!empty($settings["duration"])) { echo " value=\"".substr($settings["duration"]["minduration"],0,5)."\""; } else { echo " value=\"00:30\""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        <span class="ui-smallfont">(hh:mm)</span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="ne-settings-table-3">
                                                <th>
                                                    Repeats
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-repeatgate" for="ne-evt-settings-repeatgate">
                                                        <input id="ne-evt-settings-repeatgate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["repeat"])?" checked":""; }?><?php if(isset($scrubbed["pkEventid"]) && $txRRule=="") { echo " disabled"; } else { echo " disabled"; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom repetition settings
                                                    </label>
                                                    <span id="ne-settings-repetition-annotation" class="ui-container-block ui-smallfont<?php if(isset($scrubbed["pkEventid"]) && $txRRule!="") { echo " wpg-nodisplay"; } ?>">(disabled when repeat is not set)</span>
                                                    <table id="ne-settings-repeats-table"<?php if(empty($settings["repeat"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-repeats-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-repeatsallow" for="ne-evt-settings-repeatsallow">
                                                                        <input id="ne-evt-settings-repeatsallow" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["repeat"])) { echo $settings["repeat"]["repeatallow"]?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow repeats modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-repeats-table-1"<?php if(!empty($settings["repeat"]) && empty($settings["repeat"]["repeatallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-repeats-prior-low" >
                                                                            <input id="ne-evt-settings-repeats-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-repeats-prior" value="1"<?php if(!empty($settings["repeat"])) { echo $settings["repeat"]["prioritization"]==1?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-repeats-prior-med" >
                                                                            <input id="ne-evt-settings-repeats-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-repeats-prior" value="10"<?php if(!empty($settings["repeat"])) { echo $settings["repeat"]["prioritization"]==10?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-repeats-prior-hig" >
                                                                            <input id="ne-evt-settings-repeats-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-repeats-prior" value="100"<?php if(!empty($settings["repeat"])) { echo $settings["repeat"]["prioritization"]==100?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-repeats-table-2"<?php if(!empty($settings["repeat"]) && empty($settings["repeat"]["repeatallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    <label id="ne-label-settings-repeatsmin" for="ne-evt-settings-repeatsmin">
                                                                        Minimum number of repeats
                                                                        <input id="ne-evt-settings-repeatsmin" class="ui-textinput ui-shortbox"<?php if(!empty($settings["repeat"])) { echo " value=\"".$settings["repeat"]["minrepeats"]."\""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-repeats-table-3"<?php if(!empty($settings["repeat"]) && empty($settings["repeat"]["repeatallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    <label id="ne-label-settings-repeatsconstant" for="ne-evt-settings-repeatsconstant">
                                                                        All meetings at same time
                                                                        <input id="ne-evt-settings-repeatsconstant" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["repeat"])) { echo $settings["repeat"]["repeatconstant"]?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="ne-settings-table-4">
                                                <th>
                                                    Blacklist times
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-blacklistgate" for="ne-evt-settings-blacklistgate">
                                                        <input id="ne-evt-settings-blacklistgate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["blacklist"])?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom blacklist settings
                                                    </label>
                                                    <table id="ne-settings-blacklist-table"<?php if(empty($settings["blacklist"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-blacklist-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-blackliststart" for="ne-evt-settings-blackliststart">
                                                                        Earliest start time
                                                                        <input id="ne-evt-settings-blackliststart" class="ui-textinput ui-time"<?php if(!empty($settings["blacklist"])) { echo " value=\"".$settings["blacklist"]["earliest"]."\""; echo " data-start=\"$dtStart\""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-blacklist-table-1">
                                                                <td>
                                                                    <label id="ne-label-settings-blacklistend" for="ne-evt-settings-blacklistend">
                                                                        Latest end time
                                                                        <input id="ne-evt-settings-blacklistend" class="ui-textinput ui-time"<?php if(!empty($settings["blacklist"])) { echo " value=\"".$settings["blacklist"]["latest"]."\""; echo " data-end=\"$dtEnd\""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-blacklist-table-2">
                                                                <td>
                                                                    <span id="ne-label-settings-blacklistdays" class="ui-container-block">
                                                                        Blacklisted days
                                                                    </span>
                                                                    <div>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-0" class="ne-label-settings-blacklistdays" title="Sunday">
                                                                                <input id="ne-evt-settings-blacklistdays-0" name="ne-evt-settings-blacklistdays-0" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Sunday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"SU") || strpos($settings["blacklist"]["days"],"SU")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                S
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-1" class="ne-label-settings-blacklistdays" title="Monday">
                                                                                <input id="ne-evt-settings-blacklistdays-1" name="ne-evt-settings-blacklistdays-1" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Monday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"MO") || strpos($settings["blacklist"]["days"],"MO")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                M
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-2" class="ne-label-settings-blacklistdays" title="Tuesday">
                                                                                <input id="ne-evt-settings-blacklistdays-2" name="ne-evt-settings-blacklistdays-2" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Tuesday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"TU") || strpos($settings["blacklist"]["days"],"TU")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                T
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-3" class="ne-label-settings-blacklistdays" title="Wednesday">
                                                                                <input id="ne-evt-settings-blacklistdays-3" name="ne-evt-settings-blacklistdays-3" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Wednesday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"WE") || strpos($settings["blacklist"]["days"],"WE")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                W
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-4" class="ne-label-settings-blacklistdays" title="Thursday">
                                                                                <input id="ne-evt-settings-blacklistdays-4" name="ne-evt-settings-blacklistdays-4" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Thursday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"TH") || strpos($settings["blacklist"]["days"],"TH")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                T
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-5" class="ne-label-settings-blacklistdays" title="Friday">
                                                                                <input id="ne-evt-settings-blacklistdays-5" name="ne-evt-settings-blacklistdays-5" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Friday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"FR") || strpos($settings["blacklist"]["days"],"FR")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                F
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-6" class="ne-label-settings-blacklistdays" title="Saturday">
                                                                                <input id="ne-evt-settings-blacklistdays-6" name="ne-evt-settings-blacklistdays-6" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Saturday" type="checkbox"<?php if(!empty($settings["blacklist"])) { echo (strpos($settings["blacklist"]["days"],"SA") || strpos($settings["blacklist"]["days"],"SA")===0)?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                S
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table class="ui-table">
                                        <tbody>
                                            <tr id="ne-settings-table-5">
                                                <th>
                                                    Location
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-locationgate" for="ne-evt-settings-locationgate">
                                                        <input id="ne-evt-settings-locationgate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["location"])?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom location settings
                                                    </label>
                                                    <table id="ne-settings-location-table"<?php if(empty($settings["location"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-location-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-locationallow" for="ne-evt-settings-locationallow">
                                                                        <input id="ne-evt-settings-locationallow" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["location"])) { echo $settings["location"]["locationallow"]?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow location modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-location-table-1"<?php if(!empty($settings["location"]) && empty($settings["location"]["locationallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-location-prior-low" >
                                                                            <input id="ne-evt-settings-location-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-location-prior" value="1"<?php if(!empty($settings["location"])) { echo $settings["location"]["prioritization"]==1?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-location-prior-med" >
                                                                            <input id="ne-evt-settings-location-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-location-prior" value="10"<?php if(!empty($settings["location"])) { echo $settings["location"]["prioritization"]==10?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-location-prior-hig" >
                                                                            <input id="ne-evt-settings-location-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-location-prior" value="100"<?php if(!empty($settings["location"])) { echo $settings["location"]["prioritization"]==100?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr id="ne-settings-table-6">
                                                <th>
                                                    Attendees
                                                </th>
                                                <td>
                                                    <label id="ne-label-settings-attendancegate" for="ne-evt-settings-attendancegate">
                                                        <input id="ne-evt-settings-attendancegate" class="ui-checkbox" type="checkbox"<?php if(isset($scrubbed["pkEventid"])) { echo !empty($settings["attendees"])?" checked":""; }?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom attendance settings
                                                    </label>
                                                    <table id="ne-settings-attendees-table"<?php if(empty($settings["attendees"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                        <tbody>
                                                            <tr id="ne-settings-attendees-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-attendeesallow" for="ne-evt-settings-attendeesallow">
                                                                        <input id="ne-evt-settings-attendeesallow" class="ui-checkbox" type="checkbox"<?php if(!empty($settings["attendees"])) { echo $settings["attendees"]["attendeesallow"]?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow attendees modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-attendees-table-1"<?php if(!empty($settings["attendees"]) && empty($settings["attendees"]["attendeesallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-attendees-prior-low" >
                                                                            <input id="ne-evt-settings-attendees-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-attendees-prior" value="1"<?php if(!empty($settings["attendees"])) { echo $settings["attendees"]["prioritization"]==1?" checked":""; } else { echo " checked"; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-attendees-prior-med" >
                                                                            <input id="ne-evt-settings-attendees-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-attendees-prior" value="10"<?php if(!empty($settings["attendees"])) { echo $settings["attendees"]["prioritization"]==10?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-attendees-prior-hig" >
                                                                            <input id="ne-evt-settings-attendees-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-attendees-prior" value="100"<?php if(!empty($settings["attendees"])) { echo $settings["attendees"]["prioritization"]==100?" checked":""; } ?><?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-attendees-table-2"<?php if(!empty($settings["attendees"]) && empty($settings["attendees"]["attendeesallow"])) { echo " class=\"wpg-nodisplay\""; } ?>>
                                                                <td>
                                                                    <label id="ne-label-settings-attendeesnomiss" for="ne-evt-settings-attendeesallow">
                                                                        Minimum required attendees
                                                                        <select id="ne-evt-settings-attendeesnomiss" class="ui-select"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            <?php
                                                                            if(isset($settings["attendees"])) {
                                                                                for($i=1;$i<=count($attendees);$i++){
                                                                                    if($i==$settings["attendees"]["minattendees"]) {
                                                                                        echo "<option value=\"$i\" selected>$i</option>";
                                                                                    } else {
                                                                                        echo "<option value=\"$i\">$i</option>";
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="ne-settings-btns">
                    <div class="wrapper-btn-general wrapper-btn-all">
                        <div id="ne-settings-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Done
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all">
                        <div id="ne-settings-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ne-send-wrapper" class="ui-popup">
            <div id="ne-send-dialogbox" class="ui-dialogbox">
                <div id="ne-send-header">
                    <span class="ui-header">Send event preemptively?</span>
                    <span id="ne-send-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                </div>
                <div id="ne-send-content-wrapper">
                    <p>Are you sure you want to send out this event to your attendees?</p>
                    <p>You have not run a search for optimal times yet.</p>
                </div>
                <div id="ne-send-btns">
                    <div class="wrapper-btn-general wrapper-btn-all ne-btns-popups">
                        <div id="ne-send-btn-yes" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Yes
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all ne-btns-popups">
                        <div id="ne-send-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ne-opti-wrapper" class="ui-popup">
            <div id="ne-opti-dialogbox" class="ui-dialogbox">
                <div id="ne-opti-header">
                    <span class="ui-header">Event optimization</span>
                    <span id="ne-opti-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                </div>
                <div id="ne-opti-content-wrapper">
                    <?php  
                    if(isset($scrubbed["pkEventid"])) {
                        if(isset($dtRequestSent)) {
                            if(isset($blOptiSuggestion)) { ?>
                    <div id="ne-opti-table-wrapper">
                        <table class="ui-table">
                            <tbody>
                                <tr>
                                    <th>
                                        Choose which solutions to include
                                    </th>
                                </tr>
                                <?php
                                $suggestions = json_decode($blOptiSuggestion, true);
                                foreach($suggestions as $setid => $suggestion) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="ne-opti-table-accordion-header ui-unselectabletext">
                                            <div class="goog-icon goog-icon-dropdown-arrow-right ui-container-inline"></div>
                                            <span class="ne-opti-table-accordion-header-title">
                                                Solutions near 
                                                <span>
                                                <?php
                                                $averagetime = 0;
                                                foreach($suggestion as $event){
                                                    $averagetime += strtotime($event["start"]);
                                                }
                                                echo (int)($averagetime / count($suggestion));
                                                ?>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="ne-opti-table-accordion-content ne-opti-table-accordion-hidden">
                                            <table>
                                                <tbody>
                                                    <?php
                                                    
                                                    function compare($eventa,$eventb) {
                                                        if(((int) $eventa["cost"]) == ((int) $eventb["cost"])) {
                                                            return 0;
                                                        } else if(((int) $eventa["cost"]) > ((int) $eventb["cost"])) {
                                                            return 1;
                                                        } else {
                                                            return -1;
                                                        }
                                                    }
                                                    
                                                    $sorted = [];
                                                    foreach($suggestion as $event){
                                                        $sorted[] = $event;
                                                    }
                                                    usort($sorted,"compare");
                                                    ?>
                                                    <?php
                                                    for($i = 0; $i<count($sorted); $i++){
                                                    ?>
                                                    <tr>
                                                        <td class="ne-opti-startdate">
                                                            <?php echo strtotime($sorted[$i]["start"]) ?>
                                                        </td>
                                                        <td class="ne-opti-starttime">
                                                            <?php echo strtotime($sorted[$i]["start"]) ?>
                                                        </td>
                                                        <td>
                                                            -
                                                        </td>
                                                        <td class="ne-opti-endtime">
                                                            <?php echo strtotime($sorted[$i]["end"]) ?>
                                                        </td>
                                                        <td class="ne-opti-enddate">
                                                            <?php echo strtotime($sorted[$i]["end"]) ?>
                                                        </td>
                                                        <td class="ne-opti-location">
                                                            <?php echo $sorted[$i]["location"] ?>
                                                        </td>
                                                        <td class="ne-opti-attendees">
                                                            <div class="ne-opti-table-accordion-attendees-header ui-unselectabletext">
                                                                <div class="goog-icon goog-icon-dropdown-arrow-right ui-container-inline"></div>
                                                                <span class="ne-opti-table-accordion-header-title">
                                                                    Attendees available
                                                                </span>
                                                            </div>
                                                            <div class="ne-opti-table-accordion-attendees-content ne-opti-table-accordion-attendees-hidden">
                                                                <table>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach($attendees as $attendee) { //$sorted[$i]["attendees"] as $email => $available
                                                                            if($attendee["responseStatus"]=="accepted") {
                                                                        ?>
                                                                        <tr>
                                                                            <td class="ne-opti-table-accordion-attendees-email">
                                                                                <div class="goog-icon ui-container-inline <?php echo (in_array($attendee["email"], $sorted[$i]["attendees"])?"goog-icon-guest-yes":"goog-icon-guest-no"); ?>" title="<?php echo (in_array($attendee["email"], $sorted[$i]["attendees"])?"This guest is able to attend":"This guest is unable to attend") ?>"></div>
                                                                                <?php echo $attendee["email"] ?>
                                                                            </td>
                                                                            <td class="ne-opti-table-accordion-attendees-available">
                                                                                <?php echo in_array($attendee["email"], $sorted[$i]["attendees"])?"Yes":"No"; ?>
                                                                            </td>
                                                                        </tr>
                                                                            <?php }
                                                                            } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                        <td class="ne-opti-checkbox">
                                                            <input id="ne-opti-table-checkbox<?php echo "_".$setid."_".$sorted[$i]["id"]?>" class="ne-opti-table-checkbox ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>> 
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                      <?php } else { ?>
                    You have not yet run an optimization search. Would you like to run one now?
                      <?php }
                        } else { ?>
                    You must have requested calendar data from your attendees before running an optimization search.
                  <?php }
                    } else  { ?>
                    You must save your event before running an optimization search.
              <?php }
                    ?>
                </div>
                <div id="ne-opti-btns">
                    <?php  
                    if(isset($scrubbed["pkEventid"])) {
                        if(isset($dtRequestSent)) {
                            if(isset($blOptiSuggestion)) { ?>
                    <div id="ne-opti-btn-redo-wrapper" class="wrapper-btn-action wrapper-btn-all ne-btns-popups">
                        <div id="ne-opti-btn-redo"<?php echo " tabindex=\"".$ti++."\"";?>>
                            REDO SEARCH
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all ne-btns-popups">
                        <div id="ne-opti-btn-done"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Done
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all ne-btns-popups">
                        <div id="ne-opti-btn-cancel"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                      <?php } else { ?>
                    <div class="wrapper-btn-general wrapper-btn-all ne-btns-popups">
                        <div id="ne-opti-btn-yes" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Yes
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all ne-btns-popups">
                        <div id="ne-opti-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                      <?php }
                        } else { ?>
                    
                  <?php }
                    } else  { ?>
                    
              <?php }
                    ?>
                </div>
                
            </div>
        </div>
        <?php
        include $homedir."includes/pageassembly/account.php";
        ?>
    </body>
</html>