<?php
if(isset($scrubbed["optimizeedit"])){
    $scrubbed["optimize"] = true;
    $scrubbed["editevent"] = true;
    include $homedir."includes/protocols/optimize.php";
    include $homedir."includes/protocols/editevent.php";
    $notifications = [
        "Mesa has finished calculating optimal meeting times, click on the <b><i>FIND TIMES</i></b> button to view suggestions."
    ];
}
?>