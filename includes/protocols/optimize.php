<?php
if(isset($scrubbed["optimize"])) {
    $warnings[] = "This button has not been fully implemented yet.";
    $pkEventid = $scrubbed["pkEventid"];
    exec("python \"".$homedir."python/OptCode.py\" $pkEventid", $output);
    $blCalendar = implode("\n",$output);
    
    $q1 = "UPDATE tblevents SET blOptiSuggestion = ? WHERE pkEventid = ?";
    $q2 = "SELECT nmTitle FROM tblevents WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("si", $blCalendar,$pkEventid);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
    }
    if($stmt = $dbc->prepare($q2)){
        $stmt->bind_param("i", $pkEventid);
        $stmt->execute();
        $stmt->bind_result($nmTitle);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    $notifications[] = "Mesa has finished calculating optimal meeting times, return to the event page for <b><i>$nmTitle</i></b> to view suggestions.";
}
?>