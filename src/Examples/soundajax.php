<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Example load with ajax</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<style>
.conten-data, .conten-data-error {
	display: none;
}
</style>
</head>
<body>
	<input id="url" type="text" />
	<button id="send">Load</button>

	<div class="conten-data">
		<br />
		Title: <span id="title"></span>
		<br />
		Description: <span id="description"></span>
		<br />
		Image:
		<div>
			<img id="img" src="" width="100" height="100" />
		</div>
		<br />
		Listen:
		<div id="embed" style="width: 500px;"></div>
	</div>

	<div class="conten-data-error">
		Error
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