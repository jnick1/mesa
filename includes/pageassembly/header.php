<div id="wpg-header">
    <div id="wpg-header-account">
        <?php //need to add stuff like logout button and user id confirmation here ?>
    </div>
    <div id="wpg-header-title">
        <a id="wpg-header-link" href="<?php echo $homedir."index.php"; ?>"<?php echo " tabindex=\"".$ti++."\"";?>>
            Mesa Organizer
        </a>
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