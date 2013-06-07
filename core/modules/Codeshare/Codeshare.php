<?php

class Codeshare extends CodonModule 
{
	public function index()
	{
		$sql = 'SELECT * FROM phpvms_codeshares';
		$codeshare = DB::get_results($sql);
		$this->set('codeshares', $codeshare);
		$this->render('Codeshare.tpl');
	}
	
}
