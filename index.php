<!DOCTYPE html>
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$homedir = "";
require_once $homedir."config/mysqli_connect.php";
$ti = 1;

//these should get their values from a failed attempt at a POST request
$errors = [];
$warnings = [];
$notifications = [];

?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="<?php echo $homedir;?>favicon.png" sizes="128x128">
        
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/goog.css"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/images.php"; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/in.css"; ?>">
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
        
        <script type="text/javascript" src="<?php echo $homedir."java/in-authentication.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/in-content.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/validation.js"?>"></script>
        
        <title>Meeting and Event Scheduling Assistant</title>
    </head>
    <body>
        <div id="wpg" class="<?php echo "uluru".rand(1,6); ?>">
            <div id="in-header" class="ui-container-section">
                <div id="in-top-buttons">
                    <div id="in-btn-signin-wrapper" class="wrapper-btn-all wrapper-btn-action">
                        <div id="in-btn-signin" title="Sign in to your MESA account"<?php echo " tabindex=\"".$ti++."\"";?>>
                            Sign in
                        </div>
                    </div> <?php //move this to header.php ?>
                </div>
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
            </div>
            <div id="in-content">
                <div id="in-content-title">
                    <h1>Welcome to MESA, the Meeting and Event Scheduling Assistant</h1>
                    <div class="ui-separator"></div>
                    <h1>New user? Register here!</h1>
                    <div id="in-btn-register-wrapper" class="wrapper-btn-all wrapper-btn-action">
                        <div id="in-btn-register" title="Register for MESA"<?php echo " tabindex=\"".$ti++."\"";?>>
                            REGISTER
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include $homedir."includes/pageassembly/footer.php";
            ?>
        </div>
        <div id="in-register-wrapper" class="ui-popup">
            <div id="in-register-dialogbox" class="ui-dialogbox">
                <div id="in-register-header">
                    <span class="ui-header">Register</span>
                    <span id="in-register-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                </div>
                <div id="in-register-table-wrapper">
                    <table>
                        <tbody>
                            <tr>
                                <th>
                                    <label class="in-register-label ui-unselectabletext">
                                        Email
                                    </label>
                                </th>
                                <td>
                                    <input id="in-evt-register-email" name="in-evt-register-email" placeholder="Enter your email address" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <div id="in-register-notification-email" class="wpg-nodisplay"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="in-register-label ui-unselectabletext">
                                        Password
                                    </label>
                                </th>
                                <td>
                                    <input id="in-evt-register-password" name="in-evt-register-password" placeholder="Enter a password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <div id="in-register-notification-password" class="wpg-nodisplay"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="in-register-label ui-unselectabletext">
                                        Confirm Password
                                    </label>
                                </th>
                                <td>
                                    <input id="in-evt-register-confpassword" name="in-evt-register-confpassword" placeholder="Reenter your password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <div id="in-register-notification-confpassword" class="wpg-nodisplay"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="in-register-btns">
                    <div class="wrapper-btn-general wrapper-btn-all">
                        <div id="in-register-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Done
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all">
                        <div id="in-register-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
