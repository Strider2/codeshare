<?php

class CodeShareData extends CodonData
{
    public function get_codeshare()
    {
        $query = "'SELECT * FROM ".TABLE_PREFIX."codeshares'
                    ORDER BY schedid ASC";

        return DB::get_results($query);
		
    }
 	public function get_upcoming_codeshares()
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."codeshares
                ORDER BY schedid ASC";

        return DB::get_results($query);
    }
    public function get_codeshares($id)
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."codeshares WHERE id='$id'";

        return DB::get_row($query);
    }
   public function get_past_codeshare()
    {
        $query = "SELECT * FROM ".TABLE_PREFIX."codeshare
                ORDER BY schedid DESC";

        return DB::get_results($query);
    }
    public function save_new_codeshare($schedid, $airline, $image)
    {
        $query = "INSERT INTO ".TABLE_PREFIX."codeshares (schedid, airline, image)
                VALUES ('$schedid', '$airline', '$image')";

        DB::query($query);
    }
     public function save_edit_codeshare($schedid, $airline, $image, $id)
    {
        $query = "UPDATE ".TABLE_PREFIX."codeshares SET
         schedid='$schedid',
         airline='$airline',
		 image='$image'
         WHERE id='$id'";

        DB::query($query);
    }
    
    public function delete_codeshare($id)
    {
        $query = "DELETE FROM ".TABLE_PREFIX."codeshares
                    WHERE id='$id'";

        DB::query($query);
    }
   
}