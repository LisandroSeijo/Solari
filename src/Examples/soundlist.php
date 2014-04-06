<?php

include '../../vendor/autoload.php';
use Solari\Solari;

# List of songs
$urls = array(
	'https://soundcloud.com/cianuro-budha-1/sets/dejueves',
	'https://www.youtube.com/watch?v=irOtvl4HDSc',
	'https://www.youtube.com/watch?v=bmluKIs4gK4',
	'http://benprunty.bandcamp.com/album/ftl-advanced-edition-soundtrack'
);

$list = array();

try
{
	# Load sounds
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
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="conten">
	<h1>Example List</h1>

	<?php 
	foreach($list as $l):
		?>
		<div class="song">
			<img src="<?php echo $l->img(); ?>" width="100" height="100">
			<p>
				<strong><?php echo $l->title(); ?></strong>
				<br />
				<span class="description">
					Description: <?php echo substr($l->description(), 0, 300); ?>
				</span>
			</p>
			<div class="cb"></div>
		</div>
		<?php
	endforeach;
	?>
</div>
</body>
</html>