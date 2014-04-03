<?php

namespace Solari\Drivers;

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
	* @var array
	*/
	private $_videoData = array();

	
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

		$this->_url = $url;
		$this->setVideoId($url);
		$this->loadVideo();
	}

	
	/**
	* Check if url exists
	*
	* @param string $url
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
	*/
	public function setVideoId()
	{
		$this->_videoId = $this->getVideoId($this->_url);
	}


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

		$this->_videoData = $ytJson['entry'];
	}

	/*
	|--------------------------------------------------------------------------
	| Common attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Iframe code to embed video
	*/
	public function embed($width = 420, $height = 315) 
	{
		return '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$this->_videoId.'" frameborder="0" allowfullscreen></iframe>';
	}

	
	/**
	* Video title
	*/
	public function title() 
	{
		return isset($this->_videoData['title']['$t']) ?
		$this->_videoData['title']['$t'] : '';
	}

	
	/**
	* Video description
	*/
	public function description() 
	{
		return isset($this->_videoData['media$group']['media$description']['$t']) ? 
		$this->_videoData['media$group']['media$description']['$t'] : '';
	}


	/**
	* Video image
	*/
	public function img() 
	{
		# 2 is the defaul image with high quality.
		# You can change that to:
		# 0: default image
		# 1: default image medium quality
		# 3/4/5: differents images
		return isset($this->_videoData['media$group']['media$thumbnail'][2]['url']) ?
		$this->_videoData['media$group']['media$thumbnail'][2]['url'] : '';
	}
}
