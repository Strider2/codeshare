<?php

$this->show('codeshare/codeshare_header.tpl');

if(isset($codeshare))
{echo '<div id="error">All fields must be filled out</div>'; }
?>

<h4>Create New CodeShare</h4>
<span style="color:red;">Note: You must have already added the flights into your main schedules table before you can add the codeshares into this module. As you need the schedid from the schedules for it to work.</span>
<table width="80%">
        <form name="eventform" action="<?php echo SITE_URL; ?>/admin/index.php/codeshare_admin" method="post" enctype="multipart/form-data">
            <tr>
                <td>Schedule ID</td>
                <td><input type="text" name="schedid"
                           <?php
                                if(isset($event))
                                {echo 'value="'.$event['schedid'].'"';}
                           ?>
                           </td>
            </tr>
            <tr>
                <td>Airline</td>
                <td><input type="text" name="airline"
                           <?php
                                if(isset($event))
                                {echo 'value="'.$event['airline'].'"';}
                           ?></td>
            </tr>
            
            <tr>
                <td colspan="2"><input type="hidden" name="action" value="save_new_codeshare" /><input type="submit" value="Save New Codeshare"></td>
            </tr>
        </form>
    </table>

