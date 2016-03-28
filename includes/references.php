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
if(isset($scrubbed["signout"])) {
    unset($_SESSION["pkUserid"]);
    unset($_SESSION["email"]);
    unset($_SESSION["lastLogin"]);
}
if(isset($scrubbed["signin"])) {
    $q1 = "SELECT blSalt, txHash FROM tblusers WHERE txEmail = ?";
    $q2 = "SELECT pkUserid, dtLogin FROM tblusers WHERE txHash = ?";
    $q3 = "UPDATE tblusers SET dtLogin = CURRENT_TIMESTAMP";
    
    if($stmt = $dbc->prepare($q1)){
        $stmt->bind_param("s", $scrubbed["in-evt-signin-email"]);
        $stmt->execute();
        $stmt->bind_result($salt,$hash);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    }
    if(!empty($hash)){
        $hashGiven = hash("sha256",$salt.$scrubbed["in-evt-signin-password"]);
        if($hash === $hashGiven) {
            if($stmt = $dbc->prepare($q2)){
                $stmt->bind_param("s", $hashGiven);
                $stmt->execute();
                $stmt->bind_result($pkUserid, $lastLogin);
                $stmt->fetch();
                $stmt->free_result();
                $stmt->close();
            }
            if($stmt = $dbc->prepare($q3)){
                $stmt->execute();
                $stmt->free_result();
                $stmt->close();
            }
            $_SESSION["pkUserid"] = $pkUserid;
            $_SESSION["email"] = $scrubbed["in-evt-signin-email"];
            $_SESSION["lastLogin"] = $lastLogin;
            $_SESSION["userColor"] = "#".substr($hash, 0, 6);
        } else {
            $errors[] = "That combination of email and password is incorrect. Please try again.";
        }
    } else {
        $errors[] = "The user account you specified cannot be found. Please try again.";
    }
}
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
            <div id="re-header" class="ui-container-section">
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