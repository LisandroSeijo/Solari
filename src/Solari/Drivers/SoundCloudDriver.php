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
	private $_data;


	/**
	* Construct
	* 
	* @param string $clientID
	* @param string $clientSecret
	*
	* @throws Exception if have problems with connect()
	*
	* @return void
	*/
	public function __construct($url)
	{
		$this->_data = new stdClass();
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
	*
	* @throws Exception if $clientID or $clientSecret is empty
	* @throws Exception if checkURL fails
	*
	* @return void
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
	*
	* @return boolean
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
	*
	* @param string $url
	*
	* @return void
	*/
	public function loadURL($url = null)
	{
		if ($url)
		{
			$this->_url = $url;
		}

		$this->_data = json_decode(
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
	*
	* @return void
	*/
	public function setClientID($val)
	{
		$this->_clientID = $val;
	}


	/**
	* Soundcloud client secret
	*
	* @param string
	*
	* @return void
	*/
	public function setClientSecret($val)
	{
		$this->_clientSecret = $val;
	}


	/**
	* Set url
	*
	* @param string
	*
	* @return void
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
	*
	* @return string
	*/
	public function getClientID()
	{
		return $this->_clientID;
	}


	/**
	* Return soundcloud client secret
	*
	* @return string
	*/
	public function getClientSecret()
	{
		return $this->_clientSecret;
	}


	/**
	* Return url
	*
	* @return string
	*/
	public function getURL()
	{
		return $this->_url;
	}


	/**
	* Return a specific attribute
	*
	* @param string $attribute attribute name
	*
	* @return mixed
	*/
	public function getAttribute($attribute)
	{
		return isset($this->_data->{$attribute}) ? $this->_data->{$attribute} : '';
	}


	/*
	|--------------------------------------------------------------------------
	| Common attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Iframe code to embed track
	*
	* @return string
	*/
	public function embed()
	{
		return $this->getAttribute('html');
	}


	/**
	* Track title
	*
	* @return string
	*/
	public function title()
	{
		return $this->getAttribute('title');
	}


	/**
	* Track description
	*
	* @return string
	*/
	public function description()
	{
		return $this->getAttribute('description');
	}


	/**
	* Track image
	*
	* @return string
	*/
	public function img()
	{
		return $this->getAttribute('thumbnail_url');
	}


	/*
	|--------------------------------------------------------------------------
	| Soundcloud attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Track artist
	*
	* @return string
	*/
	public function artist()
	{
		return $this->getAttribute('author_name');
	}


	/**
	* URL track artist
	*
	* @return string
	*/ 
	public function artistURL()
	{
		return $this->getAttribute('author_url');
	}
}
