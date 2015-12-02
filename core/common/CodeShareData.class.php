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
}
?>