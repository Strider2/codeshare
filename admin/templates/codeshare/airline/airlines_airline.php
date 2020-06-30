<?php

$this->show('codeshare/codeshare_header.php');
echo '<h4>Airline Name:'.$airlines->airname.'</h4><hr />';



echo 'Airline logo: <b><img src="'. SITE_URL .'/lib/skins/SKIN_NAME_HERE/images/logos/'.$airlines->aircode.'.png" alt="'.$airlines->airname.'" /></b><hr />';

echo '</b><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/edit_codeshare_airline?aircode='.$airlines->aircode.'"><b>Edit Airline</b></a><br /><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/delete_codeshare_airline?airid='.$airlines->airid.'"><b>Delete Airline</b></a> - This will delete the Airline from the datbase permanently!<br /><hr />';
?>
