<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$homedir = "../";
require_once $homedir."config/mysqli_connect.php";
$ti = 1;

//these should get their values from a failed attempt at a POST request
$errors = [];
$warnings = [];
$notifications = [];

$scrubbed = array_map("spam_scrubber", $_POST);

include $homedir."includes/protocols/signout.php";
include $homedir."includes/protocols/deleteaccount.php";

include $homedir."includes/protocols/changeemail.php";
include $homedir."includes/protocols/changepassword.php";

include $homedir."includes/protocols/signin.php";

include $homedir."includes/protocols/forgotpassword.php";
include $homedir."includes/protocols/resetpassword.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="<?php echo $homedir;?>favicon.png" sizes="128x128">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/re.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/wrappers.css"; ?>">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.structure.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery-ui.theme.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."java/jquery/jquery.dropdown.css"; ?>">
        
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-ui.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery.dropdown.js"?>"></script>
        
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant: References</title>
    </head>
    <body>
        <div id="wpg">
            <div id="re-header" class="ui-container-section <?php echo "uluru".rand(1,8); ?>">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
            </div>
            <div id="re-content">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                Citations here... Chicago format
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
            include $homedir."includes/pageassembly/footer.php";
            ?>
        </div>
        <?php
        include $homedir."includes/pageassembly/signin.php";
        include $homedir."includes/pageassembly/account.php";
        ?>
    </body>
</html>
