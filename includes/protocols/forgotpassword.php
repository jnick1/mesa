<?php
if(isset($scrubbed["forgotpassword"])) {
    $email = $scrubbed["email"];
    $q1 = "SELECT pkUserid FROM tblusers WHERE txEmail = ?";
    $q2 = "INSERT INTO `tbltokens`(`txEmail`, `blGet`, `txTokenid`, `dtExpires`) VALUES (?,?,?,?)";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($pkUserid);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if($pkUserid) {
        
        $gets = "localhost/mesa/index.php?t=";
        
        if($stmt = $dbc->prepare($q2)){
            $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
            $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM);
            $hash = hash("sha256", $salt);
            $blGet = [
                "procedure"=>"resetpassword"
            ];
            $blGet = json_encode($blGet);
            $dtExpiration = gmdate("Y-m-d H:i:s", time()+600);
            $gets.=$hash;
            
            $stmt->bind_param("ssss", $email, $blGet, $hash, $dtExpiration);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }

        include $homedir."../../secure/phpmailer_init.php";

        $mail->addAddress($email);

        $message = ""
                . "Hello,<br><br>"
                . ""
                . "This is an automated message sent by Mesa Organizer to reset your password.<br>"
                . "If you did not initiate this request, you may ignore this message.<br><br>"
                . ""
                . "Please click <a href=\"".$gets."\">here</a> to be redirected to where you can reset your password.<br>"
                . "Alternatively, if you cannot click the link above, please copy the link below into your browser: <br><a href=\"".$gets."\">".$gets."</a><br>"
                . "Upon clicking the link, you will be prompted to choose a new password. Your new password should not be the same as your previous password.<br><br>"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.<br><br>"
                . ""
                . "Thank you for using Mesa Organizer!";
        $altMessage = ""
                . "Hello,\n\n"
                . ""
                . "This is an automated message sent by Mesa Organizer to reset your password.\n"
                . "If you did not initiate this request, you may ignore this message.\n\n"
                . ""
                . "To be redirected to where you can reset your password, please copy the link below into your browser: \n".$gets."\n"
                . "Upon traveling to the link, you will be prompted to choose a new password. Your new password should not be the same as your previous password.\n\n"
                . ""
                . "Do not reply to this email, as it was sent from an unmonitored email address.\n\n"
                . ""
                . "Thank you for using Mesa Organizer!";

        $mail->Subject = "Mesa Organizer: Reset Password - ".date("F j, Y g:ia");
        $mail->Body    = $message;
        $mail->AltBody = $altMessage;

        if(!$mail->send()) {
            $errors[] = "Your access request email could not be sent. $mailnotsofail recipients were successfully emailed. Please include the following error message in support requests:";
            $errors[] = "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $notifications[] = "An email has been sent to the specifed address with a password reset request. Please follow the instructions in the email to continue.";
        }
    } else {
        $errors[] = "The specified account could not be found. Please try again.";
    }
} else if($t = filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING)) {
    $q1 = "SELECT blGet, txEmail, dtExpires FROM tbltokens WHERE txTokenid = ?";
    $q2 = "DELETE FROM tbltokens WHERE txTokenid = ?";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("s", $t);
        $stmt->execute();
        $stmt->bind_result($blGet, $txEmail, $dtExpiration);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if($txEmail) {
        if(time() - strtotime($dtExpiration)<0) {
            if(json_decode($blGet, true)["procedure"]=="resetpassword") {
                $_SESSION["resetpassword"] = true;
                $_SESSION["resetpassword-token"] = $t;
            }
        } else {
            if($stmt = $dbc->prepare($q2)){
                $stmt->bind_param("s", $t);
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            $errors[] = "The time to complete your request has expired.";
        }
    } else {
        $errors[] = "Invalid token; unable to complete request.";
    }
}
?>