<?php
if(isset($scrubbed["register"])) {
    if(isset($_SESSION["pkUserid"]) && is_numeric($_SESSION["pkUserid"])) {
        $warnings[] = "You cannot register a new user account while logged in.";
    } else {
        $q1 = "SELECT pkUserid FROM tblusers WHERE txEmail = ?";
        $q2 = "INSERT INTO `tblusers`(`txEmail`, `blSalt`, `txHash`, `dtLogin`) VALUES (?,?,?,?)";

        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("s", $scrubbed["in-evt-register-email"]);
            $stmt->execute();
            $stmt->bind_result($userExists);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        if($userExists) {
            $errors[] = "This email has already been registered. Please register using a different email address.";
        } else {
            $ivsize = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
            $salt = mcrypt_create_iv($ivsize, MCRYPT_DEV_URANDOM);
            $hash = hash("sha256",$salt.$scrubbed["in-evt-register-password"]);
            $login = gmdate("Y-m-d H:i:s");

            if($stmt = $dbc->prepare($q2)){
                $stmt->bind_param("ssss", $scrubbed["in-evt-register-email"],$salt,$hash,$login);
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            if($stmt = $dbc->prepare($q1)){
                $stmt->bind_param("s", $scrubbed["in-evt-register-email"]);
                $stmt->execute();
                $stmt->bind_result($pkUserid);
                $stmt->fetch();
                $stmt->free_result();
                $stmt->close();
            }
            $_SESSION["pkUserid"] = $pkUserid;
            $_SESSION["email"] = $scrubbed["in-evt-register-email"];
            $_SESSION["lastLogin"] = $login;
            $_SESSION["userColor"] = "#".substr($hash, 0, 6);
            $notifications[] = "Success! Your user account has been successfully created. We hope you enjoy your Mesa experience!";
        }
    }
}
?>