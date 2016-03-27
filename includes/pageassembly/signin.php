<div id="wpg-signin-wrapper" class="ui-popup">
    <div id="wpg-signin-dialogbox" class="ui-dialogbox">
        <div id="wpg-signin-header">
            <span class="ui-header">Sign in</span>
            <span id="wpg-signin-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
        </div>
        <div id="wpg-signin-table-wrapper">
            <table>
                <tbody>
                    <tr>
                        <th>
                            <label class="wpg-signin-label ui-unselectabletext">
                                Email
                            </label>
                        </th>
                        <td>
                            <input id="wpg-evt-signin-email" name="wpg-evt-signin-email" placeholder="Enter your email address" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                            <div id="wpg-signin-notification-email" class="wpg-nodisplay"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="wpg-signin-label ui-unselectabletext">
                                Password
                            </label>
                        </th>
                        <td>
                            <input id="wpg-evt-signin-password" name="wpg-evt-signin-password" placeholder="Enter a password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                            <div id="wpg-signin-notification-password" class="wpg-nodisplay"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="wpg-signin-btns">
            <div class="wrapper-btn-general wrapper-btn-all wpg-btns-popups">
                <div id="wpg-signin-btn-done" <?php echo " tabindex=\"".$ti++."\"";?>>
                    Done
                </div>
            </div>
            <div class="wrapper-btn-general wrapper-btn-all wpg-btns-popups">
                <div id="wpg-signin-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                    Cancel
                </div>
            </div>
        </div>
    </div>
</div>