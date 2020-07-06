<?php

class Codeshare extends CodonModule
{
	public function index()
	{
		$this->set('copyright', CodeShareData::getVersion());
		$this->set('codeshares', CodeShareData::get_codeshare());
		$this->render('codeshare/Codeshare.php');
	}
	public function airline()
	{
		$this->set('copyright', CodeShareData::getVersion());
		$this->set('airlines', CodeShareData::get_codeshare_airline());
		$this->render('codeshare/airline/Airlines.php');
	}
	public function airline_name($code='')
	{
		$this->set('copyright', CodeShareData::getVersion());
		$airlines = CodeShareData::getCodeshareAirlines($code);
		$codeshares = CodeShareData::getcodeshare($code);
		$this->set('airlines', $airlines);
		$this->render('codeshare/airline/Airlineview.php');
	}
	public function copyright()
	{
		$this->set('copyright', CodeShareData::getVersion());
		$this->render('codeshare/footer.php');
	}
}
