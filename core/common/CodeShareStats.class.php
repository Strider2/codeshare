<?php
class CodeShareStats extends Codondata {

public static function schedules($code) { //schedules details
$query = "SELECT * FROM ".TABLE_PREFIX."schedules WHERE code = '".$code."'";
return DB::get_results($query);
}
public static function airports($icao) { //schedules details
$query = "SELECT * FROM ".TABLE_PREFIX."airports WHERE icao = '".$icao."'";
return DB::get_results($query);
}

}
?>
