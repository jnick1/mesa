<!DOCTYPE html>
<?php
$homedir = "../";
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
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ui-placeholder.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/buttons.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/time.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/textarea-resize.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
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
                        <div id="ne-btn-send" tabindex="1" style="-moz-user-select: none;" role="button">
                            SEND
                        </div>
                    </div>
                    <div class="wrapper-btn-all wrapper-btn-general">
                        <div id="ne-btn-reset" tabindex="2" style="-moz-user-select: none;" role="button">
                            Reset
                        </div>
                    </div>
                </div>
            </div>
            <div id="ne-top-time" class="ne-container-section">
                <div id="ne-top-title">
                <input tabindex="3" id="ne-evt-title" name="ne-evt-title" class="ui-textinput ui-placeholder" title="Event title" type="text" placeholder="Untitled event">
                </div>
                <div id="ne-top-timegroup">
                    <span id="ne-top-time-startgroup">
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-date-start" name="ne-evt-date-start" class="ui-textinput ui-date" title="From date">
                        </span>
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-time-start" name="ne-evt-time-start" class="ui-textinput ui-time" title="From time" data-jq-dropdown="#details-dropdown-timestart">
                        </span>
                    </span>
                    <span id="ne-top-time-to">
                        to
                    </span>
                    <span id="ne-top-time-endgroup">
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-time-end" name="ne-evt-time-end" class="ui-textinput ui-time" title="To time" data-jq-dropdown="#details-dropdown-timeend">
                        </span>
                        <span class="ne-ipt-wrapper">
                            <input id="ne-evt-date-end" name="ne-evt-date-end" class="ui-textinput ui-date" title="To date">
                        </span>
                    </span>
                </div>
                <div id="ne-top-repeat">
                    <input id="ne-evt-repeatbox" name="ne-evt-repeatbox" class="ui-cboxinput" type="checkbox">
                    <label id="ne-label-repeatbox" class="ne-label" for="ne-evt-repeatbox">Repeat</label>
                </div>
            </div>
            <div class="ne-container-section" id="ne-container-details">
                <div id="ne-guests">
                    
                </div>
                <div id="ne-details">
                    <table id="details-table">
                        <tbody>
                            <tr>
                                <th>
                                    Where
                                </th>
                                <td>
                                    <input id="ne-evt-where" name="ne-evt-where"class="ui-textinput">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Calendar
                                </th>
                                <td>
                                    <select id="ne-evt-calendar" name="ne-evt-calendar" class="ui-select">
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
                                    <textarea id="ne-evt-description" name="ne-evt-description" class="ui-textinput" rows="3"></textarea>
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
                                    <select id="ne-evt-notifications" name="ne-evt-notifications" class="ui-dropdown">
                                        <option value="1">Pop-up</option>
                                        <option value="3">Email</option>
                                    </select>
                                    <input id="ne-evt-notifications-time" name="ne-evt-notifications-time" class="ui-textinput" value="30">
                                    <select id="ne-evt-notifications-timetype" name="ne-evt-notifications-timetype" class="ui-dropdown">
                                        <option value="60">minutes</option>
                                        <option value="3600">hours</option>
                                        <option value="86400">days</option>
                                        <option value="604800">weeks</option>
                                    </select>
                                    <span class="details-notifications-x">
                                        <img src="<?php echo $homedir."files/images/notificationsX.php"; ?>" alt="X" title="Remove notification">
                                    </span>
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
                                    <input class="ui-radiobtn" id="ne-evt-available" type="radio" name="ne-evt-avail" value="available">
                                    <label for="ne-evt-avail" >Available</label>
                                    <input class="ui-radiobtn" id="ne-evt-busy" type="radio" name="ne-evt-avail" value="busy" checked>
                                    <label for="ne-evt-busy" >Busy</label>
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
        <div id="details-dropdown-timestart" class="jq-dropdown jq-dropdown-scroll">
            <div class="jq-dropdown-panel">
                <?php
                for($i=0;$i<48;$i++){
                    $time = date("g:ia", strtotime((floor($i/2)).":".(($i%2)*30)));
                    echo "<div class=\"ui-dropdown-item details-dropdown-timestart-item\">".$time."</div>";
                }
                ?>
            </div>
        </div>
        <div id="details-dropdown-timeend" class="jq-dropdown jq-dropdown-scroll">
            <div id="details-dropdown-timeend-panel" class="jq-dropdown-panel">
                <?php //using javascript to fill in here based on current value in #ne-evt-time-start ?>
            </div>
        </div>
    </body>
</html>
