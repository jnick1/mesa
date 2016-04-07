<?php
if(isset($scrubbed["resetpassword"])) {
    $q1 = "SELECT txEmail, blGet, dtExpires FROM tbltokens WHERE txTokenid = ?";
    $q2 = "DELETE FROM tbltokens WHERE txTokenid = ?";
    $q3 = "SELECT pkUserid, dtLogin FROM tblusers WHERE txEmail = ?";
    $q4 = "UPDATE `tblusers` SET `blSalt`=?,`txHash`=?,`dtLogin`=CURRENT_TIMESTAMP WHERE pkUserid = ?";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("s", $scrubbed["txTokenid"]);
        $stmt->execute();
        $stmt->bind_result($txEmail, $blGet, $dtExpiration);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if($txEmail) {
        if(time() - strtotime($dtExpiration)<0) {
            if(json_decode($blGet, true)["procedure"]=="resetpassword") {
                if($stmt = $dbc->prepare($q3)){
                    $stmt->bind_param("s", $txEmail);
                    $stmt->execute();
                    $stmt->bind_result($pkUserid, $dtLogin);
                    $stmt->fetch();
                    $stmt->free_result();
                    $stmt->close();
                }
                if($pkUserid) {
                    if($stmt = $dbc->prepare($q4)){
                        $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
                        $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM);
                        $hash = hash("sha256",$salt.$scrubbed["in-evt-resetpassword-password"]);
                        
                        $stmt->bind_param("ssi", $salt,$hash,$pkUserid);
                        $stmt->execute();
                        $stmt->free_result();
                        $stmt->close();
                    }
                    
                    if($stmt = $dbc->prepare($q2)){
                        $stmt->bind_param("s", $scrubbed["txTokenid"]);
                        $stmt->execute();
                        $stmt->free_result();
                        $stmt->close();
                    }
                    $_SESSION["pkUserid"] = $pkUserid;
                    $_SESSION["email"] = $txEmail;
                    $_SESSION["lastLogin"] = $dtLogin;
                    $_SESSION["userColor"] = "#".substr($hash, 0, 6);
                    unset($_SESSION["failedSignins"]);
                    unset($_SESSION["signinTimeout"]);
                    $notifications[] = "Your password has been successfully reset.";
                } else {
                    $errors[] = "Your user account could not be found. Please try again.";
                }
            } else {
                $errors[] = "Erroneous request intent indicated; unable to complete request.";
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