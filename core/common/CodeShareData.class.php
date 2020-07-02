<?php

class CodeShareData extends CodonData
{
    public static function get_codeshare()
    {
		return DB::get_results("SELECT * FROM ".TABLE_PREFIX."schedules WHERE codeshare=1 ORDER BY code ASC");

    }
 	public static function get_upcoming_codeshares()
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."codeshares
                ORDER BY schedid ASC";

        return DB::get_results($query);
    }
    public static function get_codeshares($id)
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."schedules WHERE id='$id'";

        return DB::get_row($query);
    }
    public static function getcodeshare($code)
    {
      $query= "SELECT * FROM ".TABLE_PREFIX."schedules WHERE code='.$code.'";

      return DB::get_row($query);
    }
   public static function get_past_codeshare()
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."codeshare
                ORDER BY schedid DESC";

        return DB::get_results($query);
    }
   public static function get_schedules()
   {
     $query = "SELECT * FROM ".TABLE_PREFIX."schedules
             ORDER BY id ASC";

     return DB::get_results($query);
   }
   public static function getDeptAirports($depicao)
   {
     $query = "SELECT * FROM ".TABLE_PREFIX."airports WHERE icao='$depicao'";

     return DB::get_row($query);
   }
   public static function getArrAirports($arricao)
   {
     $query = "SELECT * FROM ".TABLE_PREFIX."airports WHERE icao='$arricao'";

     return DB::get_row($query);
   }
   public static function get_aircraft($id)
   {
     $query = "SELECT * FROM ".TABLE_PREFIX."aircraft WHERE id='$id'";

     return DB::get_row($query);
   }
    public static function save_new_codeshare($code, $flightnum, $depicao, $arricao, $deptime, $arrtime, $daysofweek, $distance, $flighttime, $aircraft, $flightlevel, $flighttype, $route, $price, $enabled, $codeshare, $codenum)
    {
      $date = date("Y.m.d");

      $query = "INSERT INTO ".TABLE_PREFIX."schedules (code, flightnum, depicao, arricao, deptime, arrtime, daysofweek, distance, flighttime, aircraft, flightlevel, flighttype, route, price, dateadded, enabled, codeshare, codenum)
              VALUES ('$code', '$flightnum', '$depicao', '$arricao', '$deptime', '$arrtime', '$daysofweek', '$distance', '$flighttime', '$aircraft', '$flightlevel', '$flighttype', '$route', '$price', '$date', '$enabled', '$codeshare', '$codenum')";

      DB::query($query);
    }
    public static function getRouteDetails($schedule_id, $route = '') {

        $codeshare = SchedulesData::findSchedules(array('s.id' => $schedule_id), 1);
        $codeshare = $codeshare[0];

        if (empty($codeshare->route)) {
            return;
        }

        $route_details = NavData::parseRoute($codeshare);
        $store_details = DB::escape(serialize($route_details));

        $val = self::editScheduleFields($schedule_id, array('route_details' => $store_details));

        return $route_details;
    }

     public static function save_edit_codeshare($code, $flightnum, $depicao, $arricao, $deptime, $arrtime, $daysofweek, $distance, $flighttime, $aircraft, $flightlevel, $flighttype, $route, $price, $enabled, $codeshare, $codenum)
    {
        $query = "UPDATE ".TABLE_PREFIX."schedules SET
         code='$code',
         flightnum='$flightnum',
         depicao='$depicao',
         arricao='$arricao',
         deptime='$deptime',
         arrtime='$arrtime',
         daysofweek='$daysofweek',
         distance='$distance',
         flighttime='$flighttime',
         aircraft='$asircraft',
         flightlevel='$flightlevel',
         flighttype='$flighttype',
         route='$route',
         price='$price',
         enabled='$enabled',
         codeshare='$codeshare',
         codenum='$codenum'
         WHERE id='$id'";

        DB::query($query);
    }
    public static function delete_codeshare($id)
    {
        $query = "DELETE FROM ".TABLE_PREFIX."codeshares
                    WHERE id='$id'";

        DB::query($query);
    }
    public static function add_codeshare_airline($airname, $aircode, $airdesc, $airtype)
    {
      $query ="INSERT INTO ".TABLE_PREFIX."codeshareairline (airname, aircode, airdesc, airtype)
            VALUES ('$airname', '$aircode', '$airdesc', '$airtype')";

      DB::query($query);
    }
    public static function get_codeshare_airline()
    {
      return DB::get_results("SELECT * FROM ".TABLE_PREFIX."codeshareairline ORDER BY airname ASC");
    }
    public static function get_codeshare_airlines($aircode)
    {
      $query = "SELECT * FROM ".TABLE_PREFIX."codeshareairline
          WHERE aircode ='$aircode'";

      return DB::get_row($query);
    }
    public static function save_edit_codeshare_airline($airname, $airdesc, $airtype)
    {
      $query ="UPDATE ".TABLE_PREFIX."codeshareairline SET
        airname ='$airname',
        airdesc ='$airdesc',
        airtype ='$airtype'
        WHERE aircode='$aircode'";

      DB::query($query);
    }
    public static function delete_codeshare_airline($airid)
    {
      $query = "DELETE FROM ".TABLE_PREFIX."codeshareairline
                WHERE airid='$airid'";

      DB::query($query);
    }
    public static function get_upcoming_codeshare_airlines()
      {
          $query = "SELECT * FROM ".TABLE_PREFIX."codeshareairline
                  ORDER BY airid ASC";

          return DB::get_results($query);
      }
      public static function get_past_codeshare_airline()
       {
           $query = "SELECT * FROM ".TABLE_PREFIX."codeshareairline
                   ORDER BY airid DESC";

           return DB::get_results($query);
       }
}
