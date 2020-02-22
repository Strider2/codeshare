<?php


$this->show('codeshare/codeshare_header.php');
?>


<h4>Edit Codeshare</h4>
<hr />
<form name="eventform" action="<?php echo SITE_URL; ?>/admin/index.php/codeshare_admin" method="post" enctype="multipart/form-data">
<table width="80%">

            <tr>
                <td>Schedule ID</td>
                <td><input type="text" name="schedid"
                           <?php echo 'value="'.$codeshare->schedid.'"'; ?>
                           ></td>
            </tr>
            <tr>
                <td>Airline</td>
                <td><input type="text" maxlength="3" name="airline"
                           <?php echo 'value="'.$codeshare->airline.'"'; ?>
                           ></td>
            </tr>
            <tr>
                <td>Flight Number (Number only)</td>
                <td><input type="text" name="flightnum"
                            <?php

                                  echo 'value="'.$event['flightnum'].'"';
                                ?></td>
                              </tr>
            <tr>
                <td>Link To Airline logo (Optional)<br />ex: http://www.mysite.com/lib/images/logos/pic.png</td>
                <td><input type="text" name="image"
                           <?php echo 'value="'.$codeshare->image.'"'; ?>
                           ></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $codeshare->id; ?>" />
                    <input type="hidden" name="action" value="save_edit_codeshare" />
                    <input type="submit" value="Edit Codeshare"></td>
            </tr>

    </table>     </form>
