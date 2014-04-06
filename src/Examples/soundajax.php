<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Example load with ajax</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<div class="conten">
	<input id="url" type="text" />
	<button id="send">Load</button>

	<div class="conten-data">
		<div class="what">
			Title:
		</div>
		<div class="that">
			<span id="title"></span>
		</div>
		<div class="what">
			Description:
		</div>
		<div class="that">
			<span id="description"></span>
		</div>
		<div class="what">
			Image:
		</div>
		<div class="that">
			<img id="img" src="" width="100" height="100" />
		</div>
		<div class="what">
			Listen:
		</div>
		<div class="that">
			<div id="embed" style="width: 500px;"></div>
		</div>
	</div>

	<div class="conten-data-error">
		Error
	</div>
</div>
<script>
$('#send').click(function() {
	$('.conten-data-error').css('display', 'none');
	$('.conten-data').css('display', 'none');
	$.ajax({
		type: 'POST',
		url: 'ajax.php',
		data: {
			url: $('#url').val()
		}
	}).done(function(data) {
		if (data.error)
		{
			$('.conten-data-error').css('display', 'block');
		}
		else
		{
			$('#title').html(data.title);
			$('#description').html(data.description);
			$('#img').attr('src', data.img);
			$('#embed').html(data.embed);
			$('.conten-data').css('display', 'block');
		}
	});
});
</script>
</body>
</html>