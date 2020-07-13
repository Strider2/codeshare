<?php

class CodeShareData extends CodonData
{
    public static function get_codeshare()
    {
		return DB::get_results("SELECT * FROM ".TABLE_PREFIX."schedules WHERE codeshare = 1");

    }
 	public static function get_upcoming_codeshares()
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."schedules
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
        $query = "SELECT * FROM ".TABLE_PREFIX."schedules
                ORDER BY id DESC";

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

      $query = "INSERT IGNORE INTO ".TABLE_PREFIX."schedules (code, flightnum, depicao, arricao, deptime, arrtime, daysofweek, distance, flighttime, aircraft, flightlevel, flighttype, route, price, dateadded, enabled, codeshare, codenum)
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
    public static function findcodeshares($params, $count = '', $start = '') {
        $sql = 'SELECT s.*,
					a.id as aircraftid, a.name as aircraft, a.registration,
					a.minrank as aircraft_minrank, a.ranklevel as aircraftlevel,
					dep.name as depname, dep.lat AS deplat, dep.lng AS deplng,
					arr.name as arrname, arr.lat AS arrlat, arr.lng AS arrlng
				FROM ' . TABLE_PREFIX . 'schedules AS s
				LEFT JOIN ' . TABLE_PREFIX . 'airports AS dep ON dep.icao = s.depicao
				LEFT JOIN ' . TABLE_PREFIX . 'airports AS arr ON arr.icao = s.arricao
				LEFT JOIN ' . TABLE_PREFIX . 'aircraft AS a ON a.id = s.aircraft ';

        /* Build the select "WHERE" based on the columns passed, this is a generic function */
        $sql .= DB::build_where($params);

        // Order matters
        if (Config::Get('SCHEDULES_ORDER_BY') != '') {
            $sql .= ' ORDER BY ' . Config::Get('SCHEDULES_ORDER_BY');
        }

        if (strlen($count) != 0) {
            $sql .= ' LIMIT ' . $count;
        }

        if (strlen($start) != 0) {
            $sql .= ' OFFSET ' . $start;
        }

        $ret = DB::get_results($sql);

        if(!$ret) {
            return array();
        }

        return $ret;
    }
    public static function getCodeshareDetailed($id) {
        $codeshares = self::findCodeshares(array('s.id' => $id));
        if (!$codeshares) return false;

        $codeshare = $codeshares[0];
        unset($codeshares);

        /*$schedule->route_details = unserialize($schedule->route_details);
        if(!empty($schedule->route) && !$schedule->route_details)
        {
        $schedule->route_details = SchedulesData::getRouteDetails($schedule->id, $schedule->route);
        }*/

        if ($codeshare->route != '') {
            $codeshare->route_details = NavData::parseRoute($codeshare);
        }

        return $codeshare;
    }
    public static function delete_codeshare($id)
    {
        $query = "DELETE FROM ".TABLE_PREFIX."schedules
                    WHERE id='$id'";

        DB::query($query);
    }
    public static function getProperFlightNum($flightnum) {
        if ($flightnum == '') return false;

        $ret = array();
        $flightnum = strtoupper($flightnum);
        $airlines = self::get_codeshare_airlines(false);

        foreach ($airlines as $a) {
            $a->code = strtoupper($a->code);

            if (strpos($flightnum, $a->code) === false) {
                continue;
            }

            $ret['code'] = $a->code;
            $ret['flightnum'] = str_ireplace($a->code, '', $flightnum);

            return $ret;
        }

        # Invalid flight number
        $ret['code'] = '';
        $ret['flightnum'] = $flightnum;
        return $ret;
    }
    public static function incrementFlownCount($code, $flightnum) {
        return self::changeFlownCount($code, $flightnum, '+1');
    }


    /**
     * SchedulesData::changeFlownCount()
     *
     * @param mixed $code
     * @param mixed $flightnum
     * @param mixed $amount
     * @return void
     */
    public static function changeFlownCount($code, $flightnum, $amount) {

        $schedid = intval($schedid);

        $code = strtoupper($code);
        $flightnum = strtoupper($flightnum);

        if(substr_count($amount, '+') == 0) {
            $amount = '+'.$amount;
        }

        $sql = 'UPDATE ' . TABLE_PREFIX . "schedules
        SET timesflown=timesflown {$amount}
        WHERE code='{$code}' AND flightnum='{$flightnum}'";

        $res = DB::query($sql);

        if (DB::errno() != 0) return false;

        return true;

    }
    public static function setBidOnSchedule($scheduleid, $bidid) {
        $scheduleid = intval($scheduleid);
        $bidid = intval($bidid);

        $sql = 'UPDATE ' . TABLE_PREFIX . 'schedules
        SET `bidid`=' . $bidid . '
        WHERE `id`=' . $scheduleid;

        DB::query($sql);

        if (DB::errno() != 0) return false;

        return true;
    }

    public static function add_Bid($pilotid, $routeid) {
        $pilotid = DB::escape($pilotid);
        $routeid = DB::escape($routeid);

        if (DB::get_row('SELECT bidid FROM ' . TABLE_PREFIX . 'bids
						WHERE pilotid=' . $pilotid . ' AND routeid=' . $routeid)) {
            return false;
        }

        $pilotid = DB::escape($pilotid);
        $routeid = DB::escape($routeid);

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'bids (pilotid, routeid, dateadded)
				VALUES (' . $pilotid . ', ' . $routeid . ', NOW())';

        DB::query($sql);

        self::setBidOnSchedule($routeid, DB::$insert_id);

        if (DB::errno() != 0) return false;

        return true;
    }

    public static function save_codeshare_airline($code, $name, $codeshare, $airdesc, $type, $enabled)
    {
      $query ="INSERT IGNORE INTO ".TABLE_PREFIX."airlines (code, name, codeshare, airdesc, type, enabled)
            VALUES ('$code', '$name', '$codeshare', '$airdesc', '$type', '$enabled')";

      DB::query($query);
    }
    public static function get_codeshare_airline()
    {
      return DB::get_results("SELECT * FROM ".TABLE_PREFIX."airlines WHERE codeshare=1 ORDER BY name ASC");
    }
    public static function get_codeshare_airlines($code)
    {
      $query = "SELECT * FROM ".TABLE_PREFIX."airlines
          WHERE codeshare ='$code'";

      return DB::get_row($query);
    }
    public static function getCodeshareAirlines($code)
    {
      $query = "SELECT * FROM ".TABLE_PREFIX."airlines
          WHERE code ='$code'";

      return DB::get_row($query);
    }
    public static function save_edit_codeshare_airline($code, $name, $codeshare, $airdesc, $type, $enabled)
    {
      $query ="UPDATE ".TABLE_PREFIX."airlines SET
        code ='$code',
        name ='$name',
        codeshare ='$codeshare',
        airdesc ='$airdesc',
        type ='$type',
        enabled ='$enabled'
        WHERE code='$code'";

      DB::query($query);
    }
    public static function delete_codeshare_airline($airid)
    {
      $query = "DELETE FROM ".TABLE_PREFIX."airlines
                WHERE id='$airid'";

      DB::query($query);
    }
    public static function get_upcoming_codeshare_airlines()
      {
          $query = "SELECT * FROM ".TABLE_PREFIX."airlines
                  WHERE codeshare=1";

          return DB::get_results($query);
      }
      public static function get_past_codeshare_airline()
       {
           $query = "SELECT * FROM ".TABLE_PREFIX."airlines
                   ORDER BY id DESC";

           return DB::get_results($query);
       }
       /////////////////////////////////
       // Do not remove this code!   //
       ///////////////////////////////
       public static function getVersion()
       {
         return DB::get_results("SELECT * FROM ".TABLE_PREFIX."strider ORDER by id ASC");
       }
}
