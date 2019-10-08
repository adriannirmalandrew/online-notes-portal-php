<?php
	//This is to check if search arguments are not empty:
	$keyword=$_GET["keyword"];
	$search_by=$_GET["search_by"];
?>
<!--This page is used to show search results.-->
<html>
	<head>
		<title>Search Results</title>
	</head>
	<body>
		<div id="title">
			<h2>Clone University Portal</h2>
		</div>
		<div id="search-form">
			<h3>Search:</h3>
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
		<div id="search-results">
			<h3>Results:</h3>
			<?php
				//TODO: Show search results
			?>
		</div>
	</body>
</html>
