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
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ui-placeholder.js"?>"></script>
        <title>Meeting and Event Scheduling Assistant: New Event</title>
    </head>
    <body>
        <div id="wpg">
            <?php
            include $homedir."includes/pageassembly/header.php";
            ?>
            <div id="ne-top-buttons" class="ne-section-container">
                <div class="all-btn-wrapper action-btn-wrapper">
                    <div id="ne-btn-send" tabindex="1" style="-moz-user-select: none;" role="button">
                        SEND
                    </div>
                </div>
                <div class="all-btn-wrapper gen-btn-wrapper">
                    <div id="ne-btn-reset" tabindex="2" style="-moz-user-select: none;" role="button">
                        Reset
                    </div>
                </div>
            </div>
            <div id="ne-evt-title">
                <input tabindex="3" id="ne-evt-title-input" class="ui-textinput ui-placeholder" title="Event title" type="text" placeholder="Untitled event">
            </div>
            <div id="ne-evt-time" class="ne-section-container">
                <div>
                    <span id="ne-evt-time-startgroup">
                        <span class="ne-evt-ipt-wrapper">
                            <input class="ui-textinput ui-date" title="From date">
                        </span>
                        <span class="ne-evt-ipt-wrapper">
                            <input class="ui-textinput ui-time" title="From time">
                        </span>
                    </span>
                    <span id="ne-evt-time-to">
                        to
                    </span>
                    <span id="ne-evt-time-endgroup">
                        <span class="ne-evt-ipt-wrapper">
                            <input class="ui-textinput ui-time" title="To time">
                        </span>
                        <span class="ne-evt-ipt-wrapper">
                            <input class="ui-textinput ui-date" title="To date">
                        </span>
                    </span>
                </div>
                <div>
                    <input id="ne-evt-repeatbox" class="ui-cboxinput" type="checkbox">
                    <label id="ne-evt-repeatbox-label" class="ne-label" for="ne-evt-repeatbox">Repeat</label>
                </div>
            </div>
            <div class="ne-section-container">
                <div id="ne-guests">
                    
                </div>
                <div id="ne-details">
                    <table id="details-table">
                        <tbody>
                            <tr>
                                <th class="details-header">
                                    Where
                                </th>
                                <td class="details-data">
                                    <input class="ui-textinput">
                                </td>
                            </tr>
                            <tr>
                                <th class="details-header">
                                    Calendar
                                </th>
                                <td class="details-data">
                                    <select>
                                        <?php
                                            // insert code for list of calendars here (must echo <option>[CALDENDAR NAME]</option> as output)
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="details-header">
                                    Description
                                </th>
                                <td class="details-data">
                                    <textarea>
                                        
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <th class="details-header">
                                    Event color
                                </th>
                                <td class="details-data">
                                    
                                </td>
                            </tr>
                            <tr>
                                <th class="details-header">
                                    Show me as
                                </th>
                                <td class="details-data">
                                    <input class="ui-radiobtn" id="ne-evt-avail" type="radio" name="availability" value="available">
                                    <label for="ne-evt-avail" >Available</label>
                                    <input class="ui-radiobtn" id="ne-evt-busy" type="radio" name="availability" value="busy" checked>
                                    <label for="ne-evt-busy" >Busy</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!--        <div style="top: 17px; -moz-user-select: none; left: 119.35px;" class="goog-container goog-container-vertical">
            <div id=":37" style="-moz-user-select: none;" class="goog-control">12:00am</div>
            <div id=":38" style="-moz-user-select: none;" class="goog-control">12:30am</div>
            <div id=":39" style="-moz-user-select: none;" class="goog-control">1:00am</div>
            <div id=":3a" style="-moz-user-select: none;" class="goog-control">1:30am</div>
            <div id=":3b" style="-moz-user-select: none;" class="goog-control">2:00am</div>
            <div id=":3c" style="-moz-user-select: none;" class="goog-control">2:30am</div>
            <div id=":3d" style="-moz-user-select: none;" class="goog-control">3:00am</div>
            <div id=":3e" style="-moz-user-select: none;" class="goog-control">3:30am</div>
            <div id=":3f" style="-moz-user-select: none;" class="goog-control">4:00am</div>
            <div id=":3g" style="-moz-user-select: none;" class="goog-control">4:30am</div>
            <div id=":3h" style="-moz-user-select: none;" class="goog-control">5:00am</div>
            <div id=":3i" style="-moz-user-select: none;" class="goog-control">5:30am</div>
            <div id=":3j" style="-moz-user-select: none;" class="goog-control">6:00am</div>
            <div id=":3k" style="-moz-user-select: none;" class="goog-control">6:30am</div>
            <div id=":3l" style="-moz-user-select: none;" class="goog-control">7:00am</div>
            <div id=":3m" style="-moz-user-select: none;" class="goog-control">7:30am</div>
            <div id=":3n" style="-moz-user-select: none;" class="goog-control">8:00am</div>
            <div id=":3o" style="-moz-user-select: none;" class="goog-control">8:30am</div>
            <div id=":3p" style="-moz-user-select: none;" class="goog-control">9:00am</div>
            <div id=":3q" style="-moz-user-select: none;" class="goog-control">9:30am</div>
            <div id=":3r" style="-moz-user-select: none;" class="goog-control">10:00am</div>
            <div id=":3s" style="-moz-user-select: none;" class="goog-control">10:30am</div>
            <div id=":3t" style="-moz-user-select: none;" class="goog-control">11:00am</div>
            <div id=":3u" style="-moz-user-select: none;" class="goog-control">11:30am</div>
            <div id=":3v" style="-moz-user-select: none;" class="goog-control">12:00pm</div>
            <div id=":3w" style="-moz-user-select: none;" class="goog-control">12:30pm</div>
            <div id=":3x" style="-moz-user-select: none;" class="goog-control">1:00pm</div>
            <div id=":3y" style="-moz-user-select: none;" class="goog-control">1:30pm</div>
            <div id=":3z" style="-moz-user-select: none;" class="goog-control">2:00pm</div>
            <div id=":40" style="-moz-user-select: none;" class="goog-control">2:30pm</div>
            <div id=":41" style="-moz-user-select: none;" class="goog-control">3:00pm</div>
            <div id=":42" style="-moz-user-select: none;" class="goog-control">3:30pm</div>
            <div id=":43" style="-moz-user-select: none;" class="goog-control">4:00pm</div>
            <div id=":44" style="-moz-user-select: none;" class="goog-control">4:30pm</div>
            <div id=":45" style="-moz-user-select: none;" class="goog-control">5:00pm</div>
            <div id=":46" style="-moz-user-select: none;" class="goog-control">5:30pm</div>
            <div id=":47" style="-moz-user-select: none;" class="goog-control">6:00pm</div>
            <div id=":48" style="-moz-user-select: none;" class="goog-control">6:30pm</div>
            <div id=":49" style="-moz-user-select: none;" class="goog-control">7:00pm</div>
            <div id=":4a" style="-moz-user-select: none;" class="goog-control">7:30pm</div>
            <div id=":4b" style="-moz-user-select: none;" class="goog-control">8:00pm</div>
            <div id=":4c" style="-moz-user-select: none;" class="goog-control">8:30pm</div>
            <div id=":4d" style="-moz-user-select: none;" class="goog-control">9:00pm</div>
            <div id=":4e" style="-moz-user-select: none;" class="goog-control">9:30pm</div>
            <div id=":4f" style="-moz-user-select: none;" class="goog-control">10:00pm</div>
            <div id=":4g" style="-moz-user-select: none;" class="goog-control">10:30pm</div>
            <div id=":4h" style="-moz-user-select: none;" class="goog-control">11:00pm</div>
            <div id=":4i" style="-moz-user-select: none;" class="goog-control">11:30pm</div>
        </div>-->
    </body>
</html>
