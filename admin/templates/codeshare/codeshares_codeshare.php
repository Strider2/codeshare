<?php

$this->show('codeshare/codeshare_header.php');



echo '<h4>Airline Flight number: '.$codeshare->code.''.$codeshare->flightnum.'</h4><hr />';
$airport = CodeShareData::getDeptAirports($codeshare->depicao);
$airports = CodeshareData::getArrAirports($codeshare->arricao);

echo 'Departure Airport: <b>'.$codeshare->depicao.' - '.$airport->name.'</b><br />';
echo 'Arrival Airport: <b>'.$codeshare->arricao.' - '.$airports->name.'</b><br />';
echo 'Departure Time: <b>'.$codeshare->deptime.'</b><br />';
echo 'Arrival Time: <b>'.$codeshare->arrtime.'</b><br />';
$aircraft = CodeShareData::get_aircraft($codeshare->aircraft);
echo 'Aircraft: <b>'.$aircraft->name.' '.$aircraft->registration.'</b><br />';
echo 'Airline: <b><img src="'. SITE_URL .'/lib/skins/SKIN_NAME_HERE/images/logos/'.$codeshare->code.'.png" alt="'.$codeshare->airline.'" /></b><hr />';

echo '</b><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/edit_codeshare?id='.$codeshare->id.'"><b>Edit Codeshare</b></a><br /><hr />';
echo '<a href="'.SITE_URL.'/admin/index.php/codeshare_admin/delete_codeshare?id='.$codeshare->id.'"><b>Delete Codeshare</b></a> - This will delete the codeshare flight from the datbase permanently!<br /><hr />';
?>
