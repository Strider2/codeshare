<?php


$this->show('codeshare/codeshare_header.php');
$airlines = CodeShareData::get_codeshare_airline();
$allaircraft = OperationsData::getAllAircraft();
$flighttypes = Config::Get('FLIGHT_TYPES');
?>


<h4>Edit Codeshare Airline</h4>
<hr />
<form name="eventform" action="<?php echo SITE_URL; ?>/admin/index.php/codeshare_admin" method="post" >
<table width="80%">

            <tr>
                <td>Airline</td>
                <td>
                  <select name="code">
                  <?php

                  foreach($airlines as $airline) {
                          $sel = ($airline->aircode == $codeshare->code) ? 'selected' : '';
                    echo '<option value="'.$airline->code.'" '.$sel.'>'.$airline->code.' - '.$airline->name.'</option>';
                  }
                  ?>

            </tr>
            <tr>
                <td>Flight Number</td>
                <td><input type="text"  name="flightnum"
                           <?php echo 'value="'.$codeshare->flightnum.'"'; ?>
                           /></td>
            </tr>
            <tr>
                <td>Departure Airport</td>
                <td><input type="text" id="depicao" name="depicao"
                            <?php

                                  echo 'value="'.$codeshare->depicao.'" onclick=""';
                                ?>/></td>
                              </tr>
            <tr>
                <td>Arrival Airport</td>
                <td><input type="text" id="arricao" name="arricao"
                           <?php echo 'value="'.$codeshare->arricao.'" onclick=""'; ?>
                          /></td>
            </tr>
            <tr>
                <td>Departure Time</td>
                <td><input type="time" name="deptime"
                  <?php

                      echo 'value="'.$codeshare->deptime.'"';

                   ?>/>
            </tr>
            <tr>
                <td>Arrival Time</td>
                <td><input type="time" name="arrtime"
                      <?php
                        echo 'value="'.$codeshare->arrtime.'"';


                       ?>/>
            </tr>
            <tr>
              <td valign="top"><strong>Distance:</strong> </td>
              <td><input type="text" name="distance" id="distance"
                  <?php

                      echo 'value="'.$codeshare->distance.'"';


                   ?>/>
                   <br />

                <p><a href="#" onclick="calcDistance(); return false;">Calculate Distance</a>. Leaving blank or 0 (zero) will automatically calculate the distance.</p></td>
            </tr>
            <tr>
              <td valign="top"><strong>Flight Time:</strong> </td>
              <td><input type="time" name="flighttime"
                  <?php

                      echo 'value="'.$codeshare->flighttime.'"';


                   ?>/>
                   <br />

              <p>Please enter as HH:MM</p>
              </td>
            </tr>
            <tr>
              <td><strong>Equipment: </strong></td>
              <td><select name="aircraft">
                <?php

                foreach($allaircraft as $aircraft)
                {
                  if($aircraft->registration == $codeshare->registration)
                    $sel = 'selected';
                  else
                    $sel = '';

                  echo '<option value="'.$aircraft->id.'" '.$sel.'>'.$aircraft->name.' ('.$aircraft->registration.')</option>';
                } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td valign="top"><strong>Flight Level:</strong></td>
              <td><input type="text" name="flightlevel"
                <?php

                    echo 'value="'.$codeshare->flightlevel.'"';


                 ?>/>
                 <br />

              <p>Please enter as a full-numeric altitude. Should be in feet, to remain accurate with any ACARS.</p>
              </td>
            </tr>
            <tr>
              <td valign="top"><strong>Flight Type</strong></td>
              <td><select name="flighttype">
                  <?php

                  foreach($flighttypes as $flightkey=>$flighttype) {
                    if($codeshare->flighttype == $flightkey)
                      $sel = 'selected';
                    else
                      $sel = '';
                  ?>
                    <option value="<?php echo $flightkey?>" <?php echo $sel; ?>><?php echo $flighttype?> Flight</option>
                  <?php
                  }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td valign="top"><strong>Route (optional)</strong></td>
              <td><textarea name="route" style="width: 60%; height: 75px" id="route">
                <?php

                      echo $codeshare->route;

                 ?>
                </textarea>
                <p><a id="dialog" class="preview"
                  href="<?php echo SITE_URL?>/admin/action.php/operations/viewmap?type=preview">View Route</a></p>
              </td>
            </tr>
            <tr>
              <td valign="top"><strong>Price</strong> </td>
              <td><input type="text" name="price"
                  <?php
                    if(isset($event))
                    {
                      echo 'value="'.$codeshare->price.'"';
                    }

                   ?>/>
                   <br />

                <p>This is the ticket price, or price per <?php echo Config::Get('CARGO_UNITS'); ?>
                  for a cargo flight.</p>
              </td>
            </tr>
            <tr>
              <td valign="top"><strong><?php echo SITE_NAME;?> Flight number</strong></td>
              <td><input type="text" name="codenum"
                  <?php

                      echo'value="'.$codeshare->codenum.'"';


                   ?>/></td>
            </tr>
            <tr>
              <td valign="top"><strong>Enable</strong></td>
              <td><select id="enabled" name="enabled">
                  <option value="0">Disable</option>
                  <option value="1" selected>Enable</option></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $codeshare->id; ?>" />
                    <input type="hidden" name="action" value="save_edit_codeshare" />
                    <input type="hidden" name="daysofweek" value="0123456"/>
                    <input type="hidden" name="codeshare" value="1" />
                    <input type="submit" value="Edit Codeshare"></td>
            </tr>

    </table>     </form>
    <script type="text/javascript">
    $(".preview").click(function() {
      depicao=$("#depicao").val();
      arricao=$("#arricao").val();
      route=escape($("#route").val());

      url = this.href
        +"&depicao="+depicao
        +"&arricao="+arricao
        +"&route="+route;

      $('#jqmdialog').jqm({ajax: url}).jqmShow();

      return false;
    });

    $("#checkalldayssingle").live('click', function(e) {
        e.preventDefault();
        $("input.checkweek").attr('checked', true);
        return false;
    })

    $("#checknodayssingle").live('click', function(e) {
        e.preventDefault();
        $("input.checkweek").attr('checked', false);
        return false;
    })

    $("#checkalldays").live('click', function(e) {
        e.preventDefault();
        $("input.weekcheck").attr('checked', true);
        return false;
    })

    $("#checknodays").live('click', function(e) {
        e.preventDefault();
        $("input.weekcheck").attr('checked', false);
        return false;
    })

    <?php
    $airport_list = array();
    foreach($allairports as $airport) {
      $airport->name = addslashes($airport->name);
      $airport_list[] = "{label:\"{$airport->icao} ({$airport->name})\", value: \"{$airport->icao}\"}";
    }
    $airport_list = implode(',', $airport_list);
    ?>
    var airport_list = [<?php echo $airport_list; ?>];
    $(".airport_select").autocomplete({
      source: airport_list,
      minLength: 2,
      delay: 0
    });

    </script>
