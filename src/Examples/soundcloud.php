<?php

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
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="conten">
	<h1>Examples</h1>

	<h2>Soundcloud</h2>
	<div class="what">
		URL:
	</div>
	<div class="that">
		<a href="https://soundcloud.com/cianuro-budha-1/sets/dejueves">
			https://soundcloud.com/cianuro-budha-1/sets/dejueves
		</a>
	</div>
	<div class="what">
		Title:
	</div>
	<div class="that">
		<?php echo $soundcloud->title(); ?>
	</div>
	<div class="what">
		Description: 
	</div>
	<div class="that">
		<?php echo $soundcloud->description(); ?>
	</div>
	<div class="what">
		Image:
	</div>
	<div class="that">
		<img src="<?php echo $soundcloud->img(); ?>" alt="<?php echo $soundcloud->title(); ?>" width="100" height="100" />
	</div>
	<div class="what">
		Listen:
	</div>
	<div class="that">
		<?php echo $soundcloud->embed(); ?>
	</div>
	
	<div class="cb"></div>

	<h2 class="mt50">YouTube</h2>	
	<div class="what">
		URL:
	</div>
	<div class="that">
		<a href="https://soundcloud.com/cianuro-budha-1/sets/dejueves">
			https://soundcloud.com/cianuro-budha-1/sets/dejueves
		</a>
	</div>
	<div class="what">
		Title:
	</div>
	<div class="that">
		<?php echo $youtube->title(); ?>
	</div>
	<div class="what">
		Description: 
	</div>
	<div class="that">
		<?php echo $youtube->description(); ?>
	</div>
	<div class="what">
		Image:
	</div>
	<div class="that">
		<img src="<?php echo $youtube->img(); ?>" alt="<?php echo $youtube->title(); ?>" width="100" height="100" />
	</div>
	<div class="what">
		Listen:
	</div>
	<div class="that">
		<?php echo $youtube->embed(); ?>
	</div>

	<div class="cb"></div>

	<h2 class="mt50">Bandcamp</h2>	
	<div class="what">
		URL:
	</div>
	<div class="that">
		<a href="https://soundcloud.com/cianuro-budha-1/sets/dejueves">
			https://soundcloud.com/cianuro-budha-1/sets/dejueves
		</a>
	</div>
	<div class="what">
		Title:
	</div>
	<div class="that">
		<?php echo $bandcamp->title(); ?>
	</div>
	<div class="what">
		Description: 
	</div>
	<div class="that">
		a<?php echo $bandcamp->description(); ?>
	</div>
	<div class="what">
		Image:
	</div>
	<div class="that">
		<img src="<?php echo $bandcamp->img(); ?>" alt="<?php echo $bandcamp->title(); ?>" width="100" height="100" />
	</div>
	<div class="what">
		Listen:
	</div>
	<div class="that">
		<?php echo $bandcamp->embed(); ?>
	</div>
	<div class="cb"></div>
</div>
</body>
</html>