<?php
if(isset($scrubbed["delete"])) {
    $q1 = "DELETE FROM tblevents WHERE pkEventid = ? LIMIT 1";
    $q2 = "DELETE FROM tblusersevents WHERE fkEventid = ? AND fkUserid = ?";
    $q3 = "SELECT pkEventid FROM tblevents WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q3)){
        $stmt->bind_param("i", $scrubbed["pkEventid"]);
        $stmt->execute();
        $stmt->bind_result($eventExists);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if(!empty($eventExists)){
        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("i", $scrubbed["pkEventid"]);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        if($stmt = $dbc->prepare($q2)){
            $stmt->bind_param("ii", $scrubbed["pkEventid"],$_SESSION["pkUserid"]);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        $notifications[] = "Your event has been successfully deleted.";
    } else {
        $warnings[] = "The event specified cannot be found. It has likely already been deleted.";
    }
    
}
?>