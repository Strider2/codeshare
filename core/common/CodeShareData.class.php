<?php

class CodeShareData extends CodonData
{
    public static function get_codeshare()
    { 
		return DB::get_results("SELECT * FROM ".TABLE_PREFIX."codeshares ORDER BY airline ASC");
		
    }
 	public static function get_upcoming_codeshares()
    {
        $query = "SELECT * FROM phpvms_codeshares
                ORDER BY schedid ASC";

        return DB::get_results($query);
    }
    public static function get_codeshares($id)
    {
        $query = "SELECT * FROM phpvms_codeshares WHERE id='$id'";

        return DB::get_row($query);
    }
   public static function get_past_codeshare()
    {
        $query = "SELECT * FROM phpvms_codeshare
                ORDER BY schedid DESC";

        return DB::get_results($query);
    }
<<<<<<< HEAD
    public static function save_new_codeshare($schedid, $airline)
=======
    public function save_new_codeshare($schedid, $airline, $image)
>>>>>>> origin/master
    {
        $query = "INSERT INTO phpvms_codeshares (schedid, airline, image)
                VALUES ('$schedid', '$airline', '$image')";

        DB::query($query);
    }
<<<<<<< HEAD
     public static function save_edit_codeshare($schedid, $airline, $id)
=======
     public function save_edit_codeshare($schedid, $airline, $image, $id)
>>>>>>> origin/master
    {
        $query = "UPDATE phpvms_codeshares SET
         schedid='$schedid',
         airline='$airline',
         image= '$image',
         WHERE id='$id'";

        DB::query($query);
    }
    
    public static function delete_codeshare($id)
    {
        $query = "DELETE FROM phpvms_codeshares
                    WHERE id='$id'";

        DB::query($query);
    }
   
}
