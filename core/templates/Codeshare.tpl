
<h3>Codeshare Flights</h3>


<table width="100%" border="0">
<thead>
	<tr>
    	<th>Flight Number</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Airline</th>
        <th>Aircraft</th>
        <th>Details</th>
    </tr>
</thead>
<tbody>
	<?php 
    foreach($codeshares as $codeshares){
    	$codeshare_details = SchedulesData::getScheduleDetailed($codeshares->schedid);
        ?>
        <tr>
    	<td><?php echo $codeshare_details->code; ?><?php echo $codeshare_details->flightnum; ?></td>
        <td><?php echo $codeshare_details->depicao; ?></td>
        <td><?php echo $codeshare_details->arricao; ?></td>
        <td><img src="<?php echo SITE_URL;?>/lib/skins/skin_name/images/logos/<?php echo $codeshares->airline; ?>.png" alt="<?php echo $codeshares->airline; ?>" /></td>
        <td><span class="label label-info"><?php echo $codeshare_details->aircraft; ?></span></td>
        <td><a href="<?php echo SITE_URL ?>/index.php/schedules/details/<?php echo $codeshare_details->id; ?>" >Details</a></td>
    </tr>
        <?php
    	
    }
    ?></tbody>
    </table>

