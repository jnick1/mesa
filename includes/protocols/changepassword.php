<?php
if(isset($scrubbed["changepassword"])) {
    if(isset($_SESSION["pkUserid"]) && is_numeric($_SESSION["pkUserid"])) {
        $q1 = "SELECT pkUserid FROM tblusers WHERE pkUserid = ?";
        $q2 = "SELECT blSalt, txHash FROM tblusers WHERE pkUserid = ?";
        $q3 = "UPDATE tblUsers SET blSalt = ?, txHash = ? WHERE pkUserid = ?";

        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("i", $_SESSION["pkUserid"]);
            $stmt->execute();
            $stmt->bind_result($userExists);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        if($userExists) {

            if($stmt = $dbc->prepare($q2)){
                $stmt->bind_param("i", $_SESSION["pkUserid"]);
                $stmt->execute();
                $stmt->bind_result($blSalt,$txHash);
                $stmt->fetch();
                $stmt->free_result();
                $stmt->close();
            }
            $hashC = hash("sha256",$blSalt.$scrubbed["wpg-evt-account-password"]);
            if($hashC === $txHash) {
                $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
                $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM);
                $hash = hash("sha256",$salt.$scrubbed["wpg-evt-account-newpassword"]);

                if($stmt = $dbc->prepare($q3)){
                    $stmt->bind_param("ssi", $salt,$hash,$_SESSION["pkUserid"]);
                    $stmt->execute();
                    $stmt->free_result();
                    $stmt->close();
                }
                $_SESSION["userColor"] = "#".substr($hash, 0, 6);
                $notifications[] = "Your password has been successfully updated.";
            } else {
                $errors[] = "Your password was incorrect. Please try again.";
            }
        } else {
            $errors[] = "We were unable to find your account to update your password. If you somehow manage to get this error message, you must be some sort of wizard.";
        }
    } else {
        $errors[] = "You must be signed in to change your password";
    }
}
?>