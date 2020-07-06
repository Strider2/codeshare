<?php
$this->show('codeshare/codeshare_header.php');

echo 'Click On airline For Details/Editing<hr />';

echo '<h4>Airlines</h4><hr />';
    if(!$airlines)
    {
     echo 'No Codeshare airlines found';

    }
    else
    {
  		echo '<table width="100%">';
    echo '<tr><td width="30%"><u>Airline</u></td><td width="60%"><u>Code</u></td><td width="30%">Image</td></tr>';

    foreach($airlines as $airline)
    {
        echo '<tr><td><a href="'.SITE_URL.'/admin/index.php/CodeShare_admin/get_codeshare_airlines?code='.$airline->code.'">'.$airline->name.'</a></td>';
        echo '<td>'.$airline->code.'</td></tr>';
          echo '<td><img src="'.SITE_URL.'/lib/skins/SKIN_NAME_HERE/images/logos/'.$airline->code.'.png" alt="'.$airline->name.'" /></td>';
    }

    echo '</table>';

    }

?>
