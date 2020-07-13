Codeshare 2.2

This adds the ability for you to navigate back to the codeshare flights from the codeshare airline list and airline view.

phpVMS module to list codeshare flights in your VA.

You will need to edit the core>templates>codeshare.php file:

replace all references to SKIN NAME HERE with the name of your skin in the following files:
core/templates/codeshare/Codeshare.php
core/templates/codeshare/airline/Airlines.php
core/templates/codeshare/airline/Airlineview.php
admin/templates/codeshare/codeshare_index.php
admin/templates/codeshare/codeshares_codeshare.php
admin/templates/codeshare/airline/airline_index.php
admin/templates/codeshare/airline/airlines_airline.php

add the file logos with the logos in it to the images folder within the skin folder.

You will need to add "codeshare and codenum to the schedules table.

Add the following columns to the schedules table:
codeshare tinyint 1 NULL
codenum varchar 10 NULL
dateadded datetime NULL

Add the following to the airlines table:
codeshare tinyint(1) NULL
airdesc varchar(350) NULL
type varchar(1) NULL

For your other airlines add a 0 to the codeshare column so the bellow code will work.

Edit your registration main form and add the following to where it is looking for to choose an airline:
<?php foreach($airline_list as $airline) {
			if($airline->codeshare == "0"){
			echo '<option value="'.$airline->code.'">'.$airline->code.' - '.$airline->name.'</option>';
		}
		
		}?>
I have included the form if you have not styled it. That code will make it so only your main airline/s are the ones that can be chosen to join as.

Import the phpvms_strider.sql file as it is required to maintain the copyright on this module.

If you have already imported the above SQL from V2.1 please import the file update_strider.sql file. It will update the copyright to show the correct version.

Released under the following license:
Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License