<?php

class Codeshare extends CodonModule
{
	public function index()
	{
		$this->set('codeshares', CodeShareData::get_codeshare());
		$this->render('codeshare/Codeshare.php');
	}
	public function airline()
	{
		$this->set('airlines', CodeShareData::get_codeshare_airline());
		$this->render('codeshare/airline/Airlines.php');
	}
	public function airline_name($aircode='')
	{
		$airlines = CodeShareData::get_codeshare_airlines($aircode);
		$codeshares = CodeShareData::getcodeshare($aircode);
		$this->set('airlines', $airlines);
		$this->render('codeshare/airline/Airlineview.php');
	}
}
