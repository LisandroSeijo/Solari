<?php

namespace Solari\Drivers;

use \Exception;
use \stdClass;
use \Solari\Config\Config;

class SoundCloudDriver extends SolariDriver
{
	/**
	* Client ID
	* 
	* @var string
	*/
	private $_clientID = '';

	/**
	* Client secret
	* 
	* @var string
	*/
	private $_clientSecret = '';

	/**
	* API connection
	* 
	* @var Soundcloud\Service
	*/
	private $_client;

	/**
	* Track URL
	*
	* @var string
	*/
	private $_url;

	/**
	* Track
	*
	* @var stdClass
	*/
	private $_track;


	/**
	* Construct
	* 
	* @param string $clientID
	* @param string $clientSecret
	*/
	public function __construct($url)
	{
		$this->_track = new stdClass();
		$this->_url = $url;
		
		try
		{
			$this->connect();
		}
		catch(Exception $ex)
		{
			throw new Exception($ex->getMessage());
		}
	}


	/**
	* Class initialize
	*/
	private function connect()
	{
		if (!$scConfig = Config::get('soundcloud'))
		{
			throw new Exception('Config error');
		}

		$this->_clientID     = $scConfig['client_id'];
		$this->_clientSecret = $scConfig['client_secret'];

		if (empty($this->_clientID) || empty($this->_clientSecret))
		{
			throw new Exception('Client id or Client secret is empty');
		}

		$this->_client = new \Soundcloud\Service(
			$this->_clientID, 
			$this->_clientSecret
		);

		$this->_client->setCurlOptions(
			array(CURLOPT_FOLLOWLOCATION => 1)
		);

		if (!$this->checkURL($this->_url))
		{
			throw new Exception('Bad url');
		}

		$this->loadURL();
	}


	/**
	* Check if url exists
	*
	* @param string $url
	*/
	public function checkURL($url = null)
	{
		if (!$url) 
		{
			$url = $this->_url;
		}
		
		try
		{
			$this->_client->get($url);
			return true;
		}
		catch(Exception $ex)
		{
			return false;
		}
	}


	/**
	* Load track info
	*/
	public function loadURL($url = null)
	{
		if ($url)
		{
			$this->_url = $url;
		}

		$this->_track = json_decode(
			$this->_client->get(
				'oembed', array('url' => $this->_url)
			)
		);
	}


	/*
	|--------------------------------------------------------------------------
	| Sets
	|--------------------------------------------------------------------------
	*/
	/**
	* Soundcloud client id
	*
	* @param string
	*/
	public function setClientID($val)
	{
		$this->_clientID = $val;
	}


	/**
	* Soundcloud client secret
	*
	* @param string
	*/
	public function setClientSecret($val)
	{
		$this->_clientSecret = $val;
	}


	/**
	* Set url
	*
	* @param string
	*/
	public function setURL($val)
	{
		$this->_url = $val;
		$this->loadURL();
	}


	/*
	|--------------------------------------------------------------------------
	| Gets
	|--------------------------------------------------------------------------
	*/
	/**
	* Return soundcloud client id
	*/
	public function getClientID()
	{
		return $this->_clientID;
	}


	/**
	* Return soundcloud client secret
	*/
	public function getClientSecret()
	{
		return $this->_clientSecret;
	}


	/**
	* Return url
	*/
	public function getURL()
	{
		return $this->_url;
	}


	private function getTrackAttribute($attribute)
	{
		return isset($this->_track->{$attribute}) ? $this->_track->{$attribute} : '';
	}


	/*
	|--------------------------------------------------------------------------
	| Common attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Iframe code to embed track
	*/
	public function embed()
	{
		return $this->getTrackAttribute('html');
	}


	/**
	* Track title
	*/
	public function title()
	{
		return $this->getTrackAttribute('title');
	}


	/**
	* Track description
	*/
	public function description()
	{
		return $this->getTrackAttribute('description');
	}


	/**
	* Track image
	*/
	public function img()
	{
		return $this->getTrackAttribute('thumbnail_url');
	}


	/*
	|--------------------------------------------------------------------------
	| Soundcloud attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Track artist
	*/
	public function artist()
	{
		return $this->getTrackAttribute('author_name');
	}


	/**
	* URL track artist
	*/ 
	public function artistURL()
	{
		return $this->getTrackAttribute('author_url');
	}
}
