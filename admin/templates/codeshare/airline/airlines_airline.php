<?php

$this->show('codeshare/codeshare_header.php');
echo '<h4>Airline Name:'.$airlines->name.'</h4><hr />';



echo 'Airline logo: <b><img src="'. SITE_URL .'/lib/skins/SKIN_NAME_HERE/images/logos/'.$airlines->code.'.png" alt="'.$airlines->name.'" /></b><hr />';

echo '</b><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/edit_codeshare_airline?id='.$airlines->id.'"><b>Edit Airline</b></a><br /><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/delete_codeshare_airline?id='.$airlines->id.'"><b>Delete Airline</b></a> - This will delete the Airline from the datbase permanently!<br /><hr />';
?>
