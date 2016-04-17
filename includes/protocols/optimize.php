<?php
if(isset($scrubbed["optimize"])) {
    $warnings[] = "This button has not been fully implemented yet.";
    $pkEventid = $scrubbed["pkEventid"];
    
    $q1 = "SELECT blCalendar FROM tblcalendars cals JOIN tblusers users ON users.pkUserid = cals.fkUserid WHERE cals.fkEventid = ? AND users.txEmail = ?";
    $q5 = "SELECT blAttendees FROM tblevents WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($q5)){
        $stmt->bind_param("i", $pkEventid);
        $stmt->execute();
        $stmt->bind_result($blAttendees);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    $attendees = json_decode($blAttendees, true);
    $calendars = [];
    foreach($attendees as $attendee) {
        if($attendee["responseStatus"]=="accepted") {
            if($stmt = $dbc->prepare($q1)){
                $stmt->bind_param("is", $pkEventid, $attendee["email"]);
                $stmt->execute();
                $stmt->bind_result($blCalendar);
                $stmt->fetch();
                $calendars[$attendee["email"]] = $blCalendar;
                $calendars["attendance"][$attendee["email"]] = $attendee["optional"];
                $stmt->free_result();
                $stmt->close();
            }
        }
    }
    if(count($calendars) != 0) {
        
        $q2 = "SELECT dtStart, dtEnd, txLocation, blSettings, txRRule FROM tblevents WHERE pkEventid = ?";
        
        if($stmt = $dbc->prepare($q2)){
            $stmt->bind_param("i", $pkEventid);
            $stmt->execute();
            $stmt->bind_result($dtStart, $dtEnd, $txLocation, $blSettings, $txRRule);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        
        $calendars = json_encode($calendars);
//        file_put_contents($homedir."python/temp1.json", $calendars);
//        file_put_contents($homedir."python/temp2.json", $blSettings);
//        exec("python \"".$homedir."python/optimize.py\" \"$dtStart\" \"$dtEnd\" \"$txLocation\" \"$txRRule\" 2>&1", $output, $err);
//        $blOptiSuggestion = implode("\n",$output);
        
        $blOptiSuggestion = "
        {
            \"0\": { 
                \"0\": {
                    \"start\":\"2016-04-06T16:00:00Z\",
                    \"end\":\"2016-04-06T17:00:00Z\",
                    \"location\":\"Location1\",
                    \"cost\":\"3\",
                    \"id\":\"0\",
                    \"attendees\": {
                        \"janick@oakland.edu\":true,
                        \"in7.4.1776@gmail.com\":true
                    }
                },
                \"1\": {
                    \"start\":\"2016-04-07T17:00:00Z\",
                    \"end\":\"2016-04-07T18:00:00Z\",
                    \"location\":\"location2\",
                    \"cost\":\"7\",
                    \"id\":\"1\",
                    \"attendees\": {
                        \"janick@oakland.edu\":true,
                        \"in7.4.1776@gmail.com\":true
                    }
                },
                \"2\": {
                    \"start\":\"2016-04-06T13:00:00Z\",
                    \"end\":\"2016-04-06T13:30:00Z\",
                    \"location\":\"location3\",
                    \"cost\":\"4\",
                    \"id\":\"2\",
                    \"attendees\": {
                        \"janick@oakland.edu\":true,
                        \"in7.4.1776@gmail.com\":true
                    }
                }
            }
        }";
        
//        var_dump($output);
        $q3 = "UPDATE tblevents SET blOptiSuggestion = ? WHERE pkEventid = ?";
        $q4 = "SELECT nmTitle FROM tblevents WHERE pkEventid = ?";
        
        if($stmt = $dbc->prepare($q3)){
            $stmt->bind_param("si", $blOptiSuggestion,$pkEventid);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
        if($stmt = $dbc->prepare($q4)){
            $stmt->bind_param("i", $pkEventid);
            $stmt->execute();
            $stmt->bind_result($nmTitle);
            $stmt->fetch();
            $stmt->free_result();
            $stmt->close();
        }
        $notifications[] = "Mesa has finished calculating optimal meeting times, return to the event page for <b><i>$nmTitle</i></b> to view suggestions.";
    } else {
        $warnings[] = "None of your attendees have responded to your calendar access request email yet. Please have at least one response before attempting to optimize event settings";
    }
}
?>