Codeshare 2

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

You will need to add "codeshare and codenum to the schedules table also remove the constraints on the code, you can find this by going into the schedules table, going to structure and going into relation view, click on drop on the constraint on the code.Before doing that, take a back up of the schedules table to protect from any problems that might arise. I will not be held accountable for the schedule database being destroyed and unrecoverable.

Released under the following license:
Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported License