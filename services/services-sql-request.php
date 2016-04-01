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

    $query = "SELECT txLocation,dtStart,dtEnd,txRRule,blSettings FROM tblevents WHERE pkEventid = ?";
    $event_id = $_SESSION['event_id'];

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
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
    $settings = json_decode($blSettings);
    $dateStart = date_create_from_format("Y/m/d H:i:s", $dtStart, DateTimeZone::UTC);
    $dateEnd = date_create_from_format("Y/m/d H:i:s", $dtEnd, DateTimeZone::UTC);

    if ($settings["date"]) {
        $dateEnd = date_create_from_format("Y/m/d H:i:s", $settings["date"]["furthest"], DateTimeZone::UTC);
        $offsetEnd = new DateInterval("P1D");
        $offsetStart = clone $offsetEnd;
        $offsetStart->invert = 1;
        date_add($dateEnd, $offsetEnd);
        date_add($dateStart, $offsetStart);
    } else {
        if (!isset($txRRule)) {
            $offestEnd = new DateInterval("P7D");
            $offsetStart = clone $offsetEnd;
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
                $dateEnd = date_create_from_format("Ymd?His", $rrule["UNTIL"], DateTimeZone::UTC); //TODO: Test
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
    $_SESSION['sql_search_start'] = format_date_from_sql(date_format($dateStart, "Y/m/d H:i:s"));
    $_SESSION['sql_search_end'] = format_date_from_sql(date_format($dateEnd, "Y/m/d H:i:s"));
}

function insert_event_data($blCalendar) {
    $dbc = connect_sql();

    $q1 = "SELECT pkUserid FROM tblusers WHERE txEmail = ?";
    $q2 = "UPDATE tblusers SET blCalendar = ? WHERE pkUserid = ?";
    $q3 = "INSERT INTO tblusers (txEmail, txHash, blCalendar) VALUES (?,?,?)";

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
            $placeholder = "blah";
            $stmt->bind_param("sss", $txEmail, $placeholder, $blCalendar);
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
