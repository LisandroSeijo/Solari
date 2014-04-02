<?php

namespace Solari;

use Solari\Drivers\YouTubeDriver;
use Solari\Drivers\SoundCloudDriver;

class Solari
{
	static protected $supported = array(
		'youtube',
		'soundcloud'
	);


	/**
	* Un driver de la web
	*/
	public static function sound($url)
	{
		if (!self::isSupported($url)) 
		{
			return false;
		}

		return self::getDriver($url);
	}


	protected static function getDriver($url)
	{
		switch (self::getDriverName($url)) 
		{
			case 'soundcloud':
				$driver = new SoundCloudDriver($url);
				break;

			case 'youtube':
				$driver = new YouTubeDriver($url);
				break;
			
			default:
				return false;		
		}

		return $driver;
	}


	protected static function getDriverName($url)
	{
		$ret   = null;
		$parse = parse_url($url);

		foreach(self::$supported as $s)
		{
			if (strpos($parse['host'], $s) !== false)
			{
				$ret = $s;
				break;
			}
		}

		return $ret;
	}


	/**
	* Devuelve si la url es soportada
	*/
	public static function isSupported($url)
	{
		$ret = false;
		
		if (self::getDriverName($url))
		{
			$ret = true;
		}

		return $ret;
	}
}
