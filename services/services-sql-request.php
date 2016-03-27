<?php
require_once __DIR__ . '/paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;

function sql_check_token(){
    $dbc = connect_sql();
    
    $query = "SELECT txEmail FROM tbltokens WHERE txTokenid = ?";
    $token = $_SESSION['token_id'];
    if($stmt = $dbc->prepare($query)){
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($event_email);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    
    if(empty($event_email)){
        redirect_local(ERROR_PATH . "/?e=invalid_token");
    } else {
        $_SESSION['sql_attendee_email'] = $event_email;
    }
}

function sql_load_event_retrieval() {
    $dbc = connect_sql();
    
    $query = "SELECT txLocation,dtStart,dtEnd FROM tblevents WHERE pkEventid = ?";
    $event_id = $_SESSION['event_id'];
    
    if($stmt = $dbc->prepare($query)){
        $stmt->bind_param("s", $event_id);
        $stmt->execute();
        $stmt->store_result();
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
    } else {
        redirect_local(ERROR_PATH . "/?e=invalid_event");
    }
}

function insert_event_data($blCalendar){
    $dbc = connect_sql();
    
    $query = "UPDATE tblusers SET blCalendar = ? WHERE tblusers.txEmail = ?";
    $txEmail = $_SESSION['sql_attendee_email'];
    
    if($stmt = $dbc->prepare($query)){
        $stmt->bind_param("bs", $blCalendar, $txEmail);
        $stmt->execute();
        if($stmt->affected_rows == 0){
            redirect_local(ERROR_PATH . "/?e=invalid_email");
        }
        $stmt->close();
    }
}

function retrieve_event_creation_data($event_id){
    $dbc = connect_sql();
    
    $query = "SELECT blOptiSuggestion FROM tblevents WHERE pkEventid = ?";
    
    if($stmt = $dbc->prepare($query)){
        $stmt->bind_param("s", $event_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($blOptiSuggestion);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    
    if(!empty($blOptiSuggestion)){
        return $blOptiSuggestion;
    } else {
        redirect_local(ERROR_PATH . "/?e=invalid_event");
    }
}

function format_date_from_sql($date){
    $date = str_replace(" ", "T", $date) . "Z";
    return $date;
}

function connect_sql(){
    $dbc = new mysqli("localhost", "root", "", "mesadb");
    if(mysqli_connect_errno()){
        redirect_local(ERROR_PATH . "/?e=sql_connection");
    }
    return $dbc;
}
