<?php

use Solari\Solari;
use Solari\Drivers\YouTubeDriver;
use Solari\Drivers\SoundCloudDriver;
use Solari\Drivers\BandcampDriver;

class DriversTest extends PHPUnit_Framework_TestCase
{
	public function __construct()
	{
		$this->clientSoundcloud = Solari::sound(
			'https://soundcloud.com/cianuro-budha-1/sets/dejueves'
		);
		$this->clientYouTube = Solari::sound(
			'https://www.youtube.com/watch?v=pZ_3F93hgZw'
		);
		$this->clientBandcamp = Solari::sound(
			'http://sovereigngracemusic.bandcamp.com/album/30-three-decades-of-songs-for-the-church'
		);

		parent::__construct();
	}


	public function testCheckURL()
	{
		$this->assertTrue(
			$this->clientSoundcloud->checkURL()
		);

		$this->assertFalse(
			$this->clientSoundcloud->checkURL('https://soundcloud.com/false/url/to/check')
		);

		$this->assertTrue(
			$this->clientYouTube->checkURL('https://www.youtube.com/watch?v=pZ_3F93hgZw')
		);

		$this->assertFalse(
			$this->clientYouTube->checkURL('https://www.youtube.com/watch?v=url_no_valida')
		);

		$this->assertTrue(
			$this->clientBandcamp->checkURL(
				'http://sovereigngracemusic.bandcamp.com/album/30-three-decades-of-songs-for-the-church'
			)
		);

		$this->assertFalse(
			$this->clientBandcamp->checkURL(
				'http://sovereigngracemusic.bandcamp.com/album/jnknjk-mklmkl-or-the-church'
			)
		);
	}


	public function testEmbed()
	{
		$this->assertNotEmpty(
			$this->clientSoundcloud->embed()
		);

		$this->assertNotEmpty(
			$this->clientYouTube->embed()
		);

		$this->assertNotEmpty(
			$this->clientBandcamp->embed()
		);
	}


	public function testSoundcloudTracksInfo()
	{
		$this->assertNotEmpty(
			$this->clientSoundcloud->title()
		);
		$this->assertNotEmpty(
			$this->clientSoundcloud->artist()
		);
	}


	public function testMoveImage()
	{
		if (!is_writable($path = dirname(__FILE__)))
		{
			return;
		}

		$path .= '/testimg';

		if (!file_exists($path))
		{
			if (!mkdir($path, 0777))
			{
				return;
			}
		}

		$this->assertTrue(
			$this->clientYouTube->saveImage(
				$path,
				'test',
				true
			)
		);

		unlink(
			$path.
			'/test.'.
			$this->clientYouTube->getExtensionImagen()
		);

		rmdir($path);
	}
}
