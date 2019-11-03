<?php
	//This is to check if search arguments are not empty:
	$keyword=$_GET["keyword"];
	$search_by=$_GET["search_by"];
?>
<!--This page is used to show search results.-->
<html>
	<head>
		<link rel="stylesheet" href="/css/search.css"></link>
		<title>Search Results</title>
	</head>
	<body>
		<div id="title">
			<a href="/"><h2>Clone University Portal</h2></a>
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
			<?php
				//If form is not filled:
				if(!isset($keyword) || !isset($search_by)) {
					echo "<h3>Search term empty!</h3>";
					echo "</div>";
					echo "</body>";
					echo "</html>";
					exit();
				}
				echo "<h3 id=\"search_title\">Results for ";
				echo "\"".$keyword."\"";
				echo ":</h3>";
				echo "<table>";
				//Connect and get data:
				$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
				$get_by_keyword=null;
				if($search_by=="title") {
					//Get posts by title:
					$get_by_keyword=odbc_prepare($db_conn, "select * from posts p join faculty f on p.faculty_id=f.faculty_id where title like '%".$keyword."%'");
				}
				else if($search_by=="course_code") {
					//Get posts by course code:
					$get_by_keyword=odbc_prepare($db_conn, "select * from posts p join faculty f on p.faculty_id=f.faculty_id where course_code like '%".$keyword."%'");
				}
				else if($search_by=="faculty_name") {
					//Get posts by faculty name:
					$get_by_keyword=odbc_prepare($db_conn, "select * from posts p join faculty f on p.faculty_id=f.faculty_id where f.name like '%".$keyword."%'");
				}
				else {
					echo "Invalid search parameter!";
				}
				//Print search results:
				odbc_execute($get_by_keyword, array());
				$result_count=0;
				while(odbc_fetch_row($get_by_keyword)) {
					echo "<tr>";
						//Faculty name:
						echo "<td>";
							echo "By ";
							echo odbc_result($get_by_keyword, "name");
							echo ": ";
						echo "</td>";
						//Course code:
						echo "<td>";
							echo "(".odbc_result($get_by_keyword, "course_code").")";
						echo "</td>";
						//Post title:
						echo "<td>";
							$post_id=odbc_result($get_by_keyword, "post_id");
							echo "<a href=\"/show_post.php?post_id=".$post_id."\">";
							echo "<b>".$post_title."</b>";
							echo odbc_result($get_by_keyword, "title");
							echo "</a>";
						echo "</td>";
					echo "</tr>";
					++$result_count;
				}
				echo "</table>";
				odbc_close($db_conn);
			?>
			<!--Add the number of search results to search_title-->
			<script>
				var result_count=<?php echo $result_count; ?>;
				if(result_count>0) {
					var search_title=document.getElementById("search_title");
					search_title.innerHTML=result_count + ' ' + search_title.innerHTML;
				}
			</script>
		</div>
	</body>
</html>
