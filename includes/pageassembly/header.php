<div id="wpg-header-title">
    <a id="wpg-header-link" href="<?php echo $homedir."index.php"; ?>"<?php echo " tabindex=\"".$ti++."\"";?>>
        Mesa Organizer
    </a>
    <div id="wpg-header-errordisplay" class="ui-widget<?php if(count($errors)==0 && count($warnings)==0){echo " wpg-nodisplay";}?>">
        
        <?php
        /*This section is designed to be an easy way to display errors and warnings to the user.
         * To display an error, simply add the error text you wish to the $erros variable.
         * If the webpage detects any errors (content in $errors), it will display them to the
         * user.
         */
        ?>
        
        <div id="wpg-header-errordisplay-errorwrapper" class="ui-state-error ui-corner-all wpg-header-errordisplay-bodywrapper<?php if(count($errors)==0){echo " wpg-nodisplay";}?>">
            <span id="wpg-error">
                <?php
                $errorFlavor = "<span class=\"ui-icon ui-icon-alert wpg-header-errordisplay-icon\"></span>\n<b>Alert: </b>";
                
                for($i=0;$i<count($errors);$i++){
                    echo $errorFlavor.$errors[$i]."\n";
                }
                ?>
            </span>
        </div>
        <div id="wpg-header-errordisplay-warningwrapper" class="ui-state-highlight ui-corner-all wpg-header-errordisplay-bodywrapper<?php if(count($warnings)==0){echo " wpg-nodisplay";}?>">
            <span id="wpg-warning">
                <?php
                
                $warningFlavor = "<span class=\"ui-icon ui-icon-info wpg-header-errordisplay-icon\"></span>\n<b>Warning: </b>";
                
                for($i=0;$i<count($warnings);$i++){
                    echo $warningFlavor.$warnings[$i]."\n";
                }
                ?>
            </span>
        </div>
    </div>
</div>