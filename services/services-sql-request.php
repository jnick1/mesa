<?php

require_once __DIR__ . '/paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;

require_once __DIR__ . "/../config/mysqli_connect.php";

function sql_check_token() {
    $dbc = connect_sql();

    $query = "SELECT txEmail FROM tbltokens WHERE txTokenid = ?";
    $token = $_SESSION['token_id'];

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($event_email);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if (empty($event_email)) {
        redirect_local(ERROR_PATH . "/?e=invalid_token");
    } else {
        $_SESSION['sql_attendee_email'] = $event_email;
    }
    $dbc->close();
}

function sql_load_event_retrieval() {
    $dbc = connect_sql();

    $query = "SELECT txLocation,dtStart,dtEnd FROM tblevents WHERE pkEventid = ?";
    $event_id = $_SESSION['event_id'];

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->bind_result($txLocation, $dtStart, $dtEnd);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if (!empty($txLocation) && !empty($dtStart) && !empty($dtEnd)) {
        $dtStart = format_date_from_sql($dtStart);
        $dtEnd = format_date_from_sql($dtEnd);

        $_SESSION['sql_event_id'] = $event_id;
        $_SESSION['sql_event_location'] = $txLocation;
        $_SESSION['sql_event_start'] = $dtStart;
        $_SESSION['sql_event_end'] = $dtEnd;
    } else {
        redirect_local(ERROR_PATH . "/?e=invalid_event");
    }
    $dbc->close();
}

function insert_event_data($blCalendar) {
    $dbc = connect_sql();

    $q1 = "SELECT pkUserid FROM tblusers WHERE txEmail = ?";
    $q2 = "UPDATE tblusers SET blCalendar = ? WHERE pkUserid = ?";
    $q3 = "INSERT INTO tblusers (txEmail, blSalt, txHash, blCalendar, dtLogin) VALUES (?,?,?,?,?)";

    $txEmail = $_SESSION['sql_attendee_email'];

    if ($stmt = $dbc->prepare($q1)) {
        $stmt->bind_param("s", $txEmail);
        $stmt->execute();
        $stmt->bind_result($pkUserid);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if (isset($pkUserid)) {
        if ($stmt = $dbc->prepare($q2)) {
            $stmt->bind_param("si", $blCalendar, $pkUserid);
            $stmt->execute();
            preg_match_all('/(\S[^:]+): (\d+)/', $dbc->info, $matches);
            $info = array_combine($matches[1], $matches[2]);
            $stmt->free_result();
            $stmt->close();
            if ($info['Rows matched'] > 0) { //affected_rows will not work here if calendar data is the same    
                revoke_token($dbc);
            } else {
                redirect_local(ERROR_PATH . "/?e=sql_insertion");
            }
        }
    } else {
        if ($stmt = $dbc->prepare($q3)) {
            $placeholder = "placeholder"; //Have to insert a value for blSalt and txHash
            $loginDate = gmdate("Y-m-d H:i:s");
            $stmt->bind_param("sssss", $txEmail, $placeholder, $placeholder, $blCalendar, $loginDate);
            $stmt->execute();
            $affected_rows = $stmt->affected_rows;
            $stmt->free_result();
            $stmt->close();
            if ($affected_rows > 0) {
                revoke_token($dbc);
            } else {
                redirect_local(ERROR_PATH . "/?e=sql_insertion");
            }
        }
    }
}

function revoke_token($dbc) {

    $query = "DELETE FROM tbltokens WHERE txTokenid = ?";
    $token = $_SESSION['token_id'];
    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
    }
    $dbc->close();
}

function format_date_from_sql($date) {
    $date = str_replace(" ", "T", $date) . "Z";
    return $date;
}

function connect_sql() {
    $dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($dbc->connect_errno) {
        redirect_local(ERROR_PATH . "/?e=sql_connection");
    }
    if (!mysqli_set_charset($dbc, "utf8")) {
        redirect_local(ERROR_PATH . "/?e=sql_charset");
    }
    return $dbc;
}
