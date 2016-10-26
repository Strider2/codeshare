<?php

$this->show('codeshare/codeshare_header.php');
echo '<h4>Airline Schedule ID:'.$codeshare->schedid.'</h4><hr />';



echo 'Airline: <b><img src="'. SITE_URL .'/lib/images/logos/'.$codeshare->airline.'.png" alt="'.$codeshare->airline.'" /></b><hr />';

echo '</b><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/edit_codeshare?id='.$codeshare->id.'"><b>Edit Codeshare</b></a><br /><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/delete_codeshare?id='.$codeshare->id.'"><b>Delete Codeshare</b></a> - This will delete the codeshare flight from the datbase permanently!<br /><hr />';
?>
