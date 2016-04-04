<?php
require_once $homedir."vendor/phpmailer/phpmailer/PHPMailerAutoload.php";
if(isset($scrubbed["request"])) {
    $pkEventid = $scrubbed["pkEventid"];
    $q1 = "SELECT nmTitle, blAttendees FROM tblevents WHERE pkEventid = ?";
    $q2 = "SELECT txEmail FROM tblusers JOIN tblusersevents ON tblusersevents.fkUserid = tblusers.pkUserid WHERE tblusersevents.fkEventid = ?";
    $q3 = "INSERT INTO `tbltokens`(`txEmail`, `txTokenid`) VALUES (?,?)";
    $q4 = "UPDATE `tblevents` SET `dtRequestSent`=CURRENT_TIMESTAMP WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("i", $pkEventid);
        $stmt->execute();
        $stmt->bind_result($nmTitle,$blAttendees);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if($stmt = $dbc->prepare($q2)){
        $stmt->bind_param("i", $pkEventid);
        $stmt->execute();
        $stmt->bind_result($organizerEmail);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    
    $attendees = json_decode($blAttendees, true);
    $gets = [];
    
    if($stmt = $dbc->prepare($q3)){
        foreach($attendees as $attendee) {
            $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
            $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM); //salt used only so that the same tokenid isn't generated multiple times
            $hash = hash("sha256", $salt); //as these commands will be run very quickly (multiple times per second, which time() wouldn't be able to keep up with)

            $gets[$attendee["email"]] = "localhost/mesa/services/oauth2access.php?e=$pkEventid&t=$hash";
            $stmt->bind_param("ss", $attendee["email"], $hash);
            $stmt->execute();
        }
        $stmt->free_result();
        $stmt->close();
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
        $mail->addAddress($attendee["email"]);
        
        $message = ""
                . "Hello,<br><br>"
                . ""
                . "This is an automated message sent by Mesa Organizer to request access to your Google Calendar.<br>"
                . "Your calendar information is being requested by <b>$organizerEmail</b> in order to plan an event/meeting titled: <b><i>$nmTitle</i></b><br>"
                . "Your attendance for this event has been marked as <b>".($attendee["optional"]?"optional":"required")."</b>.<br><br>"
                . ""
                . "Please click <a href=\"".$gets[$attendee["email"]]."\">here</a> to be redirected to where you can submit your calendar information.<br>"
                . "Alternatively, if you cannot click the link above, please copy the link below into your browser: <br><a href=\"".$gets[$attendee["email"]]."\">".$gets[$attendee["email"]]."</a><br>"
                . "Upon clicking the link, you will be prompted to log in to your Google account. If you would rather sign in with a different account than the one "
                . "this email was sent to, feel free to do so (for instance, if your calendar is saved on your personal email, but this was sent to your work email).<br><br>"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.<br><br>"
                . ""
                . "Thank you for using Mesa Organizer!";
        $altMessage = ""
                . "Hello,\n\n"
                . ""
                . "This is an automated message sent by Mesa Organizer to request access to your Google Calendar.\n"
                . "Your calendar information is being requested by $organizerEmail in order to plan an event/meeting titled: $nmTitle\n\n"
                . "Your attendance for this event has been marked as ".($attendee["optional"]?"optional":"required").".\n\n"
                . ""
                . "To be redirected to where you can submit your calendar information, please copy the link below into your browser: \n".$gets[$attendee["email"]]." .\n"
                . "Upon clicking the link, you will be prompted to log in to your Google account. If you would rather sign in with a different account than the one "
                . "this email was sent to, feel free to do so (for instance, if your calendar is saved on your personal email, but this was sent to your work email).\n\n"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.\n\n"
                . ""
                . "Thank you for using Mesa Organizer!";
        
        $mail->Subject = "Mesa Organizer: Request for Calendar Access: $nmTitle";
        $mail->Body    = $message;
        $mail->AltBody = $altMessage;
        
        if(!$mail->send()) {
            $mailfail = true;
            break;
        } else {
            $mailnotsofail++;
        }
    }
    if($mailfail) {
        $errors[] = "Your access request email could not be sent. $mailnotsofail recipients were successfully emailed. Please include the following error message in support requests:";
        $errors[] = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        if($stmt = $dbc->prepare($q4)){
            $stmt->bind_param("i", $pkEventid);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        $notifications[] = "Your attendees have been sent a request to access their calendars. Mesa Organizer will notify you when a attendees has reponded".
                " on the event page. Please allow some time for all attendees to respond.";
    }
} else if(isset($scrubbed["createrequest"])) {
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
            $scrubbed["isGuestInvite"] = (int) $scrubbed["isGuestInvite"];
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
    $pkEventid = $eventid;
    $q1 = "SELECT nmTitle, blAttendees FROM tblevents WHERE pkEventid = ?";
    $q2 = "SELECT txEmail FROM tblusers JOIN tblusersevents ON tblusersevents.fkUserid = tblusers.pkUserid WHERE tblusersevents.fkEventid = ?";
    $q3 = "INSERT INTO `tbltokens`(`txEmail`, `txTokenid`) VALUES (?,?)";
    $q4 = "UPDATE `tblevents` SET `dtRequestSent`=CURRENT_TIMESTAMP WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("i", $pkEventid);
        $stmt->execute();
        $stmt->bind_result($nmTitle,$blAttendees);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if($stmt = $dbc->prepare($q2)){
        $stmt->bind_param("i", $pkEventid);
        $stmt->execute();
        $stmt->bind_result($organizerEmail);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    
    $attendees = json_decode($blAttendees, true);
    $gets = [];
    
    if($stmt = $dbc->prepare($q3)){
        foreach($attendees as $attendee) {
            $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
            $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM); //salt used only so that the same tokenid isn't generated multiple times
            $hash = hash("sha256", $salt); //as these commands will be run very quickly (multiple times per second, which time() wouldn't be able to keep up with)

            $gets[$attendee["email"]] = "localhost/mesa/services/oauth2access.php?e=$pkEventid&t=$hash";
            $stmt->bind_param("ss", $attendee["email"], $hash);
            $stmt->execute();
        }
        $stmt->free_result();
        $stmt->close();
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
        $mail->addAddress($attendee["email"]);
        
        $message = ""
                . "Hello,<br><br>"
                . ""
                . "This is an automated message sent by Mesa Organizer to request access to your Google Calendar.<br>"
                . "Your calendar information is being requested by <b>$organizerEmail</b> in order to plan an event/meeting titled: <b><i>$nmTitle</i></b><br>"
                . "Your attendance for this event has been marked as <b>".($attendee["optional"]?"optional":"required")."</b>.<br><br>"
                . ""
                . "Please click <a href=\"".$gets[$attendee["email"]]."\">here</a> to be redirected to where you can submit your calendar information.<br>"
                . "Alternatively, if you cannot click the link above, please copy the link below into your browser: <br><a href=\"".$gets[$attendee["email"]]."\">".$gets[$attendee["email"]]."</a><br>"
                . "Upon clicking the link, you will be prompted to log in to your Google account. If you would rather sign in with a different account than the one "
                . "this email was sent to, feel free to do so (for instance, if your calendar is saved on your personal email, but this was sent to your work email).<br><br>"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.<br><br>"
                . ""
                . "Thank you for using Mesa Organizer!";
        $altMessage = ""
                . "Hello,\n\n"
                . ""
                . "This is an automated message sent by Mesa Organizer to request access to your Google Calendar.\n"
                . "Your calendar information is being requested by $organizerEmail in order to plan an event/meeting titled: $nmTitle\n\n"
                . "Your attendance for this event has been marked as ".($attendee["optional"]?"optional":"required").".\n\n"
                . ""
                . "To be redirected to where you can submit your calendar information, please copy the link below into your browser: \n".$gets[$attendee["email"]]." .\n"
                . "Upon clicking the link, you will be prompted to log in to your Google account. If you would rather sign in with a different account than the one "
                . "this email was sent to, feel free to do so (for instance, if your calendar is saved on your personal email, but this was sent to your work email).\n\n"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.\n\n"
                . ""
                . "Thank you for using Mesa Organizer!";
        
        $mail->Subject = "Mesa Organizer: Request for Calendar Access: $nmTitle";
        $mail->Body    = $message;
        $mail->AltBody = $altMessage;
        
        if(!$mail->send()) {
            $mailfail = true;
            break;
        } else {
            $mailnotsofail++;
        }
    }
    if($mailfail) {
        $errors[] = "Your access request email could not be sent. $mailnotsofail recipients were successfully emailed. Please include the following error message in support requests:";
        $errors[] = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        if($stmt = $dbc->prepare($q4)){
            $stmt->bind_param("i", $pkEventid);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        $notifications[] = "Your attendees have been sent a request to access their calendars. Mesa Organizer will notify you when a attendees has reponded".
                " on the event page. Please allow some time for all attendees to respond.";
    }
}
?>
