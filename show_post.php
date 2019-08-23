<!--This script is used to display a single post.-->
<html>
	<head>
		<title>Clone University</title>
	</head>
	<body>
		<div id="title">
			<h2>Clone University Portal</h2>
			<h3>
				Showing Post:
				<?php
					$post_id=$_GET["post_id"];
					echo $post_id;
				?>
			</h3>
		</div>
		<!--TODO: DISPLAYING POST CONTENT-->
	</body>
</html>
