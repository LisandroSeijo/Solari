<?php

namespace Solari;

use Solari\Drivers\YouTubeDriver;
use Solari\Drivers\SoundCloudDriver;
use Solari\Drivers\BandcampDriver;

class Solari
{
	/**
	* Services supported
	*
	* @var array
	*/
	static protected $supported = array(
		'youtube',
		'soundcloud',
		'bandcamp'
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

		try
		{
			return self::getDriver($url);
		}
		catch(Exception $ex)
		{
			throw new Exception($ex->getMessage());
		}
	}


	/**
	* Check the url and select driver
	*/
	protected static function getDriver($url)
	{
		try
		{
			switch (self::getDriverName($url)) 
			{
				case 'soundcloud':
					$driver = new SoundCloudDriver($url);
					break;

				case 'youtube':
					$driver = new YouTubeDriver($url);
					break;

				case 'bandcamp':
					$driver = new BandcampDriver($url);
					break;
				
				default:
					return false;		
			}
		}
		catch(Exception $ex)
		{
			throw new Exception($ex->getMessage());
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
