<?php
	//Check if user is not logged in:
	//Check cookie:
	if(isset($_COOKIE["session_id"])) {
		//Check if session cookie exists in database:
		//Make connection:
		$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
		//Prepare and execute statement:
		$db_stmt=odbc_prepare("select faculty_id from login where session_id=?");
		$db_result=odbc_execute($db_stmt, array($_COOKIE["session_id"]));
		//If session ID doesn't exist:
		if(!odbc_fetch_row($db_result)) {
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
		<h2>Clone University Faculty Dashboard</h2>
		<!--TODO: CREATE FACULTY DASHBOARD TOOLBOX-->
		<h3>TODO</h3>
		<h3><a href="logout.php">LOGOUT</a></h3>
	</body>
</html>
