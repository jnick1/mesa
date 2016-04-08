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
        if(isset($_SESSION["signinTimeout"])) {
            if(time() - $_SESSION["signinTimeout"] >= 60) {
                unset($_SESSION["failedSignins"]);
                unset($_SESSION["signinTimeout"]);
            } else {
                $warnings[] = "You have been temporarily locked out of signing in to an account due to repeated failed attempts. Please wait 1 minute before trying again.";
            }
        }
        if(!isset($_SESSION["signinTimeout"])) {
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
                unset($_SESSION["failedSignins"]);
                unset($_SESSION["signinTimeout"]);
            } else {
                $errors[] = "That combination of email and password is incorrect. Please try again.";
                if(isset($_SESSION["failedSignins"])) {
                    $_SESSION["failedSignins"]++;
                    if($_SESSION["failedSignins"] >= 4) {
                        $_SESSION["signinTimeout"] = time();
                    }
                } else {
                    $_SESSION["failedSignins"] = 1;
                }
            }
        }
    } else {
        $errors[] = "The user account you specified cannot be found. Please try again.";
    }
}
?>