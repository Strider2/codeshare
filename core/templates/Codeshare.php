<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript">
    $(function (){
        $('a.ajax').click(function() {
            var url = this.href;
            // show a spinner or something via css
            var dialog = $('<div style="display:none" class="loading"></div>').appendTo('body');
            
            // open the dialog
            dialog.dialog({
                // add a close listener to prevent adding multiple divs to the document
                close: function(event, ui) {
                    // remove div with all data and events
                    dialog.remove();
                },
                modal: true, height: 600, width: 800, position: ['center',80], title: "Schedule details"
            });
            // load remote content
            dialog.load(
                url, 
                {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
                function (responseText, textStatus, XMLHttpRequest) {
                    // remove the loading class
                    dialog.removeClass('loading');
                }
            );
            //prevent the browser to follow the link
            return false;
        });
    });
    </script>
<h3>Codeshare Flights</h3>

<?php
if(!$codeshares)
    {
    	echo '<span style="color:red;">No Codeshares</span>';
    }
    else {?>
<table width="100%" border="0">
<thead>
	<tr>
    	<th>Flight Number</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Airline</th>
        <th>Aircraft</th>
        <th>Details</th>
        <th>Book</th>
    </tr>
</thead>
<tbody>
	<?php 
    
    foreach($codeshares as $codeshares){
    	$codeshare_details = SchedulesData::getScheduleDetailed($codeshares->schedid);
        ?>
        <tr>
    	<td><a class="ajax" href="<?php echo SITE_URL?>/action.php/schedules/details/<?php echo $codeshare_details->id;?>"><span class="btn"><?php echo $codeshare_details->code; ?><?php echo $codeshare_details->flightnum; ?></span></a></td>
        <td><?php echo $codeshare_details->depicao; ?></td>
        <td><?php echo $codeshare_details->arricao; ?></td>
        <td><img src="<?php echo $codeshares->image; ?>" alt="<?php echo $codeshares->airline; ?>" /></td>
        <td><span class="label label-info"><?php echo $codeshare_details->aircraft; ?></span></td>
        <td><a href="<?php echo SITE_URL ?>/index.php/schedules/details/<?php echo $codeshare_details->id; ?>" >Details</a></td>
        <td><?php
    if(Auth::LoggedIn())
    {?>
		
	<?php
    }
    else
    {
    	echo 'Login first!';
     }
     ?>	
		<?php 
		# Don't allow overlapping bids and a bid exists
		if(Config::Get('DISABLE_SCHED_ON_BID') == true && $route->bidid != 0)
		{
		?>
			<a id="<?php echo $codeshare_details->id; ?>" class="addbid" 
                                        href="<?php echo url('/schedules/addbid');?>">Book Flight</a>
		<?php
		}
		else
		{
			
if(Auth::LoggedIn())
{
if($route->aircraftlevel > Auth::$userinfo->ranklevel)
{
?>
<b><font color="#FF0000">Above your rank!</font></b>
<?php
}
else
{
?><a id="<?php echo $codeshare_details->id; ?>" class="addbid" 
                                        href="<?php echo url('/schedules/addbid');?>">Book Flight</a>
                                        <?php
                                        }
                                        }
                                        }
                                        ?></td>
    </tr>
        <?php
    	
    }
   
    ?></tbody>
    </table>
<?php
}
?>
<hr />
&copy; Strider. Codeshare V1.3
