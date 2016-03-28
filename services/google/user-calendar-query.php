<?php
require_once __DIR__ . '/../paths-header.php'; //Now update this path for file system updates
require_once FILE_PATH . GOOGLE_SERVICES_HEADER_PATH;

if (!(isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    redirect_local(OAUTH2_PATH . '?' . $_SESSION['token_id']);
}
?>
<form method='post' action='#'> 
    <table> <tr>
            <td>Select Calendars To Use</td>
            <td>
                <?php
                $calendar_list = $_SESSION['calendar_summaries'];
                foreach ($calendar_list as $calendar):
                    ?>
                    <input type='checkbox' name='checkboxvar[]' value='<?php echo $calendar ?>' ><?php echo $calendar ?><br>
                    <?php
                endforeach;
                ?>
            </td> </tr> 
    </table> 
    <input type="submit" name="formSubmit" value="Submit" />
</form>
<?php
if (!empty($_POST['checkboxvar'])) {
    $_SESSION['user_calendar_summaries'] = filter_var_array($_POST['checkboxvar'], FILTER_SANITIZE_STRING);
    redirect_local(GOOGLE_CALENDAR_ACCESS_PATH);
}
