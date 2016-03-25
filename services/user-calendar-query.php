<?php
require_once __DIR__ . '/google-services-header.php';
if (!(isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    redirect_local('oauth2access.php');
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
    redirect_local('google-calendar-access.php');
}
