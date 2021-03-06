<?php

namespace Solari\Drivers;

use \Exception;


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
	*
	* @return json
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


	/**
	* Save image in a folder
	*
	* @param string $path destination folder
	* @param string $imgName image's name 
	* @param boolean $addExtention add the extention to $imgName
	*
	* @return boolean
	*/
	public function saveImage($path, $imgName, $addExtension = false)
	{
		if (!$this->img())
		{
			return false;
		}

		if (!is_dir($path))
		{
			return false;
		}

		if (!is_writable($path))
		{
			return false;
		}

		if ($addExtension)
		{
			$imgName .= '.'.$this->getExtensionImagen();
		}

		$image = file_get_contents($this->img());
		$dest  = $path.'/'.$imgName;
		
		if (file_put_contents($dest, $image) === false)
		{
			return false;
		}

		return true;
	}


	/**
	* Return image extension
	*
	* @return string
	*/
	public function getExtensionImagen()
	{
		return pathinfo($this->img(), PATHINFO_EXTENSION);
	}
}
