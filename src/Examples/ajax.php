<?php

include '../../vendor/autoload.php';
use Solari\Solari;

if (!isset($_POST['url']))
{
	die();
}

$url = $_POST['url'];

if (!Solari::isSupported($url))
{
	$jsonPrint = json_encode(
		array(
			'error' => 'Bad url'
		)
	);
}
else
{
	try
	{
		$sound     = Solari::sound($url);
		$jsonPrint = $sound->toJson();
	}
	catch(Exception $ex)
	{
		$jsonPrint = json_encode(
			array(
				'error' => $ex->getMessage()
			)
		);
	}
}

header('Content-Type: application/json');
echo $jsonPrint;
