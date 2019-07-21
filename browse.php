<!--
	This page will be publicly available.
	It will display all the latest posts, 15 at a time.
	It will also allow for searching by Title, Course and Faculty name.
-->
<html>
	<head>
		<title>Clone University</title>
	</head>
	<body>
		<div id="title">
			<h2>Clone University Portal</h2>
		</div>
		
		<h3>Search Posts:</h3>
		<form action="/search.php" method="post">
			<table>
				<tr>
					<td>Keyword:</td>
					<td><input type="text" name="keyword"></td>
				</tr>
				<tr>
					<td>Search by:</td>
					<td>
						<input type="radio" name="search_by" value="title">Title
						<br>
						<input type="radio" name="search_by" value="course_code">Course Code
						<br>
						<input type="radio" name="search_by" value="faculty_name">Faculty Name
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Search"></td>
				</tr>
			</table>
		</form>
		
		<h3>Latest Posts:</h3>
		<?php
			//Open ODBC connection:
			$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
			//Get latest posts:
			$posts_result=odbc_exec($db_conn, "select * from posts");
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
