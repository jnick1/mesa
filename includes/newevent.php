<!DOCTYPE html>
<?php
$homedir = "../";
$ti = 1;
?>

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ne.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/colors.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/notifications.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ui-placeholder.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/buttons.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/time.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/textarea-resize.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/colors-selector.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/notifications-sizechange.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/visibility.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant: New Event</title>
    </head>
    <body>
        <div id="wpg">
            <div id="ne-header" class="ne-container-section">
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
            <div id="ne-top-time" class="ne-container-section">
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
                    <input id="ne-evt-repeatbox" name="ne-evt-repeatbox" class="ui-cboxinput" type="checkbox"<?php echo " tabindex=\"".$ti++."\"";?>>
                    <label id="ne-label-repeatbox" class="ne-label" for="ne-evt-repeatbox">Repeat</label>
                </div>
            </div>
            <div id="ne-container-details" class="ne-container-section">
                <div id="ne-container-guests">
                    <div id="ne-guests">
                        <div id="ne-guests-inputzone">
                            <div class="ne-guests-header">
                                Add guests
                            </div>
                            <div>
                                <div class="ne-container-inline">
                                    <input id="ne-guests-emailinput" class="ui-textinput" placeholder="Enter guest email addresses" title="Enter guest email addresses"<?php echo " tabindex=\"".$ti++."\"";?>>
                                </div>
                                <div id="ne-guests-addbutton-wrapper" class="wrapper-btn-all wrapper-btn-general ne-container-inline">
                                    <div id="ne-guests-addbutton"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Add
                                    </div>
                                </div>
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
                                    <div class="details-separator"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Event color
                                </th>
                                <td>
                                    <div id="ne-evt-color-default" name="ne-evt-color-default" class="details-eventcolors details-eventcolors-selected" title="default"></div>
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
                                            <div id="details-notifications-x-1" class="details-notifications-x" title="Remove notification"></div>
                                        </div>
                                    </div>
                                    <div id="details-notifications-add">
                                        <span id="details-notifications-addlink" class="ui-revisitablelink" <?php echo " tabindex=\"".$ti++."\"";?>>Add a notification</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="details-separator"></div>
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
                                    <div>
                                        <span id="details-visibility-info-default" class="details-visibility-info">
                                            By default this event will follow the <span id="goog-sharing-settings" class="ui-revisitablelink">sharing settings</span> of this calendar: event details will be visible to anyone who can see details of other events in this calendar.
                                        </span>
                                        <span id="details-visibility-info-public" class="details-visibility-info details-visibility-info-hidden">
                                            Making this event public will expose all event details to anyone who has access to this calendar, even if they can't see details of other events.
                                        </span>
                                        <span id="details-visibility-info-private" class="details-visibility-info details-visibility-info-hidden">
                                            Making this event private will hide all event details from anyone who has access to this calendar, unless they have "Make changes to events" level of access or higher.
                                        </span>
                                        <a href="https://support.google.com/calendar?p=event_visibility&amp;hl=en" class="ui-revisitablelink details-visibility-info" target="_blank">Learn more</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!--        <div style="top: 188px; visibility: visible; left: 30px; display: block;" class="dpi-popup">
            <div class="dp-monthtablediv monthtableSpace">
                <table class="dp-monthtable" role="presentation" style="-moz-user-select:none;-webkit-user-select:none;" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr class="dp-cell dp-heading" id=":3iheader">
                            <td id=":3iprev" class="dp-cell dp-prev">«</td>
                            <td colspan="5" id=":3icur" class="dp-cell dp-cur">February 2016</td>
                            <td id=":3inext" class="dp-cell dp-next">»</td>
                        </tr>
                    </tbody>
                </table>
                <table class="dp-monthtable monthtableBody" summary="February 2016" id=":3itbl" style="-moz-user-select:none;-webkit-user-select:none;" cellpadding="0" cellspacing="0">
                    <colgroup span="7"></colgroup>
                    <tbody>
                        <tr class="dp-days">
                            <th scope="col" class="dp-cell dp-dayh dp-cell dp-weekendh" title="Sunday">S</th>
                            <th scope="col" class="dp-cell dp-dayh" title="Monday">M</th>
                            <th scope="col" class="dp-cell dp-dayh" title="Tuesday">T</th>
                            <th scope="col" class="dp-cell dp-dayh" title="Wednesday">W</th>
                            <th scope="col" class="dp-cell dp-dayh" title="Thursday">T</th>
                            <th scope="col" class="dp-cell dp-dayh" title="Friday">F</th>
                            <th scope="col" class="dp-cell dp-dayh dp-cell dp-weekendh" title="Saturday">S</th>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_0">
                            <td id=":3iday_23608" class="dp-cell dp-weekend dp-offmonth dp-day-left ">24</td>
                            <td id=":3iday_23609" class="dp-cell dp-weekday dp-offmonth ">25</td>
                            <td id=":3iday_23610" class="dp-cell dp-weekday dp-offmonth ">26</td>
                            <td id=":3iday_23611" class="dp-cell dp-weekday dp-offmonth">27</td>
                            <td id=":3iday_23612" class="dp-cell dp-weekday dp-offmonth ">28</td>
                            <td id=":3iday_23613" class="dp-cell dp-weekday dp-offmonth ">29</td>
                            <td id=":3iday_23614" class="dp-cell dp-weekend dp-offmonth dp-day-right ">30</td>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_1">
                            <td id=":3iday_23615" class="dp-cell dp-weekend dp-offmonth dp-day-left ">31</td>
                            <td id=":3iday_23617" class="dp-cell dp-weekday dp-onmonth ">1</td>
                            <td id=":3iday_23618" class="dp-cell dp-weekday dp-onmonth ">2</td>
                            <td id=":3iday_23619" class="dp-cell dp-weekday dp-onmonth">3</td>
                            <td id=":3iday_23620" class="dp-cell dp-weekday dp-onmonth ">4</td>
                            <td id=":3iday_23621" class="dp-cell dp-weekday dp-onmonth ">5</td>
                            <td id=":3iday_23622" class="dp-cell dp-weekend dp-onmonth dp-day-right ">6</td>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_2">
                            <td id=":3iday_23623" class="dp-cell dp-weekend dp-onmonth dp-day-left ">7</td>
                            <td id=":3iday_23624" class="dp-cell dp-weekday dp-onmonth ">8</td>
                            <td id=":3iday_23625" class="dp-cell dp-weekday dp-onmonth ">9</td>
                            <td id=":3iday_23626" class="dp-cell dp-weekday dp-onmonth ">10</td>
                            <td id=":3iday_23627" class="dp-cell dp-weekday dp-onmonth">11</td>
                            <td id=":3iday_23628" class="dp-cell dp-weekday dp-onmonth ">12</td>
                            <td id=":3iday_23629" class="dp-cell dp-weekend dp-onmonth dp-day-right ">13</td>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_3">
                            <td id=":3iday_23630" class="dp-cell dp-weekend dp-onmonth dp-day-left ">14</td>
                            <td id=":3iday_23631" class="dp-cell dp-weekday dp-onmonth ">15</td>
                            <td id=":3iday_23632" class="dp-cell dp-weekday dp-onmonth ">16</td>
                            <td id=":3iday_23633" class="dp-cell dp-weekday dp-onmonth ">17</td>
                            <td id=":3iday_23634" class="dp-cell dp-weekday dp-onmonth ">18</td>
                            <td id=":3iday_23635" class="dp-cell dp-weekday dp-onmonth ">19</td>
                            <td id=":3iday_23636" class="dp-cell dp-weekend-selected dp-today-selected dp-onmonth-selected dp-day-right ">20</td>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_4">
                            <td id=":3iday_23637" class="dp-cell dp-weekend dp-onmonth dp-day-left ">21</td>
                            <td id=":3iday_23638" class="dp-cell dp-weekday dp-onmonth ">22</td>
                            <td id=":3iday_23639" class="dp-cell dp-weekday dp-onmonth ">23</td>
                            <td id=":3iday_23640" class="dp-cell dp-weekday dp-onmonth ">24</td>
                            <td id=":3iday_23641" class="dp-cell dp-weekday dp-onmonth">25</td>
                            <td id=":3iday_23642" class="dp-cell dp-weekday dp-onmonth ">26</td>
                            <td id=":3iday_23643" class="dp-cell dp-weekend dp-onmonth dp-day-right ">27</td>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_5">
                            <td id=":3iday_23644" class="dp-cell dp-weekend dp-onmonth dp-day-left ">28</td>
                            <td id=":3iday_23645" class="dp-cell dp-weekday dp-onmonth ">29</td>
                            <td id=":3iday_23649" class="dp-cell dp-weekday dp-offmonth ">1</td>
                            <td id=":3iday_23650" class="dp-cell dp-weekday dp-offmonth ">2</td>
                            <td id=":3iday_23651" class="dp-cell dp-weekday dp-offmonth">3</td>
                            <td id=":3iday_23652" class="dp-cell dp-weekday dp-offmonth ">4</td>
                            <td id=":3iday_23653" class="dp-cell dp-weekend dp-offmonth dp-day-right ">5</td>
                        </tr>
                        <tr style="cursor:pointer" id=":3irow_6">
                            <td id=":3iday_23654" class="dp-cell dp-weekend dp-offmonth dp-day-left ">6</td>
                            <td id=":3iday_23655" class="dp-cell dp-weekday dp-offmonth ">7</td>
                            <td id=":3iday_23656" class="dp-cell dp-weekday dp-offmonth ">8</td>
                            <td id=":3iday_23657" class="dp-cell dp-weekday dp-offmonth ">9</td>
                            <td id=":3iday_23658" class="dp-cell dp-weekday dp-offmonth">10</td>
                            <td id=":3iday_23659" class="dp-cell dp-weekday dp-offmonth ">11</td>
                            <td id=":3iday_23660" class="dp-cell dp-weekend dp-offmonth dp-day-right ">12</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>-->
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
