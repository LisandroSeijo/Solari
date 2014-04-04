<?php

namespace Solari\Config;

class Config
{
	static private $config;


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


	static public function checkLoad()
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
