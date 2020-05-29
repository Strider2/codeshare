<?php

class CodeShareData extends CodonData
{
    public static function get_codeshare()
    {
		return DB::get_results("SELECT * FROM ".TABLE_PREFIX."codeshares ORDER BY airline ASC");

    }
 	public static function get_upcoming_codeshares()
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."codeshares
                ORDER BY schedid ASC";

        return DB::get_results($query);
    }
    public static function get_codeshares($id)
    {
        $query = "SELECT id FROM ".TABLE_PREFIX."codeshares WHERE id='$id'";

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
    public static function save_new_codeshare($schedid, $airline, $flightnum)
    {
        $query = "INSERT INTO ".TABLE_PREFIX."codeshares (schedid, airline, flightnum)
                VALUES ('$schedid', '$airline', '$flightnum')";

        DB::query($query);
    }
     public static function save_edit_codeshare($schedid, $airline, $id)
    {
        $query = "UPDATE ".TABLE_PREFIX."codeshares SET
         schedid='$schedid',
         airline='$airline'
         WHERE id='$id'";

        DB::query($query);
    }

    public static function delete_codeshare($id)
    {
        $query = "DELETE FROM ".TABLE_PREFIX."codeshares
                    WHERE id='$id'";

        DB::query($query);
    }

}
