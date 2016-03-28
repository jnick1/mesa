<div id="wpg-account-wrapper" class="ui-popup">
    <div id="wpg-account-dialogbox" class="ui-dialogbox">
        <div id="wpg-account-header">
            <span class="ui-header">My account</span>
            <span id="wpg-account-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
        </div>
        <div id="wpg-account-table-wrapper">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="wpg-account-section-header" colspan="2">
                                            <label class="wpg-account-label ui-unselectabletext">
                                                Change email
                                            </label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="wpg-account-label ui-unselectabletext">
                                                New email
                                            </label>
                                        </th>
                                        <td>
                                            <input id="wpg-evt-account-email" name="wpg-evt-account-email" placeholder="Enter a new email address" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                            <div id="wpg-account-notification-email" class="wpg-nodisplay"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="wpg-account-btns">
                                                <div class="wrapper-btn-general wrapper-btn-all wpg-btns-popups">
                                                    <div id="wpg-account-btn-changeemail" <?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Change
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="wpg-account-section-header" colspan="2">
                                            <label class="wpg-account-label ui-unselectabletext">
                                                Reset password
                                            </label>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="wpg-account-label ui-unselectabletext">
                                                Current password
                                            </label>
                                        </th>
                                        <td>
                                            <input id="wpg-evt-account-password" name="wpg-evt-account-password" placeholder="Enter your current password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                            <div id="wpg-account-notification-password" class="wpg-nodisplay"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="wpg-account-label ui-unselectabletext">
                                                New password
                                            </label>
                                        </th>
                                        <td>
                                            <input id="wpg-evt-account-newpassword" name="wpg-evt-account-password" placeholder="Enter a new password password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                            <div id="wpg-account-notification-newpassword" class="wpg-nodisplay"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label class="wpg-account-label ui-unselectabletext">
                                                Confirm new password
                                            </label>
                                        </th>
                                        <td>
                                            <input id="wpg-evt-account-confirmnewpassword" name="wpg-evt-account-password" placeholder="Reenter your new password" type="password" class="ui-textinput"<?php echo " tabindex=\"".$ti++."\"";?>>
                                            <div id="wpg-account-notification-confirmnewpassword" class="wpg-nodisplay"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="wpg-account-btns">
                                                <div class="wrapper-btn-general wrapper-btn-all wpg-btns-popups">
                                                    <div id="wpg-account-btn-resetpassword" <?php echo " tabindex=\"".$ti++."\"";?>>
                                                        Reset
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center" colspan="2">
                            <span id="wpg-account-delete-link" class="ui-dulledlink">Delete account</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
<div id="wpg-account-delete-wrapper" class="ui-popup">
    <div id="wpg-account-delete-dialogbox" class="ui-dialogbox">
        <div id="wpg-account-delete-header">
            <span class="ui-header">Delete account</span>
            <span id="wpg-account-delete-x" class="goog-icon goog-icon-x-medium ui-container-inline"<?php echo " tabindex=\"".$ti++."\"";?>></span>
        </div>
        <div id="wpg-account-delete-content-wrapper">
            Are you sure you want to delete your entire account?
            <div id="wpg-account-delete-warningtext">
                THIS WILL DELETE ALL EVENTS SAVED UNDER YOUR ACCOUNT.
            </div>
        </div>
        <div id="wpg-account-delete-btns">
            <div class="wrapper-btn-general wrapper-btn-all wpg-btns-popups">
                <div id="wpg-account-delete-btn-yes" <?php echo " tabindex=\"".$ti++."\"";?>>
                    Yes
                </div>
            </div>
            <div class="wrapper-btn-general wrapper-btn-all wpg-btns-popups">
                <div id="wpg-account-delete-btn-cancel" <?php echo " tabindex=\"".$ti++."\"";?>>
                    Cancel
                </div>
            </div>
        </div>
    </div>
</div>