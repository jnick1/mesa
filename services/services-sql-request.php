<?php

require_once __DIR__ . '/google-services-header.php';

function sql_load() {
    $dbc = new mysqli("localhost", "root", "", "mesadb");
    if(mysqli_connect_errno()){
        echo "Could not connect to database";
        exit();
    }
    
    $query = "SELECT txLocation,dtStart,dtEnd FROM tblevents WHERE pkEventid = ?";
    $event_id = filter_input(INPUT_SESSION, 'event_id', FILTER_SANITIZE_STRING);
    
    if($stmt = $dbc->prepare($query)){
        $stmt->bind_param("s", $event_id);
        $stmt->execute();
        $stmt->bind_result($txLocation,$dtStart, $dtEnd);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    
    if(!empty($txLocation) && !empty($dtStart) && !empty($dtEnd)){
        $dtStart = format_date_from_sql($dtStart);
        $dtEnd = format_date_from_sql($dtEnd);
        
        $_SESSION['sql_event_id'] = $event_id;
        $_SESSION['sql_event_location'] = $txLocation;
        $_SESSION['sql_event_start'] = $dtStart;
        $_SESSION['sql_event_end'] = $dtEnd;
    }
}

function format_date_from_sql($date){
    $date = str_replace(" ", "T", $date, 1) . "Z";
    return $date;
}
