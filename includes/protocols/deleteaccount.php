<?php
if(isset($scrubbed["deleteaccount"])) {
    if(isset($_SESSION["pkUserid"]) && is_numeric($_SESSION["pkUserid"])) {
        $q1 = "SELECT pkUserid FROM tblusers WHERE pkUserid = ?";
        $q2 = "DELETE e FROM tblevents e JOIN tblusersevents u ON u.fkEventid = e.pkEventid WHERE u.fkUserid = ?";
        $q3 = "DELETE FROM tblusers WHERE pkUserid = ?";

        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("i", $_SESSION["pkUserid"]);
            $stmt->execute();
            $stmt->bind_result($userExists);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        if(!empty($userExists)){
            if($stmt = $dbc->prepare($q2)){
                $stmt->bind_param("i", $_SESSION["pkUserid"]);
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            if($stmt = $dbc->prepare($q3)){
                $stmt->bind_param("i", $_SESSION["pkUserid"]);
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            unset($_SESSION["pkUserid"]);
            unset($_SESSION["email"]);
            unset($_SESSION["lastLogin"]);
            unset($_SESSION["userColor"]);
        } else {
            $errors[] = "The specified user account could not be deleted. It may have already been removed.";
        }
    } else {
        $errors[] = "You must be signed in to delete your account.";
    }
}
?>