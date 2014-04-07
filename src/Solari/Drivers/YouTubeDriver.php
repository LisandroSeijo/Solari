<?php

namespace Solari\Drivers;

use \stdClass;

class YouTubeDriver extends SolariDriver
{
	/**
	* Video URL
	*
	* @var string
	*/
	private $_url;

	/**
	* Video ID
	*
	* @var string
	*/
	private $_videoId;

	/**
	* Video data
	*
	* @var stdClass
	*/
	private $_data;

	
	/**
	* Construct
	* 
	* @param string $clientID
	*/
	public function __construct($url)
	{
		if (!$this->checkURL($url))
		{
			throw new Exception("Bad url");
		}

		$this->_data = new stdClass;
		$this->_url = $url;
		
		$this->setVideoId()->loadVideo();
	}

	
	/**
	* Check if url exists
	*
	* @param string $url
	*
	* @return bool
	*/
	public function checkURL($url)
	{
		$ret = false;

		$headers = get_headers(
			'http://gdata.youtube.com/feeds/api/videos/'.
			$this->getVideoId($url)
		);

		if (strpos($headers[0], '200')) 
		{
			$ret = true;
		}

		return $ret;
	}

	
	/**
	* Return video id
	*
	* @return int
	*/
	public function getVideoId($url)
	{
		parse_str(
			parse_url($url, PHP_URL_QUERY), $get
		);
		return isset($get['v']) ? $get['v'] : '';
	}

	
	/**
	* Set Video id
	*
	* @return this
	*/
	public function setVideoId()
	{
		$this->_videoId = $this->getVideoId($this->_url);

		return $this;
	}


	/**
	* Load video's data
	*
	* @return void
	*/
	public function loadVideo()
	{
		$ytJson = json_decode(
			file_get_contents(
				# Api URL
				'https://gdata.youtube.com/feeds/api/videos/'.
				
				# Video id
				$this->_videoId.
				
				# Options:
				# v: API version, we use 2
				# alt: format of the feed to be returned. If you change that
				# must change conmmons attributes methods
				# 
				# More information: 
				# https://developers.google.com/youtube/2.0/developers_guide_protocol_api_query_parameters#Standard_parameters
				'?v=2&alt=json'
			),
			true
		);

		$data = $ytJson['entry'];
		$this->_data->title = $data['title']['$t'];
		$this->_data->description = $data['media$group']['media$description']['$t'];

		# 2 is the defaul image with high quality.
		# You can change that to:
		# 0: default image
		# 1: default image medium quality
		# 3/4/5: differents images
		$this->_data->img = $data['media$group']['media$thumbnail'][2]['url'];

		return $this;
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
	private function getAttribute($attribute)
	{
		return isset($this->_data->{$attribute}) ? $this->_data->{$attribute} : '';
	}

	/*
	|--------------------------------------------------------------------------
	| Common attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Iframe code to embed video
	*
	* @return string
	*/
	public function embed($width = 420, $height = 315) 
	{
		return '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$this->_videoId.'" frameborder="0" allowfullscreen></iframe>';
	}

	
	/**
	* Video title
	*
	* @return string
	*/
	public function title() 
	{
		return $this->getAttribute('title');
	}

	
	/**
	* Video description
	*
	* @return string
	*/
	public function description() 
	{
		return $this->getAttribute('description');
	}


	/**
	* Video image
	*
	* @return string
	*/
	public function img() 
	{
		return $this->getAttribute('img');
	}
}
