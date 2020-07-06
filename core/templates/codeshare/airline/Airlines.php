<?php
$copy = CodeShareData::getVersion();
 ?>
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
    	<td><?php echo $airline->code; ?> - <?php echo $airline->name; ?></td>
        <td><img src="<?php echo SITE_URL?>/lib/skins/SKIN_NAME_HERE/images/logos/<?php echo $airline->code; ?>.png" alt="<?php echo $airline->name;?>"/></td>
        <?php
          if($airline->type == 'P')
          {
            echo '<td>'.$airline->type.' - Passenger</td>';
          }
          else
          {
            echo '<td>'.$airline->type.' - Cargo</td>';
          }
         ?>

        <td><a href="<?php echo SITE_URL?>/index.php/codeshare/airline_name/<?php echo $airline->code;?>">Details</a></td>
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
