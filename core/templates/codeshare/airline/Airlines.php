
<h3>Codeshare Airlines</h3>

<?php
if(!$airlines)
    {
    	echo '<span style="color:red;">No Codeshare airlines</span>';
    }
    else {?>
<table width="100%" border="0">
<thead>
	<tr>
    	<th>Airline Name</th>
        <th>Image</th>
        <th>Airline type</th>
        <th>Details</th>
    </tr>
</thead>
<tbody>
	<?php

    foreach($airlines as $airline){

        ?>
        <tr>
    	<td><?php echo $airline->aircode; ?> - <?php echo $airline->airname; ?></td>
        <td><img src="<?php echo SITE_URL?>/lib/skins/iCrew/images/logos/<?php echo $airline->aircode; ?>.png" alt="<?php echo $airline->airname;?>"/></td>
        <?php
          if($airline->airtype == 'P')
          {
            echo '<td>'.$airline->airtype.' - Passenger</td>';
          }
          else
          {
            echo '<td>'.$airline->airtype.' - Cargo</td>';
          }
         ?>

        <td><a href="<?php echo SITE_URL?>/index.php/codeshare/airline_name/<?php echo $airline->aircode;?>">Details</a></td>
</tr>
        <?php

    }

    ?></tbody>
    </table>
<?php
}
?>
<hr />
&copy; Strider. Codeshare V2
