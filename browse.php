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
		<table>
		<?php
			//Open ODBC connection:
			$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
			//Get details for all posts:
			$get_posts=odbc_prepare($db_conn, "select * from posts");
			odbc_execute($get_posts, array());
			//Print data in table format:
			while(odbc_fetch_row($get_posts)) {
				echo "<tr>";
					//Post ID:
					echo "<td>";
						$post_id=odbc_result($get_posts, "post_id");
						echo "<a href=\"/show_post.php?post_id=".$post_id."\">";
						echo "<b>".$post_id."</b>";
						echo "</a>";
					echo "</td>";
					//Course code:
					echo "<td>";
						echo "(".odbc_result($get_posts, "course_code").")";
					echo "</td>";
					//Post title:
					echo "<td>";
						echo odbc_result($get_posts, "title");
					echo "</td>";
				echo "</tr>";
			}
		?>
		</table>
	</body>
</html>
