<?php

namespace Solari\Drivers;


abstract class SolariDriver 
{
	/**
	* Iframe code to embed
	*/
	abstract protected function embed();

	/**
	* Return title
	*/
	abstract protected function title();

	/**
	* Return description
	*/
	abstract protected function description();

	/**
	* Return image
	*/
	abstract protected function img();

	/**
	* Return data in json
	*/
	public function toJson()
	{
		return json_encode(
			array(
				'title'       => $this->title(),
				'description' => $this->description(),
				'img'         => $this->img(),
				'embed'       => $this->embed()
			)
		);
	}
}
