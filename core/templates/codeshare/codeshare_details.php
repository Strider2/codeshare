<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<h3>Schedule Details</h3>
<div class="indent">
<strong>Flight Number: </strong> <?php echo $codeshares->code.$codeshares->flightnum ?><br />
<strong>Departure: </strong><?php echo $codeshares->depname ?> (<?php echo $codeshares->depicao ?>) at <?php echo $codeshares->deptime ?><br />
<strong>Arrival: </strong><?php echo $codeshares->arrname ?> (<?php echo $codeshares->arricao ?>) at <?php echo $codeshares->arrtime ?><br />
<?php
if($codeshares->route!='')
{ ?>
<strong>Route: </strong><?php echo $codeshares->route ?><br />
<?php
}?>
<br />
<strong>Weather Information</strong>
<div id="<?php echo $codeshares->depicao ?>" class="metar">Getting current METAR information for <?php echo $codeshares->depicao ?></div>
<div id="<?php echo $codeshares->arricao ?>" class="metar">Getting current METAR information for <?php echo $codeshares->arricao ?></div>
<br />
<strong>Schedule Frequency</strong>
<div align="center">
<?php
/*
	Added in 2.0!
*/
$chart_width = '800';
$chart_height = '170';

/* Don't need to change anything below this here */
?>
<div align="center" style="width: 100%;">
	<div align="center" id="pireps_chart"></div>
</div>

<script type="text/javascript" src="<?php echo fileurl('/lib/js/ofc/js/swfobject.js')?>"></script>
<script type="text/javascript">
swfobject.embedSWF("<?php echo fileurl('/lib/js/ofc/open-flash-chart.swf');?>",
	"pireps_chart", "<?php echo $chart_width;?>", "<?php echo $chart_height;?>",
	"9.0.0", "expressInstall.swf",
	{"data-file":"<?php echo actionurl('/schedules/statsdaysdata/'.$codeshares->id);?>"});
</script>
<?php
/* End added in 2.0
*/
if(!$copyright){
echo '<span style="color:red;">Please put the strider table in your database as this is required.</span>';

}

else{
  foreach($copyright as $copy){
echo $copy->copyright .' '.date("Y").' '.$copy->name.' '.$copy->module.' '.$copy->version.'.';
}
}

?>
</div>
