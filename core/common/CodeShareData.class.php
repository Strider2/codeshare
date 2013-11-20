<?php

class CodeShareData extends CodonData
{
    public function get_codeshare()
    { 
		return DB::get_results("SELECT * FROM ".TABLE_PREFIX."codeshares ORDER BY airline ASC");
		
    }
 	public function get_upcoming_codeshares()
    {
        $query = "SELECT * FROM phpvms_codeshares
                ORDER BY schedid ASC";

        return DB::get_results($query);
    }
    public function get_codeshares($id)
    {
        $query = "SELECT * FROM phpvms_codeshares WHERE id='$id'";

        return DB::get_row($query);
    }
   public function get_past_codeshare()
    {
        $query = "SELECT * FROM phpvms_codeshare
                ORDER BY schedid DESC";

        return DB::get_results($query);
    }
    public function save_new_codeshare($schedid, $airline)
    {
        $query = "INSERT INTO phpvms_codeshares (schedid, airline)
                VALUES ('$schedid', '$airline')";

        DB::query($query);
    }
     public function save_edit_codeshare($schedid, $airline, $id)
    {
        $query = "UPDATE phpvms_codeshares SET
         schedid='$schedid',
         airline='$airline'
         WHERE id='$id'";

        DB::query($query);
    }
    
    public function delete_codeshare($id)
    {
        $query = "DELETE FROM phpvms_codeshares
                    WHERE id='$id'";

        DB::query($query);
    }
   
}