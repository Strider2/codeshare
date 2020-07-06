
<h3>Codeshare Flights</h3>

<?php
if(!$codeshares)
    {
    	echo '<span style="color:red;">No Codeshares</span>';
    }
    else {?>
<table width="100%" border="0">
<thead>
	<tr>
    	<th>Flight Number</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Airline</th>
        <th>Aircraft</th>
        <th>Codeshare Flight Number</th>
        <th>Details</th>
        <th>Book</th>
    </tr>
</thead>
<tbody>
	<?php

    foreach($codeshares as $codeshares){
      $aircraft = SchedulesData::getScheduleDetailed($codeshares->id);
      $codeshare_details = CodeShareData::getCodeshareAirlines($codeshares->code);

        ?>
        <tr>
    	<td><?php echo $codeshares->code; ?><?php echo $codeshares->flightnum; ?></td>
        <td><?php echo $codeshares->depicao; ?></td>
        <td><?php echo $codeshares->arricao; ?></td>
        <td><a href="<?php echo SITE_URL?>/index.php/Codeshare/airline_name/<?php echo $codeshares->code;?>"><img src="<?php echo SITE_URL?>/lib/skins/SKIN_NAME_HERE/images/logos/<?php echo $codeshares->code;?>.png" alt="<?php echo $codeshare_details->name; ?>" /></a></td>
        <td><span class="label label-info"><?php echo $aircraft->aircraft; ?></span></td>
        <td><span class="label label-info"><?php echo $codeshares->codenum;?></span></td>
        <td><a href="<?php echo SITE_URL ?>/index.php/schedules/details/<?php echo $codeshares->id; ?>" >Details</a></td>
        <td><?php
    if(Auth::LoggedIn())
    {?>

	<?php
    }
    else
    {
    	echo 'Login first!';
     }
     ?>
		<?php
		# Don't allow overlapping bids and a bid exists
		if(Config::Get('DISABLE_SCHED_ON_BID') == true && $route->bidid != 0)
		{
		?>
			<a id="<?php echo $codeshares->id; ?>" class="addbid"
                                        href="<?php echo url('/schedule/addbid');?>">Book Flight</a>
		<?php
		}
		else
		{

if(Auth::LoggedIn())
{
if($route->aircraftlevel > Auth::$userinfo->ranklevel)
{
?>
<b><font color="#FF0000">Above your rank!</font></b>
<?php
}
else
{
?><a id="<?php echo $codeshares->id; ?>" class="addbid"
                                        href="<?php echo url('/schedules/addbid');?>">Book Flight</a>
                                        <?php
                                        }
                                        }
                                        }
                                        ?></td>
    </tr>
        <?php

    }

    ?></tbody>
    </table>
<?php
}
?>
<hr />
<?php
if(!$copyright){
echo '<span style="color:red;">Please put the strider table in your database as this is required.</span>';

}

else{
  foreach($copyright as $copy){
echo $copy->copyright .' '.date("Y").' '.$copy->name.' '.$copy->module.' '.$copy->version.'.';
}
}
 ?>
