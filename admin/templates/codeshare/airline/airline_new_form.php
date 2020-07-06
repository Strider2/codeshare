<?php

$this->show('codeshare/codeshare_header.php');

if(isset($airlines))
{echo '<div id="error">All fields must be filled out</div>'; }
?>

<h4>Add new Codeshare Airline</h4>
<span style="color:red;">Note: You must have already added the flights into your main schedules table before you can add the codeshares into this module. As you need the schedid from the schedules for it to work.</span>

<table width="80%">
        <form name="eventform" action="<?php echo SITE_URL; ?>/admin/index.php/CodeShare_admin" method="post" enctype="multipart/form-data">
            <tr>
                <td>Airline Name</td>
                <td><input type="text" name="name"
                          <?php
                                if(isset($event))
                                {echo 'value="'.$event['name'].'"';}
                          ?>


                           </td>
            </tr>
            <tr>
                <td>Airline Code</td>
                <td><input type="text" maxlength="3" name="code"
                           <?php
                                if(isset($event))
                                {echo 'value="'.$event['code'].'"';}
                           ?></td>
            </tr>
            <tr>
                <td>Airline Type</td>
                <td><select name="type" id="type">
                        <option value="P">Passenger</option>
                        <option value="C">Cargo</option></td>
            </tr>
            <tr>
              <td>Airline Description</td>
              <td><textarea maxlength="350" name="airdesc" style="width:500px; height:180px;">
                      <?php
                          if(isset($event))
                          {echo 'value="'.$event['airdesc'].'"';}
                      ?></textarea>


</tr>
<tr>
    <td> Enable</td>
    <td><select name="enabled" id="enabled">
      <option value="1" selected>Yes</option>
      <option value="0">No</option></td>
    </tr>
            <tr>
                <td colspan="2">
                  <input type="hidden" name="codeshare" value="1"/>
                  <input type="hidden" name="action" value="save_new_codeshare_airline" />
                  <input type="submit" value="Save New Codeshare Airline"></td>
            </tr>
        </form>
    </table>
