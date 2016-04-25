<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$homedir = "";
require_once $homedir."../../secure/mysqli_connect.php";
$ti = 1;

//these should get their values from a failed attempt at a POST request
$errors = [];
$warnings = [];
$notifications = [];

$scrubbed = array_map("spam_scrubber", $_POST);

if(!empty($_SESSION["calendarsaved"])) {
    array_push($$_SESSION["calendarsaved"]["messagetype"], $_SESSION["calendarsaved"]["message"]);
    unset($_SESSION["calendarsaved"]);
}

include $homedir."includes/protocols/signout.php";
include $homedir."includes/protocols/deleteaccount.php";

include $homedir."includes/protocols/changeemail.php";
include $homedir."includes/protocols/changepassword.php";

include $homedir."includes/protocols/register.php";
include $homedir."includes/protocols/signin.php";

include $homedir."includes/protocols/resetpassword.php";
include $homedir."includes/protocols/forgotpassword.php";

?>
<!DOCTYPE html>
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
        <div id="wpg" class="<?php echo "uluru".rand(1,8); ?>">
            <div id="in-header" class="ui-container-section">
                <?php
                include $homedir."includes/pageassembly/header.php";
                ?>
            </div>
            <div id="in-content">
                <div id="in-content-title">
                    <h1>Welcome to MESA, the Meeting and Event Scheduling Assistant</h1>
                    <div class="ui-separator"></div>
                    <?php if(empty($_SESSION["pkUserid"])) { ?>
                    <h1>New user? Register here!</h1>
                    <div id="in-btn-register-wrapper" class="wrapper-btn-all wrapper-btn-action">
                        <div id="in-btn-register" title="Register for MESA"<?php echo " tabindex=\"".$ti++."\"";?>>
                            REGISTER
                        </div>
                    </div>
                    <?php } ?>
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
                    <div class="wrapper-btn-general wrapper-btn-all in-btns-popups">
                        <div id="in-register-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Done
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all in-btns-popups">
                        <div id="in-register-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($_SESSION["resetpassword"])) {
        ?>
        <div id="in-resetpassword-wrapper" class="ui-popup">
            <div id="in-resetpassword-dialogbox" class="ui-dialogbox" data-token="<?php echo $_SESSION["resetpassword-token"]; ?>">
                <div id="in-resetpassword-header">
                    <span class="ui-header">Reset password</span>
                    <span id="in-resetpassword-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
                </div>
                <div id="in-resetpassword-info">
                    Please enter your new password.
                </div>
                <div id="in-resetpassword-table-wrapper">
                    <table>
                        <tbody>
                            <tr>
                                <th>
                                    <label class="in-resetpassword-label ui-unselectabletext">
                                        Password
                                    </label>
                                </th>
                                <td>
                                    <input id="in-evt-resetpassword-password" name="in-evt-resetpassword-password" placeholder="Enter a password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <div id="in-resetpassword-notification-password" class="wpg-nodisplay"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="in-resetpassword-label ui-unselectabletext">
                                        Confirm Password
                                    </label>
                                </th>
                                <td>
                                    <input id="in-evt-resetpassword-confpassword" name="in-evt-resetpassword-confpassword" placeholder="Reenter your password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                    <div id="in-resetpassword-notification-confpassword" class="wpg-nodisplay"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="in-resetpassword-btns">
                    <div class="wrapper-btn-general wrapper-btn-all in-btns-popups">
                        <div id="in-resetpassword-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Done
                        </div>
                    </div>
                    <div class="wrapper-btn-general wrapper-btn-all in-btns-popups">
                        <div id="in-resetpassword-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                            Cancel
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            unset($_SESSION["resetpassword"]);
            unset($_SESSION["resetpassword-token"]);
        } ?>
        <?php
        include $homedir."includes/pageassembly/signin.php";
        include $homedir."includes/pageassembly/account.php";
        ?>
    </body>
</html>
