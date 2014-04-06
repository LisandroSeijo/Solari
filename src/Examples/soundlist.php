<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL); 
error_reporting(E_ALL);

include '../../vendor/autoload.php';
use Solari\Solari;

$urls = array(
	'https://soundcloud.com/cianuro-budha-1/sets/dejueves',
	'https://www.youtube.com/watch?v=irOtvl4HDSc',
	'https://www.youtube.com/watch?v=bmluKIs4gK4',
	'http://benprunty.bandcamp.com/album/ftl-advanced-edition-soundtrack'
);

$list = array();

try
{
	foreach($urls as $u)
	{
		$list[] = Solari::sound($u);
	}
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
	<title>Solari Test List</title>
<style>
body {
	font-family: 'lucida grande',tahoma,verdana,arial,sans-serif;
}
</style>
</head>
<body>
	<h1>Example List</h1>

	<?php 
	foreach($list as $l):
		?>
		<div style="margin-top:20px;">
			<img style="float:left; margin-right: 5px;" src="<?php echo $l->img(); ?>" width="100" height="100">
			<p>
				<strong><?php echo $l->title(); ?></strong>
				<br />
				<span style="font-size:12px;">
					Description: <?php echo substr($l->description(), 0, 200); ?>
				</span>
			</p>
			<div style="clear:both;"></div>
		</div>
		<?php
	endforeach;
	?>
</body>
</html>