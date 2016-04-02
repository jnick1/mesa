<?php
require $homedir."vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

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
    
    echo var_dump($attendees);
    
    foreach($attendees as $attendee) {
        $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
        $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM); //salt added only so that the same tokenid isn't generated multiple times
        $hash = hash("sha256", $salt); //as these commands will be run very quickly
        
        $gets[] = "?e=$pkEventid&t=$hash";
        if($stmt = $dbc->prepare($q3)){
            $stmt->bind_param("ss", $attendee["email"], $hash);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
    }
    
    
//    
//    
//    $message = "Hello,<br>";
//    $altMessage = "";
//    
//    $mail = new PHPMailer;
//
//    $mail->SMTPDebug = 1;                           // Enable verbose debug output
//    $mail->Timeout = 10;
//
//    $mail->isSMTP();                                // Set mailer to use SMTP
//    $mail->CharSet="UTF-8";
//    $mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
//    $mail->SMTPAuth = true;                         // Enable SMTP authentication
//    $mail->Username = 'mesaorganizer@gmail.com';    // SMTP username
//    $mail->Password = 'wicora thicsh';              // SMTP password
//    $mail->SMTPSecure = 'ssl';                      // Enable TLS encryption, `ssl` also accepted
//    $mail->Port = 465;                              // TCP port to connect to
//    
//    $mail->setFrom('mesaorganizer@gmail.com', 'Mesa Organizer');
//    $mail->addAddress('janick@oakland.edu');
//    $mail->addReplyTo('mesaorganizer@gmail.com', 'Mesa Organizer');
//    
//    $mail->isHTML(true);                            // Set email format to HTML
//    
//    $mail->Subject = 'Mesa Organizer: Request for Calendar Access';
//    $mail->Body    = $message;
//    $mail->AltBody = $altMessage;
//
//    if(!$mail->send()) {
//        $errors[] = "Your access request email could not be sent. Please include the following error message in support requests:";
//        $errors[] = 'Mailer Error: ' . $mail->ErrorInfo;
//    } else {
//        $notifications[] = "Your attendees have been sent a request to access their calendars. Mesa Organizer will notify you when a attendees has reponded".
//                " on the event page. Please allow some time for all attendees to respond.";
//    }
} else if(isset($scrubbed["createrequest"])) {
    
}

?>