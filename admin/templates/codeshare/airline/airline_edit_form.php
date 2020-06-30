<?php


$this->show('codeshare/codeshare_header.php');
?>


<h4>Edit Codeshare Airline</h4>
<hr />
<form name="eventform" action="<?php echo SITE_URL; ?>/admin/index.php/codeshare_admin" method="post">
<table width="80%">

            <tr>
                <td>Airline Name</td>
                <td><input type="text" name="airname"
                           <?php echo 'value="'.$airlines->airname.'"'; ?>
                           ></td>
            </tr>
            <tr>
                <td>Airline code</td>
                <td><input type="text" maxlength="3" name="aircode"
                           <?php echo 'value="'.$airlines->aircode.'"'; ?>
                           ></td>
            </tr>
            <tr>
                <td>Airline Description</td>
                <td><input type="text" name="airdesc"
                            <?php

                                  echo 'value="'.$airlines->airdesc.'"';
                                ?></td>
                              </tr>
            <tr>
                <td>Airline type</td>
                <td><select name="airtype" id="airtype">
                      <option value="P">Passenger</option>
                      <option value="C">Cargo</option></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="aircode" value="<?php echo $airlines->aircode; ?>" />
                    <input type="hidden" name="action" value="save_edit_codeshare_airline" />
                    <input type="submit" value="Edit Codeshare"></td>
            </tr>

    </table>     </form>
