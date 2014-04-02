<?php

namespace Solari;

use Solari\Drivers\YouTubeDriver;
use Solari\Drivers\SoundCloudDriver;

class Solari
{
	/**
	* Services supported
	*
	* @var array
	*/
	static protected $supported = array(
		'youtube',
		'soundcloud'
	);


	/**
	* Return a driver
	*/
	public static function sound($url)
	{
		if (!self::isSupported($url)) 
		{
			return false;
		}

		return self::getDriver($url);
	}


	/**
	* Check the url and select driver
	*/
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


	/**
	* Return driver name
	*/
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
	* Return if a url is supported
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
