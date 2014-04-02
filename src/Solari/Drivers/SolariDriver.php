<?php

class SolariDriver 
{
	protected $embed;


	protected $error = false;


	protected $errorMsg;


	public function hasError()
	{
		return $this->error;
	}


	public function errorMsg()
	{
		return $this->errorMsg;
	}


	protected function error($msg = null)
	{
		$this->error    = true;
		$this->errorMsg = $msg ? $msg : 'Fuck, shit happens';
	}
}
