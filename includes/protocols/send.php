<?php
require_once $homedir."vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

function send_noopti_event($dbc, $scrubbed) {
    $q1 = "SELECT `nmTitle`, `dtStart`, `dtEnd`, `txLocation`, `txDescription`, `txRRule`, `nColorid`, `blAttendees`, `blNotifications`, `isGuestList`, `enVisibility`, `isBusy`, `dtCreated`, `dtLastUpdated` FROM `tblevents` WHERE pkEventid = ?";
    $q2 = "SELECT txEmail from tblusers JOIN tblusersevents ON tblusersevents.fkUserid = tblusers.pkUserid WHERE tblusersevents.fkEventid = ?";
    $pkEventid = $scrubbed["pkEventid"];
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("i",$pkEventid);
        $stmt->execute();
        $stmt->bind_result($nmTitle,$dtStart,$dtEnd,$txLocation,$txDescription,$txRRule,$nColorid,$blAttendees,$blNotifications,$isGuestList,$enVisibility,$isBusy,$dtCreated,$dtLastUpdated);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if($stmt = $dbc->prepare($q2)){
        $stmt->bind_param("i",$pkEventid);
        $stmt->execute();
        $stmt->bind_result($txEmail);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    $icals = [];
    $attendees = json_decode($blAttendees, true);
    $notifications = json_decode($blNotifications, true);
    $uidhelper = time();
    foreach($attendees as $attendee) {
        $ical = "BEGIN:VCALENDAR"."\n"
                . "PRODID:-//CSE280//MESA Organizer//EN"."\n"
                . "VERSION:2.0"."\n"
                . "CALSCALE:GREGORIAN"."\n"
                . "METHOD:PUBLISH"."\n"
                . "BEGIN:VEVENT"."\n"
                . "DTSTART:".str_replace(" ","T",str_replace(array("-",":"),"",$dtStart))."Z"."\n"
                . "DTEND:".str_replace(" ","T",str_replace(array("-",":"),"",$dtEnd))."Z"."\n";
        if(!empty($txRRule)){
            $ical.= "RRULE:$txRRule"."\n";
        }
        $ical.= "DTSTAMP:".str_replace(" ","T",str_replace(array("-",":"),"",$dtCreated))."Z"."\n"
                . "UID:".hash("sha256",$pkEventid.$uidhelper)."@mesaorganizer"."\n"
                . "ORGANIZER:MAILTO:$txEmail"."\n";
        if($isGuestList) {
            foreach($attendees as $attendee2){
                if($attendee["email"] != $attendee2["email"]) {
                    $ical.="ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=".($attendee2["optional"]?"OPT":"REQ")."-PARTICIPANT"
                        .";PARTSTAT=".str_replace(" ","-",strtoupper($attendee2["responseStatus"])).";X-NUM-GUESTS=0"
                        .":MAILTO:".$attendee2["email"]."\n";
                }
            }
        }
        if($enVisibility=="public" || $enVisibility=="private") {
            $ical.="CLASS=".strtoupper($enVisibility)."\n";
        }
        $ical.="CREATED:".str_replace(" ","T",str_replace(array("-",":"),"",$dtCreated))."Z"."\n"
                . "DESCRIPTION:$txDescription"."\n"
                . "LAST-MODIFIED:".str_replace(" ","T",str_replace(array("-",":"),"",$dtLastUpdated))."Z"."\n"
                . "LOCATION:$txLocation"."\n"
                . "SEQUENCE:0"."\n"
                . "STATUS:CONFIRMED"."\n"
                . "SUMMARY:$nmTitle"."\n"
                . "TRANSP:".($isBusy?"OPAQUE":"TRANSPARENT")."\n";
        if(count($notifications["overrides"])>0) {
            foreach($notifications["overrides"] as $notification) {
                $ical.="BEGIN:VALARM"."\n"
                        . "ACTION:".($notification["method"]=="popup"?"DISPLAY":"EMAIL")."\n"
                        . "DESCRIPTION:This is an event reminder"."\n"
                        . "TRIGGER:-P".(floor($notification["minutes"]/1440))."D".($notification["minutes"]%1440!=0?((floor(($notification["minutes"]%1440)/60))."H".($notification["minutes"]%60)."M0S"):"")."\n";
                if($notification["method"]=="email") {
                    $ical.="SUMMARY:Alarm notification"."\n"
                            . "ATTENDEE:MAILTO:".$attendee["email"]."\n";
                }
                $ical.="END:VALARM"."\n";
            }
        }
        $ical.="END:VEVENT"."\n"
                . "END:VCALENDAR"."\n";
        $icals[$attendee["email"]] = $ical;
    }
    
    $mail = new PHPMailer;
    $mailfail = false;
    $mailnotsofail = 0;
    
    $mail->Timeout = 10;
    
    $mail->isSMTP();                                // Set mailer to use SMTP
    $mail->CharSet="UTF-8";
    $mail->Host = "smtp.gmail.com";                 // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                         // Enable SMTP authentication
    $mail->Username = "mesaorganizer@gmail.com";    // SMTP username
    $mail->Password = "wicora thicsh";              // SMTP password
    $mail->SMTPSecure = "ssl";                      // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                              // TCP port to connect to
    
    $mail->setFrom("mesaorganizer@gmail.com", "Mesa Organizer");
    $mail->addReplyTo("mesaorganizer@gmail.com", "Mesa Organizer");
    $mail->isHTML(true);                            // Set email format to HTML
    
    foreach($attendees as $attendee) {
        $mail->clearAddresses();
        $mail->clearAttachments();
        $mail->addAddress($attendee["email"]);
        
        $message = ""
                . "Hello,<br><br>"
                . ""
                . "This is an automated message sent by Mesa Organizer send you details for an event you've been invited to.<br>"
                . "You have been invited by <b>$txEmail</b> to attend an event/meeting titled: <b><i>$nmTitle</i></b><br>"
                . "Your attendance for this event has been marked as <b>".($attendee["optional"]?"optional":"required")."</b>.<br><br>"
                . ""
                . "Attached to this email, you will find an ICalendar (.ics) file which you may import into your calendar to add the event and any relevant information.<br>"
                . "If you would rather add this event to a different account's calendar than the one "
                . "this email was sent to, feel free to do so (for instance, if your calendar is saved on your personal email, but this was sent to your work email).<br><br>"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.<br><br>"
                . ""
                . "Thank you for using Mesa Organizer!";
        $altMessage = ""
                . "Hello,\n\n"
                . ""
                . "This is an automated message sent by Mesa Organizer send you details for an event you've been invited to.\n"
                . "You have been invited by $txEmail to attend an event/meeting titled: $nmTitle\n"
                . "Your attendance for this event has been marked as ".($attendee["optional"]?"optional":"required").".\n\n"
                . ""
                . "Attached to this email, you will find an ICalendar (.ics) file which you may import into your calendar to add the event and any relevant information.\n"
                . "If you would rather add this event to a different account's calendar than the one "
                . "this email was sent to, feel free to do so (for instance, if your calendar is saved on your personal email, but this was sent to your work email).\n\n"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.\n\n"
                . ""
                . "Thank you for using Mesa Organizer!";
        
        $mail->Subject = "Mesa Organizer: Event Invite: $nmTitle";
        $mail->Body    = $message;
        $mail->AltBody = $altMessage;
        $mail->addStringAttachment($icals[$attendee["email"]], str_replace(" ", "_", $nmTitle), "base64", "text/calendar");
        
        if(!$mail->send()) {
            $mailfail = true;
            break;
        } else {
            $mailnotsofail++;
        }
    }
    if($mailfail) {
        return array(
            "error"=>"Your event invite email could not be sent. $mailnotsofail recipients were successfully emailed. Please include the following error message in support requests:",
            "error2"=>"Mailer Error: " . $mail->ErrorInfo);
    } else {
        return array(
            "notification"=>"Your attendees have been sent an email containing all the details of your event. Thank you for using Mesa Organizer!"
            );
    }
}

if(isset($scrubbed["send"])) {
    if($scrubbed["optiran"] != "false") {
        
        $warnings[] = "This button has not been fully implemented";
        
        $q1 = "SELECT `blOptiSuggestion`, `nmTitle`, `txDescription`, `blNotifications`, `isGuestList`, `enVisibility`, `isBusy`, `dtCreated`, `dtLastUpdated` FROM `tblevents` WHERE pkEventid = ?";
        $q2 = "SELECT txEmail from tblusers JOIN tblusersevents ON tblusersevents.fkUserid = tblusers.pkUserid WHERE tblusersevents.fkEventid = ?";
        $pkEventid = $scrubbed["pkEventid"];
        
        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("i",$scrubbed["pkEventid"]);
            $stmt->execute();
            $stmt->bind_result($blOptiSuggestion,$nmTitle,$txDescription,$blNotifications,$isGuestList,$enVisibility,$isBusy,$dtCreated,$dtLastUpdated);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        if($stmt = $dbc->prepare($q2)){
            $stmt->bind_param("i",$pkEventid);
            $stmt->execute();
            $stmt->bind_result($txEmail);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
    } else {
        $output = send_noopti_event($dbc, $scrubbed);
        foreach($output as $notif => $info) {
            switch(substr($notif,0,5)){
                case "notif":
                    $notifications[] = $info;
                    break;
                case "warni":
                    $warnings[] = $info;
                    break;
                case "error":
                    $errors[] = $info;
                    break;
                default:
                    $errors[] = $info;
            }
        }
    }
} else if(isset($scrubbed["createsend"])) {
    if($scrubbed["nmTitle"] == "" || $scrubbed["blAttendees"] == "[]") {
        if($scrubbed["blAttendees"] == "[]"){
            $warnings[] = "Your event must have at least 1 attendee to be saved.";
        } else {
            $warnings[] = "Your event must have a title to be saved.";
        }
    } else {
        $q1 = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'tblevents'";
        $q2 = "INSERT INTO `tblevents`(`nmTitle`, `dtStart`, `dtEnd`, `txLocation`, `txDescription`, `txRRule`, `nColorid`, `blSettings`, `blAttendees`, `blNotifications`, `isGuestList`, `enVisibility`, `isBusy`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
            $scrubbed["isGuestList"] = (int) $scrubbed["isGuestList"];
            $scrubbed["isBusy"] = (int) $scrubbed["isBusy"];
            $stmt->bind_param("ssssssisssisi", $scrubbed["nmTitle"],$scrubbed["dtStart"],$scrubbed["dtEnd"],$scrubbed["txLocation"],$scrubbed["txDescription"],$scrubbed["txRRule"],$scrubbed["nColorid"],$scrubbed["blSettings"],$scrubbed["blAttendees"],$scrubbed["blNotifications"],$scrubbed["isGuestList"],$scrubbed["enVisibility"],$scrubbed["isBusy"]);
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
    $output = send_noopti_event($dbc, $scrubbed);
    foreach($output as $notif => $info) {
        switch(substr($notif,0,5)){
            case "notif":
                $notifications[] = $info;
                break;
            case "warni":
                $warnings[] = $info;
                break;
            case "error":
                $errors[] = $info;
                break;
            default:
                $errors[] = $info;
        }
    }
}
?>
