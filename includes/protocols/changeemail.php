<?php
if(isset($scrubbed["changeemail"])) {
    if(isset($_SESSION["pkUserid"]) && is_numeric($_SESSION["pkUserid"])) {
        $q1 = "SELECT pkUserid FROM tblusers WHERE pkUserid = ?";
        $q2 = "UPDATE tblUsers SET txEmail = ? WHERE pkUserid = ?";

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
                $stmt->bind_param("si", $scrubbed["wpg-evt-account-email"],$_SESSION["pkUserid"]);
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            $notifications[] = "Your email has been successfully updated.";
            $_SESSION["email"] = $scrubbed["wpg-evt-account-email"];
        } else {
            $errors[] = "We were unable to find your account to update your email. If you somehow manage to get this error message, you must be some sort of wizard.";
        }
    } else {
        $errors[] = "You must be signed in to change your email.";
    }
}
?>