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
if(isset($scrubbed["signout"])) {
    unset($_SESSION["pkUserid"]);
    unset($_SESSION["email"]);
    unset($_SESSION["lastLogin"]);
}
if(isset($scrubbed["delete"])) {
    $q1 = "DELETE FROM tblevents WHERE pkEventid = ? LIMIT 1";
    $q2 = "DELETE FROM tblusersevents WHERE fkEventid = ? AND fkUserid = ?";
    $q3 = "SELECT pkEventid FROM tblevents WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q3)){
        $stmt->bind_param("i", $scrubbed["pkEventid"]);
        $stmt->bind_result($eventExists);
        $stmt->fetch();
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
    }
    if(!empty($eventExists)){
        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("i", $scrubbed["pkEventid"]);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        if($stmt = $dbc->prepare($q2)){
            $stmt->bind_param("ii", $scrubbed["pkEventid"],$_SESSION["pkUserid"]);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        $notifications[] = "Your event has been successfully deleted.";
    } else {
        $warnings[] = "The event specified cannot be found. It has likely already been deleted.";
    }
    
}

if(empty($_SESSION["pkUserid"])){
    header("location: $homedir"."index.php");
}
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
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/el.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.structure.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.theme.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
        <script type="text/javascript" src="<?php echo $homedir."java/el-buttons.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/el-modify.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/el-time.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        
        
        <title>Meeting and Event Scheduling Assistant: Events List</title>
    </head>
    <body>
        <div id="wpg" class="<?php echo "uluru".rand(1,6); ?>">
            <div id="el-header" class="ui-container-section">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
                <div id="el-top-buttons">
                    <div id="el-btn-create-wrapper" class="wrapper-btn-all wrapper-btn-action">
                        <div id="el-btn-create" title="Create a new event"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Create
                        </div>
                    </div>
                </div>
            </div>
            <div id="el-content">
                <table>
                    <tbody>
                        <?php 
                        //order: Color id, Title, Start date, Start time, End time, End date, Truncated description, Edit, Delete
                        
                        $q1 = "SELECT pkEventid, nmTitle, dtStart, dtEnd, txDescription, nColorid FROM tblevents JOIN tblusersevents ON tblusersevents.fkUserid = ? WHERE tblevents.pkEventid = tblusersevents.fkEventid;";
                        
                        $events = [];
                        
                        if($stmt = $dbc->prepare($q1)) {
                            $stmt->bind_param("i", $_SESSION["pkUserid"]);
                            $stmt->execute();
                            $stmt->bind_result($pkEventid, $nmTitle, $dtStart, $dtEnd, $txDescription, $nColorid);
                            while($stmt->fetch()) {
                                $events[] = [
                                    "pkEventid"=>$pkEventid,
                                    "nmTitle"=>$nmTitle,
                                    "dtStart"=>$dtStart,
                                    "dtEnd"=>$dtEnd,
                                    "txDescription"=>$txDescription,
                                    "nColorid"=>$nColorid
                                        ];
                            }
                            $stmt->free_result();
                            $stmt->close();
                        }
                        for($i=0;$i<count($events);$i++) { ?>
                        <tr class="el-content-event">
                            <td>
                                <div class="el-content-event-colorcircle-wrapper">
                                    <div class="el-content-event-colorcircle el-content-event-colorcircle<?php echo $events[$i]["nColorid"]; ?>"></div>
                                </div>
                            </td>
                            <th class="el-content-event-title">
                                <?php echo $events[$i]["nmTitle"]; ?>
                            </th>
                            <td class="el-content-event-date">
                                <?php
                                $sd = date_parse($events[$i]["dtStart"]);
                                echo $sd["month"]."/".$sd["day"]."/".$sd["year"];
                                ?>
                            </td>
                            <td id="el-content-event-time<?php echo $i; ?>" class="el-content-event-time">
                                <?php
                                $st = date_parse($events[$i]["dtStart"]);
                                echo $st["hour"].":".$st["minute"];
                                ?>
                            </td>
                            <td id="el-content-event-time<?php echo $i+count($events); ?>" class="el-content-event-time">
                                <?php
                                $et = date_parse($events[$i]["dtEnd"]);
                                echo $et["hour"].":".$et["minute"];
                                ?>
                            </td>
                            <td class="el-content-event-date">
                                <?php
                                $ed = date_parse($events[$i]["dtEnd"]);
                                echo $ed["month"]."/".$ed["day"]."/".$ed["year"];
                                ?>
                            </td>
                            <td class="el-content-event-description-wrapper">
                                <div class="el-content-event-description">
                                    <?php echo $events[$i]["txDescription"]; ?>
                                </div>
                            </td>
                            <td class="el-content-event-edit">
                                <div class="wrapper-btn-all wrapper-btn-general">
                                    <div id="el-btn-edit<?php echo $events[$i]["pkEventid"]; ?>" class="el-btn-edit" title="Edit event"<?php echo " tabindex=\"".$ti++."\"";?>>
                                        Edit
                                    </div>
                                </div>
                            </td>
                            <td class="el-content-event-x-wrapper">
                                <div id="el-btn-delete<?php echo $events[$i]["pkEventid"]; ?>" class="goog-icon goog-icon-x-medium el-content-event-x"<?php echo " tabindex=\"".$ti++."\"";?>></div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            include $homedir."includes/pageassembly/footer.php";
            ?>
        </div>
        <div id="el-delete-wrapper" class="ui-popup">
            <div id="el-delete-dialogbox" class="ui-dialogbox">
                <div id="el-delete-header">
                    <span class="ui-header">Delete event</span>
                    <span id="el-delete-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                </div>
                <div id="el-delete-content-wrapper">
                    Are you sure you want to delete this event?
                </div>
                <div id="el-delete-btns">
                    <div class="wrapper-btn-general wrapper-btn-all el-btns-popups">
                        <div id="el-delete-btn-yes" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Yes
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all el-btns-popups">
                        <div id="el-delete-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
