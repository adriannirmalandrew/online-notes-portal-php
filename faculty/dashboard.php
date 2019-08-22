<?php
	//Check if user is not logged in:
	//Check cookie:
	if(isset($_COOKIE["session_id"])) {
		//Check if session cookie exists in database:
		//Make connection:
		$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
		//Prepare and execute statement:
		$db_stmt=odbc_prepare($db_conn, "select faculty_id from login where session_id=?");
		odbc_execute($db_stmt, array($_COOKIE["session_id"]));
		//If session ID doesn't exist:
		if(!odbc_fetch_row($db_stmt)) {
			header("Location: dashboard_login.php");
			odbc_close($db_conn);
			exit();
		}
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
		<div id="title">
			<h2>Clone University Faculty Dashboard</h2>
		</div>
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
		<form action="upload.php" method="post">
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
					<td>Media Type:</td>
					<td>
						<select name="post_media_type">
							<option value="NONE">NONE</option>
							<option value="IMAGE">IMAGE</option>
							<option value="VIDEO">VIDEO</option>
							<option value="TEXT">TEXT</option>
							<option value="LINK">LINK</option>
							<option value="RAW">RAW</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>File to upload:</td>
					<td><input type="file" name="post_file" enctype="multipart/form-data"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Create Post"></td>
				</tr>
			</table>
		</form>
		<!--Delete a post-->
		<h3>Delete a Post:</h3>
		<form action="delete.php" method="post">
			<table>
				<tr>
					<td>Post ID</td>
					<td><input type="text" name="post_id"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Delete Post"></td>
				</tr>
			</table>
		</form>
		<h3><a href="logout.php">LOGOUT</a></h3>
	</body>
</html>
