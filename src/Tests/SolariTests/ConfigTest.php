<?php

use Solari\Config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
	public function testGet()
	{
		$scConfig = Config::get('soundcloud');
		$this->assertCount(2, $scConfig);
	}
}