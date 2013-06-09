<?php
$this->show('codeshare/codeshare_header.tpl');

echo 'Click On Codeshare For Details/Editing<hr />';

echo '<h4>Codeshares</h4><hr />';
    if(!$codeshare)
    {
     echo 'No Codeshares found';
       
    }
    else
    {
  		echo '<table width="100%">';
    echo '<tr><td width="30%"><u>Schedule ID</u></td><td width="60%"><u>Airline</u></td></tr>';

    foreach($codeshare as $codeshare)
    {
        echo '<tr><td><a href="'.SITE_URL.'/admin/index.php/CodeShare_admin/get_codeshares?id='.$codeshare->id.'">'.$codeshare->schedid.'</a></td>';
        echo '<td><img src="'.SITE_URL.'/lib/images/logos/'.$codeshare->airline.'.png" alt="'.$codeshare->airline.'" /></td></tr>';
    }
    
    echo '</table>';
       
    }

?>