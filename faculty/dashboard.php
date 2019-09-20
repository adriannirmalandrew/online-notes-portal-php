<?php
	//Check if user is not logged in:
	//Check cookie:
	if(isset($_COOKIE["session_id"])) {
		//Check if session cookie exists in database:
		//Make connection:
		$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
		//Prepare and execute statement:
		$db_stmt=odbc_prepare($db_conn, "select l.faculty_id fac_id, f.name fac_name, f.school fac_school from login l join faculty f on f.faculty_id = l.faculty_id where l.session_id=?");
		odbc_execute($db_stmt, array($_COOKIE["session_id"]));
		//If session ID doesn't exist:
		if(!odbc_fetch_row($db_stmt)) {
			header("Location: dashboard_login.php");
			odbc_close($db_conn);
			exit();
		}
		//Get user details from db_stmt:
		$faculty_id=odbc_result($db_stmt, "fac_id");
		$faculty_name=odbc_result($db_stmt, "fac_name");
		$school_id=odbc_result($db_stmt, "fac_school");
	}
	else {
		header("Location: dashboard_login.php");
		odbc_close($db_conn);
		exit();
	}
?>

<!--This page is the dashboard.-->
<html>
	<head>
		<title>Faculty Dashboard</title>
	</head>
	<body>
		<!--Print college name-->
		<div id="title">
			<h2>Clone University Faculty Dashboard</h2>
		</div>
		<!--Print faculty name and school ID-->
		<div id="faculty_name">
			<h2>
				<?php
					echo "Welcome, ".$faculty_name;
					echo " (School ID: ".$school_id.")";
					echo "\n";
				?>
			</h2>
		</div>
		<!--Print error message, if any-->
		<div id="error">
		<?php
			$errcode=$_GET["errcode"];
			switch($errcode) {
				//Post creation errors:
				case "c1":
					echo "Creation error: One or more fields are empty!";
					break;
				//Deletion errors:
				case "d1":
					echo "Deletion error: One or more fields are empty!";
					break;
				case "d2":
					echo "Deletion error: Invalid post ID!";
					break;
				case "d3":
					echo "Deletion error: You did not create this post!";
					break;
			}
		?>
		</div>
		<!--Create a new post-->
		<h3>Create New Post:</h3>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Course Code:</td>
					<td><input type="text" name="post_course_code"></td>
				</tr>
				<tr>
					<td>Post Title:</td>
					<td><input type="text" name="post_title"></td>
				</tr>
				<tr>
					<td>Attachment Type:</td>
					<td>
						<select name="post_media_type">
							<option value="NONE">None</option>
							<option value="IMAGE">Image</option>
							<option value="VIDEO">Video</option>
							<option value="TEXT">Plain Text</option>
							<option value="LINK">Hyperlink</option>
							<option value="RAW">Other File</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>File to upload:</td>
					<td><input type="file" name="post_file"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Create Post"></td>
				</tr>
			</table>
		</form>
<?php
	//Get posts from database:
	$get_posts=odbc_prepare($db_conn, "select * from posts where faculty_id=?");
	odbc_execute($get_posts, array($faculty_id));
	//Try to fetch first row:
	$posts_exist=odbc_fetch_row($get_posts);
	//Display Post list and Delete form only if posts exist:
	if($posts_exist) {
		echo "
		<!--Display post list-->
		<h3>Your Posts:</h3>
		<div id=\"your_posts\" style=\"height:100px;overflow:scroll\">
		<table>";
		do {
			echo "\r\t\t\t";
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
				$course_code=odbc_result($get_posts, "course_code");
				echo "(".$course_code.")";
			echo "</td>";
			//Post title:
			echo "<td>";
				echo odbc_result($get_posts, "title");
			echo "</td></tr>";
		} while(odbc_fetch_row($get_posts));
		echo "
		</table>
		</div>\r";
		//Display the "Delete Post" form:
		echo "
		<!--Delete a post-->
		<h3>Delete a Post:</h3>
		<form action=\"delete.php\" method=\"post\">
			<table>
				<tr>
					<td>Post ID:</td>
					<td><input type=\"text\" name=\"post_id\"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type=\"submit\" value=\"Delete Post\"></td>
				</tr>
			</table>
		</form>
		";
	} else {
		echo "<h3>No posts found.</h3>";
	}
	echo "\n";
?>
		<!--Logout form-->
		<h3>Logout:</h3>
		<form action="logout.php">
			<input type="submit" value="Logout">
		</form>
	</body>
</html>
