<?php

require_once __DIR__ . '/paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;

require_once __DIR__."/../config/mysqli_connect.php";

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
}

function insert_event_data($blCalendar) {
    $dbc = connect_sql();

    $q1 = "SELECT pkUserid FROM tblusers WHERE txEmail = ?";
    $q2 = "UPDATE tblusers SET blCalendar = ? WHERE pkUserid = ?";
    $q3 = "INSERT INTO tblusers (txEmail, blCalendar) VALUES (?,?)";

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
            $stmt->free_result();
            $stmt->close();
        }
    } else {
        if ($stmt = $dbc->prepare($q3)) {
            $stmt->bind_param("ss", $txEmail, $blCalendar);
            $stmt->execute();
            $stmt->free_result();
            $stmt->close();
        }
    }
    revoke_token();
}

function revoke_token() {
    $dbc = connect_sql();

    $query = "DELETE FROM tblTokenid WHERE txTokenid = ?";
    $token = $_SESSION['token_id'];
    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->free_result();
        $stmt->close();
    }
}

function format_date_from_sql($date) {
    $date = str_replace(" ", "T", $date) . "Z";
    return $date;
}

function connect_sql() {
    $dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

    if (!mysqli_set_charset($dbc, "utf8")) {
        printf("Error loading character set utf8: %s\n", mysqli_error($dbc));
    }
    return $dbc;
}
