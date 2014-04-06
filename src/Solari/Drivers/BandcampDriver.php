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
	private $_albumData;

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

		$this->_albumData = new stdClass;
		$this->_url = $url;
		$this->loadDom($url);
		$this->setAlbumId($url);
		$this->loadAlbum($url);
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
	*/
	private function loadDom($url)
	{
		$this->_dom = new DomDocument();
		
		$this->_dom->loadHTML(
			file_get_contents($url)
		);
	}


	/**
	* Return album id
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
	*/
	public function setAlbumId()
	{
		$this->_albumId = $this->getAlbumId($this->_url);
	}


	/**
	* Set album information
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
				$this->_albumData->title = $m->getAttribute('content');
			}

			if ($m->getAttribute('property') == 'og:image')
			{
				$this->_albumData->img = $m->getAttribute('content');
			}
		}
	}


	/**
	* Return url
	*/
	public function getURL()
	{
		return $this->_url;
	}


	private function getAlbumAttribute($attribute)
	{
		return isset($this->_albumData->{$attribute}) ? $this->_albumData->{$attribute} : '';
	}


	/*
	|--------------------------------------------------------------------------
	| Common attributes
	|--------------------------------------------------------------------------
	*/
	/**
	* Iframe code to embed video
	*/
	public function embed($width = 350, $height = 470) 
	{
		return '
		<iframe style="border: 0; width: '.$width.'px; height: '.$height.'px;" src="http://bandcamp.com/EmbeddedPlayer/album='.$this->_albumId.'/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/transparent=true/" seamless>
			<a href="http://sovereigngracemusic.bandcamp.com/album/30-three-decades-of-songs-for-the-church">'.$this->getAlbumAttribute('title').'</a>
		</iframe>';
	}

	
	/**
	* Video title
	*/
	public function title() 
	{
		return $this->getAlbumAttribute('title');
	}

	
	/**
	* Video description
	*/
	public function description() 
	{
		return $this->getAlbumAttribute('description');
	}


	/**
	* Video image
	*/
	public function img() 
	{
		return $this->getAlbumAttribute('img');
	}
}
