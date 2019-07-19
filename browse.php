<!--
	This page will be publicly available.
	It will display all the latest posts, 15 at a time.
	It will also allow for searching by Title, Course, Faculty and (possibly) by Date.
-->
<html>
	<head>
		<title>Clone University</title>
	</head>
	<body>
		<h2>Clone University Portal</h2>
		<h3>Browse Posts</h3>
		
		<h3>Search</h3>
		<form action="/search.php" method="post">
			Keyword: <input type="text" name="keyword"></input>
			<br>
			Search by:
			<input type="radio" name="search_by" value="title">Title</radio>
			<input type="radio" name="search_by" value="course_code">Course Code</radio>
			<input type="radio" name="search_by" value="faculty_name">Faculty Name</radio>
			<br>
			<input type="submit" value="Search"></input>
		</form>
		
		<h3>Latest Posts:</h3>
		<?php
			//Open ODBC connection:
			$odbc_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
			//Get latest posts:
			$posts_result=odbc_exec($odbc_conn, "select * from posts");
			//Display 15:
			$ctr=0;
			while($ctr<15 && odbc_fetch_row($posts_result)) {
				echo odbc_result($posts_result, "title");
				echo "<br>";
				$ctr++;
				//TODO
			}
		?>
	</body>
</html>
