<?php

namespace Solari\Config;

class Config
{
	/**
	* Config data
	*
	* @var array
	*/
	static private $config;


	/**
	* Return a config value
	*
	* @param $key key
	* @param $value value
	*
	* @return mixed
	*/
	static public function get($key, $value = null)
	{
		if (!self::checkLoad())
		{
			return false;
		}

		if ((!$value && !isset(self::$config[$key])) || 
			$value && !isset(self::$config[$key][$value]))
		{
			return false;
		}
		
		return $value ? self::$config[$key][$value] : self::$config[$key];
	}


	/**
	* Check if the $config id loaded
	*
	* @return boolean
	*/
	static private function checkLoad()
	{
		if (empty(self::$config))
		{
			$fileConfig = __DIR__.'/Data.php';

			if (!is_file($fileConfig))
			{
				return false;
			}

			self::$config = require $fileConfig;
		}

		return true;
	}
}
