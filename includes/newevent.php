<!DOCTYPE html>
<?php
$homedir = "../";
?>

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="<?php echo $homedir."css/main.css"; ?>">
        <script type="text/javascript" src="<?php echo $homedir."java/jquery/jquery-2.2.0.js"?>"></script>
        <script type="text/javascript" src="<?php echo $homedir."java/ui-placeholder.js"?>"></script>
        <title>Meeting and Event Scheduling Assistant: New Event</title>
    </head>
    <body>
        <div id="ne-wpg">
            <div id="ne-top-buttons" class="section-container">
                <div class="gen-btn-wrapper action-btn-wrapper">
                    <div id="ne-btn-send" tabindex="1" style="-moz-user-select: none;" role="button">
                        SEND
                    </div>
                </div>
                <div class="gen-btn-wrapper ne-btn-wrapper">
                    <div id="ne-btn-reset" tabindex="2" style="-moz-user-select: none;" role="button">
                        Reset
                    </div>
                </div>
            </div>
            <div id="ne-evt-title" class="section-container">
                <input class="textinput ui-placeholder" title="Event title" type="text" placeholder="Untitled Event">
            </div>
        </div>
    </body>
</html>
