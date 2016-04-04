<?php

require_once __DIR__ . '/paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;

require_once __DIR__ . "/../config/mysqli_connect.php";

function sql_check_token() {
    $dbc = connect_sql();

    $query = "SELECT txEmail, dtExpires FROM tbltokens WHERE txTokenid = ?";
    $token = $_SESSION['token_id'];

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();
        $found_rows = $stmt->num_rows;
        $stmt->bind_result($event_email, $dtExpires);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if ($found_rows == 0) {
        redirect_local(ERROR_PATH . "/?e=invalid_token");
    } else {
        if ($dtExpires != NULL) {
            $current_date = gmdate("Y-m-d H:i:s");
            $timeZone = new DateTimeZone("UTC");
            $expiration = date_create_from_format("Y-m-d H:i:s", $dtExpires, $timeZone);
            if ($expiration < $current_date) {
                redirect_local(ERROR_PATH . "/?e=token_expired");
            } else {
                $_SESSION['sql_attendee_email'] = $event_email;
            }
        } else {
            $_SESSION['sql_attendee_email'] = $event_email;
        }
    }
    $dbc->close();
}

function sql_load_event_retrieval() {
    $dbc = connect_sql();

    $query = "SELECT txLocation,dtStart,dtEnd,txRRule,blSettings FROM tblevents WHERE pkEventid = ?";
    $event_id = $_SESSION['event_id'];

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->store_result();
        $found_rows = $stmt->num_rows;
        $stmt->bind_result($txLocation, $dtStart, $dtEnd, $txRRule, $blSettings);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if ($found_rows > 0) {
        $_SESSION['sql_event_id'] = $event_id;
        $_SESSION['sql_event_location'] = $txLocation;

        generate_constraint_times($txRRule, $dtStart, $dtEnd, $blSettings);
    } else {
        redirect_local(ERROR_PATH . "/?e=invalid_event");
    }
    $dbc->close();
}

function generate_constraint_times($txRRule, $dtStart, $dtEnd, $blSettings) {
    $format = "Y-m-d H:i:s";
    $settings = json_decode($blSettings, true);
    $timeZone = new DateTimeZone("UTC");
    $dateStart = date_create_from_format($format, $dtStart, $timeZone);
    $dateEnd = date_create_from_format($format, $dtEnd, $timeZone);
    if (isset($settings["date"]) && $settings["date"]) {
        $dateEnd = date_create_from_format($format, $settings["date"]["furthest"], $timeZone);
        $offsetEnd = new DateInterval("P1D");
        $offsetStart = new DateInterval("P7D");
        $offsetStart->invert = 1;
        date_add($dateEnd, $offsetEnd);
        date_add($dateStart, $offsetStart);
    } else {
        if (empty($txRRule)) {
            $offsetEnd = new DateInterval("P7D");
            $offsetStart = new DateInterval("P7D");
            $offsetStart->invert = 1;
        } else {
            $txRRule = str_replace(";", "&", $txRRule);
            parse_str($txRRule, $rrule);
            if (isset($rrule["INTERVAL"])) {
                $interval = $rrule["INTERVAL"];
            } else {
                $interval = 1;
            }
            $freq = $rrule["FREQ"];
            if (isset($rrule["UNTIL"])) {
                $dateEnd = date_create_from_format("Ymd?His", $rrule["UNTIL"], $timeZone); //TODO: Test
                switch ($freq) {
                    case "DAILY":
                        $offsetEnd = new DateInterval("P7D");
                        break;
                    case "WEEKLY":
                        $offsetEnd = new DateInterval("P" . (7 * $interval) . "D");
                        break;
                    case "MONTHLY":
                        $offsetEnd = new DateInterval("P" . ($interval) . "M");
                        break;
                    case "YEARLY":
                        $offsetEnd = new DateInterval("P" . ($interval) . "Y");
                        break;
                }
            } elseif (isset($rrule["COUNT"])) {
                $count = $rrule["COUNT"];
                switch ($freq) {
                    case "DAILY":
                        $offsetEnd = new DateInterval("P" . ($count * $interval) . "D");
                        break;
                    case "WEEKLY":
                        $offsetEnd = new DateInterval("P" . ($count * 7 * $interval) . "D");
                        break;
                    case "MONTHLY":
                        $offsetEnd = new DateInterval("P" . ($count * $interval) . "M");
                        break;
                    case "YEARLY":
                        $offsetEnd = new DateInterval("P" . ($count * $interval) . "Y");
                        break;
                }
            } else {
                $offestEnd = new DateInterval("P1Y");
            }
            switch ($freq) {
                case "DAILY":
                    $offsetStart = new DateInterval("P7D");
                    break;
                case "WEEKLY":
                    $offsetStart = new DateInterval("P" . (7) . "D");
                    break;
                case "MONTHLY":
                    $offsetStart = new DateInterval("P1M");
                    break;
                case "YEARLY":
                    $offsetStart = new DateInterval("P1Y");
                    break;
            }
            $offsetStart->invert = 1;
        }
        date_add($dateEnd, $offsetEnd);
        date_add($dateStart, $offsetStart);
    }
    $_SESSION['sql_search_start'] = format_date_from_sql(date_format($dateStart, $format));
    $_SESSION['sql_search_end'] = format_date_from_sql(date_format($dateEnd, $format));
}

function insert_event_data($blCalendar) {
    $dbc = connect_sql();

    $qsu = "SELECT pkUserid FROM tblusers WHERE txEmail = ?"; //Use again to grab pkUserid from inserted user
    $qiu = "INSERT INTO tblusers (txEmail, txHash) VALUES (?,?)";

    $qsc = "SELECT fkUserid, fkEventid FROM tblcalendars WHERE fkUserid = ? AND fkEventid = ?";
    $quc = "UPDATE tblcalendars SET blCalendar = ? WHERE fkUserid = ? AND fkEventid = ?";
    $qic = "INSERT INTO tblcalendars (fkUserid, fkEventid, blCalendar) VALUES (?,?,?)";

    $qit = "INSERT INTO tbltokens (txEmail, txTokenid) VALUES (?,?)";

    $txEmail = strtolower($_SESSION['sql_attendee_email']);

    if ($stmt = $dbc->prepare($qsu)) {
        $stmt->bind_param("s", $txEmail);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt->bind_result($pkUserid);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if ($rows <= 0) { //Generate user if doesn't exist
        $hash = hash("sha256", time());
        if ($stmt = $dbc->prepare($qit)) {
            $stmt->bind_param("ss", $txEmail, $hash);
            $stmt->execute();
            $affected_rows = $stmt->affected_rows;
            $stmt->free_result();
            $stmt->close();
            if ($affected_rows > 0) {
                if ($stmt = $dbc->prepare($qiu)) {
                    $stmt->bind_param("ss", $txEmail, $hash);
                    $stmt->execute();
                    $stmt->free_result();
                    $stmt->close();
                }
            } else {
                redirect_local(ERROR_PATH . "/?e=sql_insertion"); //Not it
            }
        }
    }
    if ($stmt = $dbc->prepare($qsu)) {
        $stmt->bind_param("s", $txEmail);
        $stmt->execute();
        $stmt->bind_result($pkUserid);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if ($stmt = $dbc->prepare($qsc)) {
        $stmt->bind_param("ii", $pkUserid, $_SESSION["event_id"]);
        $stmt->execute();
        $stmt->store_result();
        $found_rows = $stmt->num_rows;
        $stmt->bind_result($fkUserid, $fkEventid);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        if ($found_rows > 0) {
            if ($stmt = $dbc->prepare($quc)) {
                $stmt->bind_param("sii", $blCalendar, $pkUserid, $_SESSION["event_id"]);
                $stmt->execute();
                preg_match_all('/(\S[^:]+): (\d+)/', $dbc->info, $matches);
                $info = array_combine($matches[1], $matches[2]);
                $affected_rows = $info['Rows matched'];
                $stmt->free_result();
                $stmt->close();
            }
        } else {
            if ($stmt = $dbc->prepare($qic)) {
                $stmt->bind_param("iis", $pkUserid, $_SESSION["event_id"], $blCalendar);
                $stmt->execute();
                $affected_rows = $stmt->affected_rows;
                $stmt->free_result();
                $stmt->close();
            }
        }
        if ($affected_rows > 0) { //affected_rows will not work here if calendar data is the same    
            revoke_token($dbc);
            indicate_attendee_response($dbc);
        } else {
            redirect_local(ERROR_PATH . "/?e=sql_insertion");
        }
    }
    $dbc->close();
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
}

function indicate_attendee_response($dbc) {
    $q1 = "SELECT blAttendees FROM tblevents WHERE pkEventid = ?";
    $q2 = "UPDATE tblevents SET blAttendees = ? WHERE pkEventid = ?";
    $event_id = $_SESSION['event_id'];

    if ($stmt = $dbc->prepare($q1)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->store_result();
        $found_rows = $stmt->num_rows;
        $stmt->bind_result($blAttendees);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }

    if ($found_rows > 0) {
        $attendees = json_decode($blAttendees, true);
        foreach ($attendees as &$attendee) {
            if ($attendee["email"] == $_SESSION['sql_attendee_email']) {
                $attendee["responseStatus"] = "accepted";
            }
        }
        if ($stmt = $dbc->prepare($q2)) {
            $updatedAttendees = json_encode($attendees);
            $stmt->bind_param("si", $updatedAttendees, $event_id);
            $stmt->execute();
            preg_match_all('/(\S[^:]+): (\d+)/', $dbc->info, $matches);
            $info = array_combine($matches[1], $matches[2]);
            $affected_rows = $info['Rows matched'];
            $stmt->free_result();
            $stmt->close();
            if ($affected_rows <= 0) {
                redirect_local(ERROR_PATH . "/?e=sql_insertion");
            }
        }
    } else {
        redirect_local(ERROR_PATH . "/?e=invalid_event");
    }
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
