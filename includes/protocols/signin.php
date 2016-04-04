<?php
if(isset($scrubbed["signin"])) {
    $scrubbed["wpg-evt-signin-email"] = strtolower($scrubbed["wpg-evt-signin-email"]);
    $q1 = "SELECT blSalt, txHash FROM tblusers WHERE txEmail = ?";
    $q2 = "SELECT pkUserid, dtLogin FROM tblusers WHERE txHash = ?";
    $q3 = "UPDATE tblusers SET dtLogin = CURRENT_TIMESTAMP";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("s", $scrubbed["wpg-evt-signin-email"]);
        $stmt->execute();
        $stmt->bind_result($salt,$hash);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if(!empty($hash)){
        $hashGiven = hash("sha256",$salt.$scrubbed["wpg-evt-signin-password"]);
        if($hash === $hashGiven) {
            if($stmt = $dbc->prepare($q2)){
                $stmt->bind_param("s", $hashGiven);
                $stmt->execute();
                $stmt->bind_result($pkUserid, $lastLogin);
                $stmt->fetch();
                $stmt->free_result();
                $stmt->close();
            }
            if($stmt = $dbc->prepare($q3)){
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            $_SESSION["pkUserid"] = $pkUserid;
            $_SESSION["email"] = $scrubbed["wpg-evt-signin-email"];
            $_SESSION["lastLogin"] = $lastLogin;
            $_SESSION["userColor"] = "#".substr($hash, 0, 6);
        } else {
            $errors[] = "That combination of email and password is incorrect. Please try again.";
        }
    } else {
        $errors[] = "The user account you specified cannot be found. Please try again.";
    }
}
?>