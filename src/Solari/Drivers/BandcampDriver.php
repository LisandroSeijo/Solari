<?php

namespace Solari\Drivers;

use \Exception;
use \DomDocument;
use \DOMXPath;
use \stdClass;

libxml_use_internal_errors(true);

class BandcampDriver extends SolariDriver
{
	/**
	* Track URL
	*
	* @var string
	*/
	private $_url;

	/**
	* Album ID
	*
	* @var string
	*/
	private $_albumId;

	/**
	* Album data
	*
	* @var stdClass
	*/
	private $_data;

	/**
	* DOM of the web
	*/
	private $_dom;


	/**
	* Construct
	* 
	* @param string $url
	*/
	public function __construct($url)
	{
		if (!$this->checkURL($url))
		{
			throw new Exception("Bad url");
		}

		$this->_data = new stdClass;
		$this->_url = $url;
		
		$this->loadDom()->setAlbumId()->loadAlbum();
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

		$headers = get_headers($url);

		if (strpos($headers[0], '200')) 
		{
			$ret = true;
		}

		return $ret;
	}


	/**
	* Load DOM of the web
	*
	* @param string $url
	*
	* @return void
	*/
	private function loadDom()
	{
		$this->_dom = new DomDocument();
		
		$this->_dom->loadHTML(
			file_get_contents($this->_url)
		);

		return $this;
	}


	/**
	* Return album id
	*
	* @param string $url
	*
	* @return int
	*/
	public function getAlbumId($url)
	{
		$content = '';

		$xpath = new DOMXPath($this->_dom);
		$query = '//*/meta[starts-with(@property, \'og:video\')]';
		$metas = $xpath->query($query);
		
		foreach ($metas as $m) 
		{
			if ($m->getAttribute('property') == 'og:video')
			{
				$content = $m->getAttribute('content');
			}
		}

		parse_str(
			parse_url($content, PHP_URL_QUERY), $get
		);

		if (!isset($get['album']) || empty($get['album']))
		{
			throw new Exception('Bad url');
		}

		return $get['album'];
	}


	/**
	* Set Album id
	*
	* @return void
	*/
	public function setAlbumId()
	{
		$this->_albumId = $this->getAlbumId($this->_url);

		return $this;
	}


	/**
	* Set album information
	*
	* @return void
	*/
	private function loadAlbum()
	{
		// TODO: search more information
		$xpath = new DOMXPath($this->_dom);
		$query = '//*/meta[starts-with(@property, \'og:\')]';
		$metas = $xpath->query($query);
		
		foreach ($metas as $m) 
		{
			if ($m->getAttribute('property') == 'og:title')
			{
				$this->_data->title = $m->getAttribute('content');
			}

			if ($m->getAttribute('property') == 'og:image')
			{
				$this->_data->img = $m->getAttribute('content');
			}
		}

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
	public function embed() 
	{
		if (empty($this->_albumId))
		{
			return '';
		}
		
		return '
		<iframe style="border: 0; width: 100%; height: 470px;" src="http://bandcamp.com/EmbeddedPlayer/album='.$this->_albumId.'/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/transparent=true/" seamless>
			<a href="http://sovereigngracemusic.bandcamp.com/album/30-three-decades-of-songs-for-the-church">'.$this->getAttribute('title').'</a>
		</iframe>';
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
