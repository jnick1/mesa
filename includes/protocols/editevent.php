<?php
if(isset($scrubbed["editevent"])) {
    $q1 = "SELECT `blOptiSuggestion`, `nmTitle`, `dtStart`, `dtEnd`, `txLocation`, `txDescription`, `txRRule`, `nColorid`, `blSettings`, `blAttendees`, `blNotifications`, `isGuestInvite`, `isGuestList`, `enVisibility`, `isBusy`, `dtRequestSent` FROM `tblevents` WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("i",$scrubbed["pkEventid"]);
        $stmt->execute();
        $stmt->bind_result($blOptiSuggestion,$nmTitle,$dtStart,$dtEnd,$txLocation,$txDescription,$txRRule,$nColorid,$blSettings,$blAttendees,$blNotifications,$isGuestInvite,$isGuestList,$enVisibility,$isBusy,$dtRequestSent);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
}
?>