<!DOCTYPE html>
<?php
$homedir = "../";
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
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ne.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.structure.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.theme.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
        <script type="text/javascript" src="<?php echo $homedir."java/buttons.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/colors-selector.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/guest.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/notifications-sizechange.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/textarea-resize.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/time.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ui-placeholder.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/visibility.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant: New Event</title>
    </head>
    <body>
        <div id="wpg">
            <div id="ne-header" class="ui-container-section">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
                <div id="ne-top-buttons">
                    <div class="wrapper-btn-all wrapper-btn-action">
                        <div id="ne-btn-send" title="Send calendar access request to all guests"<?php echo " tabindex=\"".$ti++."\"";?>>
                            SEND
                        </div>
                    </div>
                    <div class="wrapper-btn-all wrapper-btn-general">
                        <div id="ne-btn-reset" title="Reset all event settings to default"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Reset
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
                    <input id="ne-evt-repeatbox" name="ne-evt-repeatbox" class="ui-checkbox" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                    <label id="ne-label-repeatbox" class="ne-label" for="ne-evt-repeatbox">Repeat</label>
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
                                    <div id="ne-btn-email" class="ui-container-inline">
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
                                        <div id="<?php?>user@gmail.com" class="ne-evt-guest" data-required="true" title="user@gmail.com">
                                            <div class="ne-guests-guestdata">
                                                <div class="ne-guests-guestdata-content ui-container-inline">
                                                    <span class="goog-icon goog-icon-guest-required ui-container-inline ne-guest-required" title="Click to mark this attendee as optional"></span>
                                                    <div class="ui-container-inline ne-guest-response-icon-wrapper">
                                                        <div class="ne-guest-response-icon"></div>
                                                    </div>
                                                    <div id="<?php?>user@gmail.com@display" class="ne-guest-name-wrapper ui-container-inline">
                                                        <span class="ne-guest-name ui-unselectabletext">user@gmail.com</span>
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
                                    <input id="ne-evt-guests-modifyevent" name="guestsettings" value="modifyevent" type="checkbox" class="ui-checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    modify event
                                </label>
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
                    <table id="details-table">
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
                                    Calendar
                                </th>
                                <td>
                                    <select id="ne-evt-calendar" name="ne-evt-calendar" class="ui-select"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        <?php
                                            // insert code for list of calendars here (must echo <option>[CALDENDAR NAME]</option> as output)
                                        ?>
                                    </select>
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
                                    <input id="ne-evt-available" class="ui-radiobtn" type="radio" name="ne-evt-availability" value="available"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <label for="ne-evt-available" >Available</label>
                                    <input id="ne-evt-busy" class="ui-radiobtn" type="radio" name="ne-evt-availability" value="busy" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <label for="ne-evt-busy" >Busy</label>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Visibility
                                </th>
                                <td>
                                    <input id="ne-evt-visibility-default" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="default" checked<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <label for="ne-evt-visibility-default" >Calendar Default</label>
                                    <input id="ne-evt-visibility-public" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="public"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <label for="ne-evt-visibility-public" >Public</label>
                                    <input id="ne-evt-visibility-private" class="ui-radiobtn" type="radio" name="ne-evt-visibility" value="private"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <label for="ne-evt-visibility-private" >Private</label>
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
    </body>
</html>
