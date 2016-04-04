<?php
require_once $homedir."vendor/phpmailer/phpmailer/PHPMailerAutoload.php";
if(isset($scrubbed["send"])) {
//    $ical = "BEGIN:VCALENDAR".
//            "VERSION:2.0".
//            "PRODID:-//hacksw/handcal//NONSGML v1.0//EN".
//            "BEGIN:VEVENT".
//            "UID:" . md5(uniqid(mt_rand(), true)) . "@yourhost.test".
//            "DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z".
//            "DTSTART:19970714T170000Z".
//            "DTEND:19970715T035959Z".
//            "SUMMARY:Bastille Day Party".
//            "END:VEVENT".
//            "END:VCALENDAR";
    
    //will have to deal with when blOptiSuggestion is both set, and not set.
    
    $warnings[] = "This button has not been fully implemented";
    
    
} else if(isset($scrubbed["createsend"])) {
    if($scrubbed["nmTitle"] == "" || $scrubbed["blAttendees"] == "[]") {
        if($scrubbed["blAttendees"] == "[]"){
            $warnings[] = "Your event must have at least 1 attendee to be saved.";
        } else {
            $warnings[] = "Your event must have a title to be saved.";
        }
    } else {
        $q1 = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'tblevents'";
        $q2 = "INSERT INTO `tblevents`(`nmTitle`, `dtStart`, `dtEnd`, `txLocation`, `txDescription`, `txRRule`, `nColorid`, `blSettings`, `blAttendees`, `blNotifications`, `isGuestInvite`, `isGuestList`, `enVisibility`, `isBusy`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $q3 = "INSERT INTO `tblusersevents`(`fkUserid`, `fkEventid`) VALUES (?,?)";
        
        if($stmt = $dbc->prepare($q1)){
            $stmt->execute();
            $stmt->bind_result($eventid);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        if($stmt = $dbc->prepare($q2)){
            $scrubbed["nColorid"] = (int) $scrubbed["nColorid"];
            $scrubbed["isGuestInvite"] = (int) $scrubbed["isGuestInvite"];
            $scrubbed["isGuestList"] = (int) $scrubbed["isGuestList"];
            $scrubbed["isBusy"] = (int) $scrubbed["isBusy"];
            $stmt->bind_param("ssssssisssiisi", $scrubbed["nmTitle"],$scrubbed["dtStart"],$scrubbed["dtEnd"],$scrubbed["txLocation"],$scrubbed["txDescription"],$scrubbed["txRRule"],$scrubbed["nColorid"],$scrubbed["blSettings"],$scrubbed["blAttendees"],$scrubbed["blNotifications"],$scrubbed["isGuestInvite"],$scrubbed["isGuestList"],$scrubbed["enVisibility"],$scrubbed["isBusy"]);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        if($stmt = $dbc->prepare($q3)){
            $stmt->bind_param("ii", $_SESSION["pkUserid"],$eventid);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        $notifications[] = "Your event has been successfully saved.";
    }
    
    //send code from above, to use only event data, as blOptiSuggestion will be unavailable.
    
    $warnings[] = "This button has not been fully implemented";
}

?>