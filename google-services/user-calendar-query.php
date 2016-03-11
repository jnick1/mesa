<?php
require __DIR__ . '/google-services-header.php';

if (isset($_SESSION['calendar_summaries']) && $_SESSION['calendar_summaries']):
    ?>
    <form method='post' action='#'> 
        <table> <tr>
                <td>Select Calendars To Use</td>
                <td>
                    <?php
                    $calendar_list = $_SESSION['calendar_summaries'];
                    foreach ($calendar_list as $calendar):
                        ?>
                        <input type='checkbox' name='checkboxvar[]' value='<?php $calendar ?>' ><?php echo $calendar ?><br>
                        <?php
                    endforeach;
                    ?>
                </td> </tr> 
        </table> 
        <input type='submit'> 
    </form>
<?php
else:
    echo 'No calendar list! ERROR';
endif;
?>


