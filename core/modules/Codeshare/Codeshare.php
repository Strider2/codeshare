<?php

class Codeshare extends CodonModule 
{
	public function index()
	{
		$this->set('codeshares', CodeShareData::get_codeshare());
		$this->render('Codeshare.php');
	}
	
}
