<?php

namespace Solari\Drivers;

use \Exception as Exception;
use \stdClass as stdClass;

class SoundCloudDriver
{
	/**
	* Client ID
	* 
	* @var string
	*/
	private $_clientID = 'c64092aff862ad97ddeb272d61427dca';


	/**
	* Client secret
	* 
	* @var string
	*/
	private $_clientSecret = 'b0c90d275cf66fb86e89a592e9d3908f';


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
	public function __construct($url = null, $clientID = null, $clientSecret = null)
	{
		$this->_track = new stdClass();

		if ($url) $this->_url = $url;
		if ($clientID) $this->_clientID = $clientID;
		if ($clientSecret) $this->_clientSecret = $clientSecret;

		try
		{
			$this->init();
		}
		catch(Exception $ex)
		{
			throw new Exception($ex->getMessage());
		}
	}


	/**
	* Class initialize
	*/
	private function init()
	{
		if (empty($this->_clientID) || empty($this->_clientSecret))
		{
			throw new Exception('Client id or Client secret is empty');
		}

		try
		{
			$this->_client = new \Soundcloud\Service(
				$this->_clientID, $this->_clientSecret
			);
			$this->_client->setCurlOptions(
				array(CURLOPT_FOLLOWLOCATION => 1)
			);

			if ($this->_url)
			{
				$this->loadURL();
			}
		}
		catch(Exception $ex)
		{
			throw new Exception($ex->getMessage());
		}
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
			return $ex->getMessage();
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
	public function setClientID($val)
	{
		$this->_clientID = $val;
	}


	public function setClientSecret($val)
	{
		$this->_clientSecret = $val;
	}


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
	public function getClientID()
	{
		return $this->_clientID;
	}


	public function getClientSecret()
	{
		return $this->_clientSecret;
	}


	public function getURL()
	{
		return $this->_url;
	}


	/*
	|--------------------------------------------------------------------------
	| Track attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Iframe code to embed track
	*/
	public function embed()
	{
		return $this->_track->html;
	}


	/**
	* Track title
	*/
	public function title()
	{
		return $this->_track->title;
	}


	/**
	* Track description
	*/
	public function description()
	{
		return $this->_track->description;
	}


	/**
	* Track image
	*/
	public function img()
	{
		return $this->_track->thumbnail_url;
	}


	/**
	* Track artist
	*/
	public function artist()
	{
		return $this->_track->author_name;
	}


	/**
	* URL track artist
	*/ 
	public function artistURL()
	{
		return $this->_track->author_url;
	}
}
