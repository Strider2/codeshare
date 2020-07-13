
				<h4 >


<?php echo $airlines->name;?> information</h4>

<table width="100%" border="0">
	<tr>
	    <td><img src="<?php echo SITE_URL;?>/lib/skins/SKIN_NAME_HERE/images/logos/<?php echo $airlines->code;?>.png" alt="<?php echo $airlines->name;?>"/></td>
	</tr>
<tr>
	<td><strong>Airline Code:</strong></td>
    <td><?php echo $airlines->code;?></td>
</tr>


<tr>
	<td><strong>Description:</strong></td>

    <td><?php echo $airlines->desc;?></td>
</tr>
<tr>
	<td>Airline Type</td>
		<?php if($airlines->type == 'P')
		{
			echo '<td>'.$airlines->type.' - Passenger</td>';
		}
		else {

			echo '<td>'.$airlines->type.' - Cargo</td>';

		}?>

	</tr>
</table>

<h3>Codeshare Flights</h3>

<?php
$codeshares = CodeShareStats::schedules($airlines->code);
if(!$codeshares)
    {
    	echo '<span style="color:red;">No Codeshare flights for '.$airlines->name.'</span>';
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

    foreach($codeshares as $codeshare){

			$aircraft = SchedulesData::getScheduleDetailed($codeshare->id);
			$codeshare_details = CodeShareData::get_codeshare_airlines($codeshare->code);

        ?>
        <tr>
    	<td><?php echo $codeshare->code; ?><?php echo $codeshare->flightnum; ?></td>
        <td><?php echo $codeshare->depicao; ?></td>
        <td><?php echo $codeshare->arricao; ?></td>
        <td><img src="<?php echo SITE_URL?>/lib/skins/SKIN_NAME_HERE/images/logos/<?php echo $codeshare->code;?>.png" alt="<?php echo $codeshare_details->name; ?>" /></td>
        <td><span class="label label-info"><?php echo $aircraft->aircraft; ?></span></td>
        <td><span class="label label-info"><?php echo $codeshare->codenum;?></span></td>
        <td><a href="<?php echo SITE_URL ?>/index.php/schedules/details/<?php echo $codeshare->id; ?>" >Details</a></td>
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
			<a id="<?php echo $codeshare->id; ?>" class="addbid"
                                        href="<?php echo url('/schedules/addbid');?>">Book Flight</a>
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
?><a id="<?php echo $codeshare->id; ?>" class="addbid"
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



<p><a href="<?php echo SITE_URL?>/index.php/Codeshare/Airline"><span class="btn">Back</span></a></p>
<p><a href="<?php echo SITE_URL?></index.php/Codeshare"><span class="btn">Back to Codeshares</span></a></p>

<!--Do not remove the copyright -->
<p><?php if(!$copyright){
echo '<span style="color:red;">Please put the strider table in your database as this is required.</span>';

}

else{
  foreach($copyright as $copy){
echo $copy->copyright .' '.date("Y").' '.$copy->name.' '.$copy->module.' '.$copy->version.'.';
}
}
 ?></p>
