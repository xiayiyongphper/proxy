<?php
if (isset($_GET['ajax'])) {
	session_start();
	$file = __DIR__.'/../../swoole.log';
	$handle = fopen($file, 'r');
	//echo __DIR__.'../../swoole.log'.'<br/>';
	if (isset($_SESSION['offset']) && $_SESSION['offset']) {
		$data = stream_get_contents($handle, -1, $_SESSION['offset']);
		echo nl2br($data);
	}
	fseek($handle, 0, SEEK_END);
	$_SESSION['offset'] = ftell($handle);
	exit();
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://creativecouple.github.com/jquery-timing/jquery-timing.min.js"></script>
	<script>
		var last = '';
		$(function() {
			$.repeat(1000, function() {
				$.get('tail.php?ajax', function(data) {
					if(data){
						$('#tail').append('<li>'+data+'</li>');
						$('#tail').scrollTop(99999);
						last = data;
					}
				});
			});
		});
	</script>
	<style type="text/css">
		#tail{}
		.shell-wrap {
			width: 1000px;
			margin: 100px auto 0 auto;
			box-shadow: 0 0 30px rgba(0,0,0,0.4);

			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
		}

		.shell-top-bar {
			text-align: center;
			color: #525252;
			padding: 5px 0;
			margin: 0;
			text-shadow: 1px 1px 0 rgba(255,255,255,0.5);
			font-size: 0.85em;
			border: 1px solid #CCCCCC;
			border-bottom: none;

			-webkit-border-top-left-radius: 3px;
			-webkit-border-top-right-radius: 3px;
			-moz-border-radius-topleft: 3px;
			-moz-border-radius-topright: 3px;
			border-top-left-radius: 3px;
			border-top-right-radius: 3px;

			background: #f7f7f7; /* Old browsers */
			background: -moz-linear-gradient(top,  #f7f7f7 0%, #B8B8B8 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f7f7f7), color-stop(100%,#B8B8B8)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  #f7f7f7 0%,#B8B8B8 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  #f7f7f7 0%,#B8B8B8 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  #f7f7f7 0%,#B8B8B8 100%); /* IE10+ */
			background: linear-gradient(to bottom,  #f7f7f7 0%,#B8B8B8 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#B8B8B8',GradientType=0 ); /* IE6-9 */
		}

		.shell-body {
			margin: 0;
			padding: 5px;
			list-style: none;
			background: #141414;
			color: #45D40C;
			font: 0.8em 'Andale Mono', Consolas, 'Courier New';
			line-height: 1.6em;

			-webkit-border-bottom-right-radius: 3px;
			-webkit-border-bottom-left-radius: 3px;
			-moz-border-radius-bottomright: 3px;
			-moz-border-radius-bottomleft: 3px;
			border-bottom-right-radius: 3px;
			border-bottom-left-radius: 3px;

			height: 500px;
			overflow: scroll;

		}

		/*
		.shell-body li:before {
			content: '$';
			position: absolute;
			left: 0;
			top: 0;
		}
		*/

		.shell-body li {
			word-wrap: break-word;
			position: relative;
			padding: 0 0 0 15px;
		}
	</style>
</head>
<body>

<div class="shell-wrap">
	<p class="shell-top-bar"><?php echo __DIR__.'/../../swoole.log';?></p>
	<ul class="shell-body" id="tail">
		<li><?php echo 'tail -f '.__DIR__.'/../../swoole.log';?></li>
	</ul>
</div>

</body>
</html>