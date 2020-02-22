<?php
$this->show('codeshare/codeshare_header.php');

echo 'Click On Codeshare For Details/Editing<hr />';

echo '<h4>Codeshares</h4><hr />';
    if(!$codeshare)
    {
     echo 'No Codeshares found';

    }
    else
    {
  		echo '<table width="100%">';
    echo '<tr><td width="30%"><u>Schedule ID</u></td><td width="60%"><u>Airline</u></td><td width="30%">flight Number</td></tr>';

    foreach($codeshare as $codeshare)
    {
        echo '<tr><td><a href="'.SITE_URL.'/admin/index.php/CodeShare_admin/get_codeshares?id='.$codeshare->id.'">'.$codeshare->schedid.'</a></td>';
        echo '<td><img src="'.$codeshare->image.'" alt="'.$codeshare->airline.'" /></td>';
        echo '<td>'.$codeshare->airline.''.$codeshare->flightnum.'</td></tr>';
    }

    echo '</table>';

    }

?>
