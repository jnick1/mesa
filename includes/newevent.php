<!DOCTYPE html>
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

?>

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
        <div id="wpg">
            <div id="ne-header" class="ui-container-section">
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
                    <div class="wrapper-btn-all wrapper-btn-general">
                        <div id="ne-btn-save" title="Save event for later modification"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Save
                        </div>
                    </div>
                </div>
            </div>
            <div id="ne-top-time" class="ui-container-section">
                <div id="ne-top-title">
                    <input id="ne-evt-title" name="ne-evt-title" class="ui-textinput ui-placeholder" title="Event title" type="text" placeholder="Untitled event"<?php echo " tabindex=\"".$ti++."\"";?>>
                </div>
                <div id="ne-top-timegroup">
                    <span id="ne-top-time-startgroup">
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-date-start" name="ne-evt-date-start" class="ui-textinput ui-date" title="From date"<?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-time-start" name="ne-evt-time-start" class="ui-textinput ui-time" title="From time" data-jq-dropdown="#ne-dropdown-timestart"<?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                    </span>
                    <span id="ne-top-time-to">
                        to
                    </span>
                    <span id="ne-top-time-endgroup">
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-time-end" name="ne-evt-time-end" class="ui-textinput ui-time" title="To time" data-jq-dropdown="#ne-dropdown-timeend"<?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-date-end" name="ne-evt-date-end" class="ui-textinput ui-date" title="To date"<?php echo " tabindex=\"".$ti++."\"";?>>
                        </span>
                    </span>
                </div>
                <div id="ne-top-repeat">
                    <span id="ne-settings-top-wrapper">
                        <input id="ne-evt-settingsbox" name="ne-evt-settingsbox" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                        <label id="ne-label-settingsbox" class="ne-label" for="ne-evt-settingsbox">
                            Advanced settings
                        </label>
                    </span>
                    <span id="ne-settings-display" class="ui-header wpg-nodisplay">Active</span>
                    <span id="ne-settings-edit" class="ui-revisitablelink wpg-nodisplay">Edit</span>
                    <span id="ne-repeat-top-wrapper">
                        <input id="ne-evt-repeatbox" name="ne-evt-repeatbox" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                        <label id="ne-label-repeatbox" class="ne-label" for="ne-evt-repeatbox">
                            Repeat...
                        </label>
                    </span>
                    <span id="ne-repeat-summary-display" class="ui-header wpg-nodisplay">Daily</span>
                    <span id="ne-repeat-edit" class="ui-revisitablelink wpg-nodisplay">Edit</span>
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
                                    //retrieve info from database
                                    $guestsYes = 0;
                                    $guestsMaybe = 0;
                                    $guestsNo = 0;
                                    $guestsWaiting = 0;
                                    echo "Yes: $guestsYes, Maybe: $guestsMaybe, No: $guestsNo, Awaiting: $guestsWaiting";
                                    ?>
                                </div>
                                <div id="ne-guests-table">
                                    <div id="ne-guests-table-body">
                                        <?php // will need to pull user email from login info into this section?>
                                        <div id="<?php //needed here ?>user@gmail.com" class="ne-evt-guest" data-required="true" title="user@gmail.com">
                                            <div class="ne-guests-guestdata">
                                                <div class="ne-guests-guestdata-content ui-container-inline">
                                                    <span class="goog-icon goog-icon-guest-required ui-container-inline ne-guest-required" title="Click to mark this attendee as optional"></span>
                                                    <div class="ui-container-inline ne-guest-response-icon-wrapper">
                                                        <div class="ne-guest-response-icon"></div>
                                                    </div>
                                                    <div id="<?php //needed here ?>user@gmail.com@display" class="ne-guest-name-wrapper ui-container-inline">
                                                        <span class="ne-guest-name ui-unselectabletext"><?php //needed here ?>user@gmail.com</span>
                                                    </div>
                                                    <div class="ui-container-inline ne-guest-delete">
                                                        <div class="goog-icon goog-icon-x-small" title="Remove this guest from the event"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                    <input id="ne-evt-guests-inviteothers" name="guestsettings" value="inviteothers" type="checkbox" class="ui-checkbox" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                    invite others
                                </label>
                                <label class="ne-guests-container-checkbox ui-unselectabletext">
                                    <input id="ne-evt-guests-seeguestlist" name="guestsettings" value="seeguestlist" type="checkbox" class="ui-checkbox" checked<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                    <input id="ne-evt-where" name="ne-evt-where"class="ui-textinput" placeholder="Enter a location"<?php echo " tabindex=\"".$ti++."\"";?>>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Description
                                </th>
                                <td>
                                    <textarea id="ne-evt-description" name="ne-evt-description" class="ui-textinput" rows="3"<?php echo " tabindex=\"".$ti++."\"";?>></textarea>
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
                                    <div id="ne-evt-color-default" name="ne-evt-color-default" class="details-eventcolors details-eventcolors-selected" title="default"><div class="goog-icon goog-icon-colors-checkmark-white"></div></div>
                                    <div id="details-color-separator"></div>
                                    <div id="ne-evt-color-boldblue" name="ne-evt-color-boldblue" class="details-eventcolors" title="bold blue"></div>
                                    <div id="ne-evt-color-blue" name="ne-evt-color-blue" class="details-eventcolors" title="blue"></div>
                                    <div id="ne-evt-color-turquoise" name="ne-evt-color-turquoise" class="details-eventcolors" title="turquoise"></div>
                                    <div id="ne-evt-color-green" name="ne-evt-color-green" class="details-eventcolors" title="green"></div>
                                    <div id="ne-evt-color-boldgreen" name="ne-evt-color-boldgreen" class="details-eventcolors" title="boldgreen"></div>
                                    <div id="ne-evt-color-yellow" name="ne-evt-color-yellow" class="details-eventcolors" title="yellow"></div>
                                    <div id="ne-evt-color-orange" name="ne-evt-color-orange" class="details-eventcolors" title="orange"></div>
                                    <div id="ne-evt-color-red" name="ne-evt-color-red" class="details-eventcolors" title="red"></div>
                                    <div id="ne-evt-color-boldred" name="ne-evt-color-boldred" class="details-eventcolors" title="boldred"></div>
                                    <div id="ne-evt-color-purple" name="ne-evt-color-purple" class="details-eventcolors" title="purple"></div>
                                    <div id="ne-evt-color-gray" name="ne-evt-color-gray" class="details-eventcolors" title="gray"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Notifications
                                </th>
                                <td>
                                    <div id="wrapper-notifications">
                                        <div id="details-notifications-none" class="details-notifications-hidden">
                                            No notifications set
                                        </div>
                                        <div id="details-notifications-1" class="details-notifications">
                                            <select id="ne-evt-notifications-1" name="ne-evt-notifications-1" class="ui-select" title="Notification type">
                                                <option value="1">Pop-up</option>
                                                <option value="3">Email</option>
                                            </select>
                                            <input id="ne-evt-notifications-time-1" name="ne-evt-notifications-time-1" class="details-notifications-remindertime ui-textinput" value="30" title="Reminder time">
                                            <select id="ne-evt-notifications-timetype-1" name="ne-evt-notifications-timetype-1" class="ui-select" title="Reminder time">
                                                <option value="60">minutes</option>
                                                <option value="3600">hours</option>
                                                <option value="86400">days</option>
                                                <option value="604800">weeks</option>
                                            </select>
                                            <div id="details-notifications-x-1" class="details-notifications-x goog-icon goog-icon-x-small" title="Remove notification"></div>
                                        </div>
                                    </div>
                                    <div id="details-notifications-add">
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
                                        <input id="ne-evt-available" class="ui-radiobtn" type="radio" name="ne-evt-availability" value="available"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Available
                                    </label>
                                    <label for="ne-evt-busy" >
                                        <input id="ne-evt-busy" class="ui-radiobtn" type="radio" name="ne-evt-availability" value="busy" checked<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                        <input id="ne-evt-visibility-default" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="default" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Calendar Default
                                    </label>
                                    <label for="ne-evt-visibility-public" >
                                        <input id="ne-evt-visibility-public" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="public"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Public
                                    </label>
                                    <label for="ne-evt-visibility-private" >
                                        <input id="ne-evt-visibility-private" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="private"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Private
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <div class="ui-smallfont">
                                        <span id="details-visibility-info-default">
                                            <div class="goog-icon goog-icon-notifications-x"></div>
                                            By default this event will follow the <span id="goog-sharing-settings" class="ui-revisitablelink">sharing settings</span> of this calendar: event details will be visible to anyone who can see details of other events in this calendar.
                                        </span>
                                        <span id="details-visibility-info-public" class="details-visibility-info-hidden">
                                            Making this event public will expose all event details to anyone who has access to this calendar, even if they can't see details of other events.
                                        </span>
                                        <span id="details-visibility-info-private" class="details-visibility-info-hidden">
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
                                        days
                                    </span>
                                </td>
                            </tr>
                            <tr id="ne-repeat-table-2" class="wpg-nodisplay">
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
                            <tr id="ne-repeat-table-3" class="wpg-nodisplay">
                                <th>
                                    Repeat by:
                                </th>
                                <td>
                                    <span>
                                        <label for="ne-evt-repeat-repeatby-dayofmonth" title="Repeat by day of the month">
                                            <input id="ne-evt-repeat-repeatby-dayofmonth" name="ne-evt-repeat-repeatby" title="Repeat by day of the month" type="radio" checked<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                            <input id="ne-evt-endson-never" name="ne-evt-endson" title="Ends never" type="radio" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                            Never
                                        </label>
                                    </span>
                                    <span class="ui-container-block">
                                        <input id="ne-evt-endson-after" name="ne-evt-endson" title="Ends after a number of occurrences" type="radio"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <label for="ne-evt-endson-after" title="Ends after a number of occurrences">
                                            After 
                                            <input id="ne-evt-endson-occurances" name="ne-evt-endson-occurances" class="ui-textinput" size="3" title="Occurrences" disabled<?php echo " tabindex=\"".$ti++."\"";?>> 
                                            occurrences
                                        </label>
                                    </span>
                                    <span class="ui-container-block">
                                        <input id="ne-evt-endson-on" name="ne-evt-endson" title="Ends on a specified date" type="radio"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <label for="ne-evt-endson-on" title="Ends on a specified date">
                                            On 
                                            <input id="ne-evt-endson-date" name="ne-evt-endson-date" class="ui-textinput" size="10" title="Specified date" disabled<?php echo " tabindex=\"".$ti++."\"";?>>
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
                            <input id="ne-evt-settings-usedefault" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-timegate" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom time settings
                                                    </label>
                                                    <table id="ne-settings-time-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-time-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-timeallow" for="ne-evt-settings-timeallow">
                                                                        <input id="ne-evt-settings-timeallow" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow time modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-time-table-1">
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-time-prior-low" >
                                                                            <input id="ne-evt-settings-time-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-time-prior" value="1" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-time-prior-med" >
                                                                            <input id="ne-evt-settings-time-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-time-prior" value="10"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-time-prior-hig" >
                                                                            <input id="ne-evt-settings-time-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-time-prior" value="100"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-daygate" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom day settings
                                                    </label>
                                                    <table id="ne-settings-day-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-day-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-dayallow" for="ne-evt-settings-dayallow">
                                                                        <input id="ne-evt-settings-dayallow" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow day modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-day-table-1">
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-date-prior-low" >
                                                                            <input id="ne-evt-settings-date-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-date-prior" value="1" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-date-prior-med" >
                                                                            <input id="ne-evt-settings-date-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-date-prior" value="10"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-date-prior-hig" >
                                                                            <input id="ne-evt-settings-date-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-date-prior" value="100"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-day-table-2">
                                                                <td>
                                                                    <label id="ne-label-settings-maxdate" for="ne-evt-settings-maxdate">
                                                                        Furthest search date
                                                                        <input id="ne-evt-settings-maxdate" class="ui-date ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-durationgate" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom duration settings
                                                    </label>
                                                    <table id="ne-settings-duration-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-duration-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-durationallow" for="ne-evt-settings-durationallow">
                                                                        <input id="ne-evt-settings-durationallow" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow duration modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-duration-table-1">
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-duration-prior-low" >
                                                                            <input id="ne-evt-settings-duration-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-duration-prior" value="1" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-duration-prior-med" >
                                                                            <input id="ne-evt-settings-duration-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-duration-prior" value="10"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-duration-prior-hig" >
                                                                            <input id="ne-evt-settings-duration-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-duration-prior" value="100"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-duration-table-2">
                                                                <td>
                                                                    <label id="ne-label-settings-minduration" for="ne-evt-settings-minduration">
                                                                        Minimum duration
                                                                        <input id="ne-evt-settings-minduration" class="ui-textinput ui-time" value="00:30"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-repeatgate" class="ui-checkbox" type="checkbox" disabled<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom repetition settings
                                                    </label>
                                                    <span id="ne-settings-repetition-annotation" class="ui-container-block ui-smallfont">(disabled when repeat is not set)</span>
                                                    <table id="ne-settings-repeats-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-repeats-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-repeatsallow" for="ne-evt-settings-repeatsallow">
                                                                        <input id="ne-evt-settings-repeatsallow" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow repeats modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-repeats-table-1">
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-repeats-prior-low" >
                                                                            <input id="ne-evt-settings-repeats-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-repeats-prior" value="1" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-repeats-prior-med" >
                                                                            <input id="ne-evt-settings-repeats-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-repeats-prior" value="10"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-repeats-prior-hig" >
                                                                            <input id="ne-evt-settings-repeats-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-repeats-prior" value="100"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-repeats-table-2">
                                                                <td>
                                                                    <label id="ne-label-settings-repeatsmin" for="ne-evt-settings-repeatsmin">
                                                                        Minimum number of repeats
                                                                        <input id="ne-evt-settings-repeatsmin" class="ui-textinput ui-shortbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-repeats-table-3">
                                                                <td>
                                                                    <label id="ne-label-settings-repeatsconstant" for="ne-evt-settings-repeatsconstant">
                                                                        All meetings at same time
                                                                        <input id="ne-evt-settings-repeatsconstant" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-blacklistgate" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom blacklist settings
                                                    </label>
                                                    <table id="ne-settings-blacklist-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-blacklist-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-blackliststart" for="ne-evt-settings-blackliststart">
                                                                        Earliest start time
                                                                        <input id="ne-evt-settings-blackliststart" class="ui-textinput ui-time" <?php echo " tabindex=\"".$ti++."\"";?>>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-blacklist-table-1">
                                                                <td>
                                                                    <label id="ne-label-settings-blacklistend" for="ne-evt-settings-blacklistend">
                                                                        Latest end time
                                                                        <input id="ne-evt-settings-blacklistend" class="ui-textinput ui-time"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                                                <input id="ne-evt-settings-blacklistdays-0" name="ne-evt-settings-blacklistdays-0" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Sunday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                S
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-1" class="ne-label-settings-blacklistdays" title="Monday">
                                                                                <input id="ne-evt-settings-blacklistdays-1" name="ne-evt-settings-blacklistdays-1" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Monday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                M
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-2" class="ne-label-settings-blacklistdays" title="Tuesday">
                                                                                <input id="ne-evt-settings-blacklistdays-2" name="ne-evt-settings-blacklistdays-2" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Tuesday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                T
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-3" class="ne-label-settings-blacklistdays" title="Wednesday">
                                                                                <input id="ne-evt-settings-blacklistdays-3" name="ne-evt-settings-blacklistdays-3" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Wednesday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                W
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-4" class="ne-label-settings-blacklistdays" title="Thursday">
                                                                                <input id="ne-evt-settings-blacklistdays-4" name="ne-evt-settings-blacklistdays-4" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Thursday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                T
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-5" class="ne-label-settings-blacklistdays" title="Friday">
                                                                                <input id="ne-evt-settings-blacklistdays-5" name="ne-evt-settings-blacklistdays-5" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Friday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                                F
                                                                            </label>
                                                                        </span>
                                                                        <span class="ui-container-inline">
                                                                            <label for="ne-evt-settings-blacklistdays-6" class="ne-label-settings-blacklistdays" title="Saturday">
                                                                                <input id="ne-evt-settings-blacklistdays-6" name="ne-evt-settings-blacklistdays-6" class="ui-checkbox ne-settings-blacklistdays-checkbox" title="Saturday" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-locationgate" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom location settings
                                                    </label>
                                                    <table id="ne-settings-location-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-location-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-locationallow" for="ne-evt-settings-locationallow">
                                                                        <input id="ne-evt-settings-locationallow" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow location modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-location-table-1">
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-location-prior-low" >
                                                                            <input id="ne-evt-settings-location-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-location-prior" value="1" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-location-prior-med" >
                                                                            <input id="ne-evt-settings-location-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-location-prior" value="10"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-location-prior-hig" >
                                                                            <input id="ne-evt-settings-location-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-location-prior" value="100"<?php echo " tabindex=\"".$ti++."\"";?>>
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
                                                        <input id="ne-evt-settings-attendancegate" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Custom attendance settings
                                                    </label>
                                                    <table id="ne-settings-attendees-table" class="wpg-nodisplay">
                                                        <tbody>
                                                            <tr id="ne-settings-attendees-table-0">
                                                                <td>
                                                                    <label id="ne-label-settings-attendeesallow" for="ne-evt-settings-attendeesallow">
                                                                        <input id="ne-evt-settings-attendeesallow" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                        Allow attendees modulation
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-attendees-table-1">
                                                                <td>
                                                                    Prioritization
                                                                    <span class="ui-container-block ui-smallfont">
                                                                        <label for="ne-evt-settings-attendees-prior-low" >
                                                                            <input id="ne-evt-settings-attendees-prior-low" class="ui-radiobtn" type="radio" name="ne-evt-settings-attendees-prior" value="1" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            low
                                                                        </label>
                                                                        <label for="ne-evt-settings-attendees-prior-med" >
                                                                            <input id="ne-evt-settings-attendees-prior-med" class="ui-radiobtn" type="radio" name="ne-evt-settings-attendees-prior" value="10"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            medium
                                                                        </label>
                                                                        <label for="ne-evt-settings-attendees-prior-hig" >
                                                                            <input id="ne-evt-settings-attendees-prior-hig" class="ui-radiobtn" type="radio" name="ne-evt-settings-attendees-prior" value="100"<?php echo " tabindex=\"".$ti++."\"";?>>
                                                                            high
                                                                        </label>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr id="ne-settings-attendees-table-2">
                                                                <td>
                                                                    <label id="ne-label-settings-attendeesnomiss" for="ne-evt-settings-attendeesallow">
                                                                        Minimum required attendees
                                                                        <input id="ne-evt-settings-attendeesnomiss" class="ui-shortbox"<?php echo " tabindex=\"".$ti++."\"";?>>
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
    </body>
</html>