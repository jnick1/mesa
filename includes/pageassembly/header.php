<div id="wpg-header">
    
    <script type="text/javascript" src="<?php echo $homedir;?>java/wpg-header.js"></script>
    
    <div id="wpg-header-account">
        <?php if(empty($_SESSION["pkUserid"])) { ?>
        <div id="wpg-header-btn-signin-wrapper" class="wrapper-btn-all wrapper-btn-action">
            <div id="wpg-header-btn-signin" title="Sign in to your MESA account"<?php echo " tabindex=\"".$ti++."\"";?>>
                Sign in
            </div>
        </div>
        <?php } else { 
            
        $r = hexdec(substr($_SESSION["userColor"], 1, 2));
        $g = hexdec(substr($_SESSION["userColor"], 3, 2));
        $b = hexdec(substr($_SESSION["userColor"], 5, 2));
        $color = dechex(((0.21*$r + 0.72*$g + 0.07*$b)/3)<=127.5?255:0);
        ?>
        
        <span id="wpg-header-user-namedisplay" class="ui-container-inline ui-unselectabletext"> Welcome, <?php echo $_SESSION["email"]; ?></span>
        <div id="wpg-header-user-imagedisplay" class="ui-container-inline ui-unselectabletext" style="color: <?php echo "#".$color.$color.$color; ?>">
            <?php echo strtoupper(substr($_SESSION["email"], 0, 1)) ?>
        </div>
        <div id="wpg-header-btn-signout-wrapper" class="wrapper-btn-all wrapper-btn-action">
            <div id="wpg-header-btn-signout" title="Sign out of your MESA account"<?php echo " tabindex=\"".$ti++."\"";?>>
                Sign out
            </div>
        </div>
        <?php } ?>
    </div>
    <div id="wpg-header-title">
        <a id="wpg-header-link" href="<?php echo $homedir."index.php"; ?>"<?php echo " tabindex=\"".$ti++."\"";?>>
            Mesa Organizer
        </a>
        <?php
        if(isset($_SESSION["pkUserid"]) && is_numeric($_SESSION["pkUserid"])) {
        ?>
        <span id="wpg-header-myevents" class="ui-container-inline ui-unselectabletext">
            <a href="<?php echo $homedir; ?>includes/eventlist.php">
                My events
                <!--<span id="wpg-header-myevents-dropdown-arrow" class="goog-icon goog-icon-dropdown-arrow-left ui-container-inline"></span>-->
            </a>
        </span>
        <?php } ?>
    </div>
    <div id="wpg-header-errordisplay" class="ui-widget">
        
        <?php
        /*This section is designed to be an easy way to display errors and warnings to the user.
         * To display an error, simply add the error text you wish to the $erros variable.
         * If the webpage detects any errors (content in $errors), it will display them to the
         * user.
         */
        ?>
        
        <div id="wpg-header-errordisplay-errorwrapper" class="ui-state-error ui-corner-all wpg-header-errordisplay-bodywrapper<?php if(count($errors)==0){echo " wpg-nodisplay";}?>">
            <span id="wpg-header-error">
                <?php
                $errorFlavor = "<div><span class=\"ui-icon ui-icon-alert wpg-header-errordisplay-icon\"></span>\n<b>Alert: </b>";
                
                for($i=0;$i<count($errors);$i++){
                    echo $errorFlavor.$errors[$i]."</div>";
                }
                ?>
            </span>
        </div>
        <div id="wpg-header-errordisplay-warningwrapper" class="ui-state-highlight ui-corner-all wpg-header-errordisplay-bodywrapper<?php if(count($warnings)==0){echo " wpg-nodisplay";}?>">
            <span id="wpg-header-warning">
                <?php
                
                $warningFlavor = "<div><span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Warning: </b>";
                
                for($i=0;$i<count($warnings);$i++){
                    echo $warningFlavor.$warnings[$i]."</div>";
                }
                ?>
            </span>
        </div>
        <div id="wpg-header-errordisplay-infowrapper" class="ui-state-info ui-corner-all wpg-header-errordisplay-bodywrapper<?php if(count($notifications)==0){echo " wpg-nodisplay";}?>">
            <span id="wpg-header-info">
                <?php
                
                $infoFlavor = "<div><span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Notification: </b>";
                
                for($i=0;$i<count($notifications);$i++){
                    echo $infoFlavor.$notifications[$i]."</div>";
                }
                ?>
            </span>
        </div>
    </div>
</div>