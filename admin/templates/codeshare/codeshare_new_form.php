<?php

$this->show('codeshare/codeshare_header.php');
$airlines = CodeShareData::get_codeshare_airline();
$allaircraft = OperationsData::getAllAircraft();
$flighttypes = Config::Get('FLIGHT_TYPES');
if(isset($codeshare))
{echo '<div id="error">All fields must be filled out</div>'; }
?>

<h4>Create New CodeShare</h4>
<span style="color:red;">Note: You must have already added the airline to the airlines db before you can add the codeshare flight.</span>
<table width="80%">
  <form name="eventform" action="<?php echo SITE_URL; ?>/admin/index.php/CodeShare_admin" method="post">
  <table width="100%" class="tablesorter">
  <tr>
    <td valign="top"><strong>Code: </strong></td>
    <td>
      <select name="code">
      <?php

      foreach($airlines as $airline) {
              $sel = ($airline->code == $codeshare->code) ? 'selected' : '';
        echo '<option value="'.$airline->code.'" '.$sel.'>'.$airline->code.' - '.$airline->name.'</option>';
      }
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><strong>Flight Number:</strong></td>
    <td>
      <input type="text" name="flightnum"
      <?php
      if(isset($event))
      {
          echo 'value="'.$event['flightnum'].'"';
      }
       ?>/>

    </td>
  </tr>
  <tr>
    <td width="3%" nowrap><strong>Departure Airport:</strong></td>
    <td><input id="depicao" name="depicao" class="airport_select"
        <?php
        if(isset($event))
        {
          echo 'value="'.$event['depicao'].'" onclick=""';
        }
        ?>/>

    </td>
  </tr>
  <tr>
    <td><strong>Arrival Airport:</strong></td>
    <td><input id="arricao" name="arricao" class="airport_select"
      <?php
        if(isset($event))
        {
          echo 'value="'.$event['arricao'].'" onclick=""';
        }
       ?>/>
    </td>
  </tr>
  <tr>
    <td valign="top"><strong>Departure Time:</strong> </td>
    <td><input type="time" name="deptime"
      <?php
        if(isset($event))
        {
          echo 'value="'.$event['deptime'].'"';
        }

       ?>/>
       <br />
      <p>Please enter time as: HH::MM Timezone (eg: 17:30 EST, or 5:30 PM EST)</p>
    </td>
  </tr>
  <tr>
    <td valign="top"><strong>Arrival Time:</strong> </td>
    <td><input type="time" name="arrtime"
        <?php
          if(isset($event))
          {
            echo 'value="'.$event['arrtime'].'"';
          }
        ?>/><br />


      <p>Please enter time as: HH::MM Timezone (eg: 17:30 EST, or 5:30 PM EST)</p>
    </td>
  </tr>
  <tr>
    <td valign="top"><strong>Distance:</strong> </td>
    <td><input type="text" name="distance" id="distance"
        <?php
          if(isset($event))
          {
            echo 'value="'.$event['distance'].'"';
          }

         ?>/>
         <br />

      <p><a href="#" onclick="calcDistance(); return false;">Calculate Distance</a>. Leaving blank or 0 (zero) will automatically calculate the distance.</p></td>
  </tr>
  <tr>
    <td valign="top"><strong>Flight Time:</strong> </td>
    <td><input type="text" name="flighttime"
        <?php
          if(isset($event))
          {
            echo 'value="'.$event['flighttime'].'"';
          }

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
        if(isset($event))
        {
          echo 'value="'.$event['flightlevel'].'"';
        }

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
          if(isset($event))
          {
            echo 'value="'.$event['route'].'"';
          }
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
            echo 'value="'.$event['price'].'"';
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
          if(isset($event))
          {
            echo'value="'.$event['codenum'].'"';
          }

         ?>/></td>
  </tr>
  <tr>
    <td valign="top"><strong>Enable</strong></td>
    <td><select id="enabled" name="enabled">
        <option value="0">Disable</option>
        <option value="1" selected>Enable</option></td>
  </tr>

  <tr>
    <td></td>
    <td><input type="hidden" name="action" value="<?php echo $action;?>" />
      <input type="hidden" name="id" value="<?php echo $codeshare->id;?>" />
      <input type="hidden" name="dateadded" value="<?php date("D-m-y");?>"/>
      <input type="hidden" name="daysofweek" value="0123456"/>
      <input type="hidden" name="codeshare" value="1" />
      <input type="submit" name="submit" value="<?php echo $title;?>" />
    </td>
  </tr>
  </table>
  </form>
  </div>
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
