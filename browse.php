<!--
	This page will be publicly available.
	It will display all the latest posts, 15 at a time.
	It will also allow for searching by Title, Course and Faculty name.
-->
<html>
	<head>
		<link rel="stylesheet" href="/css/browse.css"></link>
		<title>Clone University</title>
	</head>
	<body>
		<div id="title">
			<a href="/"><h2>Clone University Portal</h2></a>
		</div>
		<div id="search-form">
			<h3>Search Posts:</h3>
			<form action="/search.php" method="get">
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
		</div>
		<div id="latest-posts">
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
					//Get faculty name:
					$get_faculty_name=odbc_prepare($db_conn, "select name from faculty where faculty_id=?");
					odbc_execute($get_faculty_name, array(odbc_result($get_posts, "faculty_id")));
					odbc_fetch_row($get_faculty_name);
					echo "<tr>";
						//Faculty name:
						echo "<td>";
							echo "By ";
							echo odbc_result($get_faculty_name, "name");
							echo ": ";
						echo "</td>";
						//Course code:
						echo "<td>";
							echo "(".odbc_result($get_posts, "course_code").")";
						echo "</td>";
						//Post title:
						echo "<td>";
							$post_id=odbc_result($get_posts, "post_id");
							echo "<a href=\"/show_post.php?post_id=".$post_id."\">";
							echo "<b>".$post_title."</b>";
							echo odbc_result($get_posts, "title");
							echo "</a>";
						echo "</td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
	</body>
</html>
