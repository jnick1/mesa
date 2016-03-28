<?php
if(isset($scrubbed["saveedit"])) {
    if($scrubbed["nmTitle"] == "" || $scrubbed["blAttendees"] == "[]") {
        if($scrubbed["blAttendees"] == "[]"){
            $warnings[] = "Your event must have at least 1 attendee to be saved.";
        } else {
            $warnings[] = "Your event must have a title to be saved.";
        }
    } else {
        $q1 = "SELECT fkUserid FROM tblusersevents WHERE fkEventid = ?";
        $q2 = "UPDATE `tblevents` SET `nmTitle`=?,`dtStart`=?,`dtEnd`=?,`txLocation`=?,`txDescription`=?,`txRRule`=?,`nColorid`=?,`blSettings`=?,`blAttendees`=?,`blNotifications`=?,`isGuestInvite`=?,`isGuestList`=?,`enVisibility`=?,`isBusy`=? WHERE pkEventid = ?";
        
        if($stmt = $dbc->prepare($q1)){
            $stmt->bind_param("i",$scrubbed["pkEventid"]);
            $stmt->execute();
            $stmt->bind_result($owner);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        if($owner === $_SESSION["pkUserid"]) {
            if($stmt = $dbc->prepare($q2)){
                $scrubbed["nColorid"] = (int) $scrubbed["nColorid"];
                $scrubbed["isGuestInvite"] = (int) $scrubbed["isGuestInvite"];
                $scrubbed["isGuestList"] = (int) $scrubbed["isGuestList"];
                $scrubbed["isBusy"] = (int) $scrubbed["isBusy"];
                $scrubbed["pkEventid"] = (int) $scrubbed["pkEventid"];
                $stmt->bind_param("ssssssisssiisii", $scrubbed["nmTitle"],$scrubbed["dtStart"],$scrubbed["dtEnd"],$scrubbed["txLocation"],$scrubbed["txDescription"],$scrubbed["txRRule"],$scrubbed["nColorid"],$scrubbed["blSettings"],$scrubbed["blAttendees"],$scrubbed["blNotifications"],$scrubbed["isGuestInvite"],$scrubbed["isGuestList"],$scrubbed["enVisibility"],$scrubbed["isBusy"],$scrubbed["pkEventid"]);
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            $notifications[] = "Your event has been successfully saved.";
        } else {
            $errors[] = "You do not have permission to modify this event.";
        }
        
    }
}
?>