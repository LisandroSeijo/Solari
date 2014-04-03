<?php

use Solari\Solari as Solari;
use Solari\Drivers\YouTubeDriver;
use Solari\Drivers\SoundCloudDriver;

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
	}


	public function testEmbed()
	{
		$this->assertNotEmpty(
			$this->clientSoundcloud->embed()
		);

		$this->assertNotEmpty(
			$this->clientYouTube->embed()
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

		$this->assertNotEmpty(
			$this->clientYouTube->title()
		);
		$this->assertNotEmpty(
			$this->clientYouTube->artist()
		);
	}
}
