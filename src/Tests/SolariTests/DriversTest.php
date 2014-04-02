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
	}


	public function testEmbed()
	{
		$this->assertNotEmpty(
			$this->clientSoundcloud->embed()
		);
	}


	public function testSoundcloudTracksInfo()
	{
		$this->assertNotEmpty(
			$this->clientSoundcloud->embed()
		);
		$this->assertNotEmpty(
			$this->clientSoundcloud->title()
		);
		$this->assertNotEmpty(
			$this->clientSoundcloud->artist()
		);
	}
}
