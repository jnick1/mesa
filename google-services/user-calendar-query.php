<?php
require __DIR__ . '/google-services-header.php';
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
if(!empty($_POST['checkboxvar'])) {
    $_SESSION['user_calendar_summaries'] = $_POST['checkboxvar'];
    redirect_local('google-service-access.php');
}
