<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL); 
error_reporting(E_ALL);

include '../../vendor/autoload.php';
use Solari\Solari;

try
{
	$soundcloud = Solari::sound(
		'https://soundcloud.com/cianuro-budha-1/sets/dejueves'
	);
	$youtube    = Solari::sound(
		'https://www.youtube.com/watch?v=irOtvl4HDSc'
	);
	$bandcamp   = Solari::sound(
		'http://benprunty.bandcamp.com/album/ftl-advanced-edition-soundtrack'
	);
}
catch(Exception $ex)
{
	die($ex->getMessage());
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Solari Examples</title>
<style>
body {
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
</style>
</head>
<body>
	<h1>Examples</h1>

	<h2>Soundcloud</h2>	
	URL: 
	<br />
	Title: <?php echo $soundcloud->title(); ?>
	<br />
	Description: <?php echo $soundcloud->description(); ?>
	<br />
	Image:
	<div>
		<img src="<?php echo $soundcloud->img(); ?>" alt="<?php echo $soundcloud->title(); ?>" width="100" height="100" />
	</div>
	<br />
	Listen:
	<div style="width: 500px;">
		<?php echo $soundcloud->embed(); ?>
	</div>


	<h2>YouTube</h2>	
	URL: 
	<br />
	Title: <?php echo $youtube->title(); ?>
	<br />
	Description: <?php echo $youtube->description(); ?>
	<br />
	Image:
	<div>
		<img src="<?php echo $youtube->img(); ?>" alt="<?php echo $youtube->title(); ?>" width="100" height="100" />
	</div>
	<br />
	Listen:
	<div style="width: 500px;">
		<?php echo $youtube->embed(); ?>
	</div>


	<h2>Bandcamp</h2>	
	URL:
	<br />
	Title: <?php echo $bandcamp->title(); ?>
	<br />
	Description: <?php echo $bandcamp->description(); ?>
	<br />
	Image:
	<div>
		<img src="<?php echo $bandcamp->img(); ?>" alt="<?php echo $bandcamp->title(); ?>" width="100" height="100" />
	</div>
	<br />
	Listen:
	<div style="width: 500px;">
		<?php echo $bandcamp->embed(); ?>
	</div>
</body>
</html>