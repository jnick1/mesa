<?php
    $homedir = "../../";
    $googicons = imagecreatefrompng($homedir."files/google-icons-combined.png");
    $colorscheckmark = imagecreatetruecolor(10, 10);
    imagesavealpha($colorscheckmark, true);
    $color = imagecolorallocatealpha($colorscheckmark, 0, 0, 0, 127);
    imagefill($colorscheckmark, 0, 0, $color);
    imagecopy($colorscheckmark, $googicons, 0, 0, 95, 50, 10, 10);
    header('Content-type: image/png');
    imagepng($colorscheckmark);