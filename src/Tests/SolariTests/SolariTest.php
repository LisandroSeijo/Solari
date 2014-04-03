<?php

use Solari\Solari;
use Solari\Drivers\YouTubeDriver;
use Solari\Drivers\SoundCloudDriver;
use Solari\Drivers\BandcampDriver;

class SolariTest extends PHPUnit_Framework_TestCase
{
	public function testIsSupported()
	{
		$yesSupported = array(
			'https://soundcloud.com/cianuro-budha-1/sets/dejueves',
			'https://soundcloud.com/el-pogo/12-bonus-track-kedamos-as',
			'https://www.youtube.com/watch?v=pZ_3F93hgZw',
			'https://www.youtube.com/watch?v=DRyh2cxJCp0',
			'http://sovereigngracemusic.bandcamp.com/album/30-three-decades-of-songs-for-the-church'
		);
		$noSupported = array(
			'https://souncloud.com/cianuro-budha-1/sets/dejueves',
			'https://souncloud.com/el-pogo/12-bonus-track-kedamos-as',
			'https://www.youtbe.com/watch?v=pZ_3F93hgZw',
			'https://www.youtbe.com/watch?v=DRyh2cxJCp0',
			'http://soveredsaracemusic.bandmp.com/album/30-three-decades-of-songs-for-the-church'
		);
		
		$this->assertTrue(
			Solari::isSupported($yesSupported[0])
		);
		$this->assertTrue(
			Solari::isSupported($yesSupported[1])
		);
		$this->assertTrue(
			Solari::isSupported($yesSupported[2])
		);
		$this->assertTrue(
			Solari::isSupported($yesSupported[3])
		);
		$this->assertTrue(
			Solari::isSupported($yesSupported[4])
		);


		$this->assertFalse(
			Solari::isSupported($noSupported[0])
		);
		$this->assertFalse(
			Solari::isSupported($noSupported[1])
		);
		$this->assertFalse(
			Solari::isSupported($noSupported[2])
		);
		$this->assertFalse(
			Solari::isSupported($noSupported[3])
		);
		$this->assertFalse(
			Solari::isSupported($noSupported[4])
		);
	}


	public function testSound()
	{
		$youtubeURL    = 'https://www.youtube.com/watch?v=pZ_3F93hgZw';
		$soundcloudURL = 'https://soundcloud.com/cianuro-budha-1/sets/dejueves';
		$bandcamURL    = 'http://sovereigngracemusic.bandcamp.com/album/30-three-decades-of-songs-for-the-church';

		$this->assertInstanceOf(
			'Solari\Drivers\YouTubeDriver',
			Solari::sound($youtubeURL)
		);
		$this->assertInstanceOf(
			'Solari\Drivers\SoundCloudDriver',
			Solari::sound($soundcloudURL)
		);
		$this->assertInstanceOf(
			'Solari\Drivers\BandcampDriver',
			Solari::sound($bandcamURL)
		);
	}
}
