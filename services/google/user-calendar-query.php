<?php
require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$homedir = "../../";
require_once $homedir."config/mysqli_connect.php";
$ti = 1;

//these should get their values from a failed attempt at a POST request
$errors = [];
$warnings = [];
$notifications = [];

if (!(isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    redirect_local(OAUTH2_PATH . '?' . $_SESSION['token_id']);
}

if (!empty($_POST['checkboxvar'])) {
    $_SESSION['user_calendar_summaries'] = filter_var_array($_POST['checkboxvar'], FILTER_SANITIZE_STRING);
    redirect_local(GOOGLE_CALENDAR_ACCESS_PATH);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="<?php echo $homedir;?>favicon.png" sizes="128x128">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ucq.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.structure.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.theme.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
        <script type="text/javascript" src="<?php echo $homedir."java/ucq-content.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant</title>
    </head>
    <body>
        <div id="wpg" class="<?php echo "uluru".rand(1,8); ?>">
            <div id="ucq-header" class="ui-container-section">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
            </div>
            <div id="ucq-content">
                <div id="ucq-calendar-dialogbox" class="ui-dialogbox">
                    <div id="ucq-calendar-header">
                        <span class="ui-header">Select calendars to use</span>
                    </div>
                    <div id="ucq-calendar-table-wrapper">
                        <table>
                            <tbody>
                                <?php
                                $calendar_list = $_SESSION['calendar_summaries'];
                                foreach($calendar_list as $calendar) {
                                ?>
                                <tr>
                                    <th>
                                        <label class="ucq-calendar-label ui-unselectabletext">
                                            <?php echo $calendar; ?>
                                        </label>
                                    </th>
                                    <td>
                                        <input id="<?php echo $calendar; ?>" name="ucq-evt-calendar-email" placeholder="Enter your email address" class="ui-textinput checkboxvar"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="ucq-calendar-btns">
                        <div class="wrapper-btn-general wrapper-btn-all in-btns-popups">
                            <div id="ucq-calendar-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                                Submit
                            </div>
                        </div>
                        <div class="wrapper-btn-general wrapper-btn-all in-btns-popups">
                            <div id="ucq-calendar-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                                Cancel
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include $homedir."includes/pageassembly/footer.php";
            ?>
        </div>
    </body>
</html>

