<?php
if(isset($scrubbed["signout"])) {
    unset($_SESSION["pkUserid"]);
    unset($_SESSION["email"]);
    unset($_SESSION["lastLogin"]);
    unset($_SESSION["userColor"]);
}
?>