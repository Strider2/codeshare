<?php
$this->show('codeshare/codeshare_header.php');
$aircode = $codeshare->code;
$image = CodeShareData::get_codeshare_airlines($aircode);
echo 'Click On Flightnumber For Details/Editing<hr />';

echo '<h4>Codeshares</h4><hr />';
    if(!$codeshare)
    {
     echo 'No Codeshares found';

    }
    else
    {
  		echo '<table width="100%">';
    echo '<tr><td width="30%"><u>Flightnumber</u></td><td width="60%"><u>Airline</u></td><td width="30%">'.SITE_NAME.' flight Number</td></tr>';

    foreach($codeshare as $codeshare)
    {
        echo '<tr><td><a href="'.SITE_URL.'/admin/index.php/CodeShare_admin/get_codeshares?id='.$codeshare->id.'">'.$codeshare->code.''.$codeshare->flightnum.'</a></td>';
        echo '<td><img src="'.SITE_URL.'/lib/skins/SKIN_NAME_HERE/images/logos/'.$codeshare->code.'.png" alt="'.$image->airname.'" /></td>';
        echo '<td>'.$codeshare->codenum.'</td></tr>';
    }

    echo '</table>';

    }

?>
