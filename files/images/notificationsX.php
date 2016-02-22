<?php
    $homedir = "../../";
    $googicons = imagecreatefrompng($homedir."files/google-icons-combined.png");
    $notificationsX = imagecreatetruecolor(10, 10);
    imagesavealpha($notificationsX, true);
    $color = imagecolorallocatealpha($notificationsX, 0, 0, 0, 127);
    imagefill($notificationsX, 0, 0, $color);
    imagecopy($notificationsX, $googicons, 0, 0, 215, 51, 10, 10);
    header('Content-type: image/png');
    imagepng($notificationsX);