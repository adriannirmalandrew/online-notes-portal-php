<?php
	//Action for logging out a faculty member.
	//Check if user is logged in:
	//Check cookie:
	if(isset($_COOKIE["session_id"])) {
		//Check if session cookie exists in database:
		//Make connection:
		$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
		//Prepare and execute statement:
		$db_stmt=odbc_prepare($db_conn, "update login set session_id='none' where session_id=?");
		odbc_execute($db_stmt, array($_COOKIE["session_id"]));
		//Close connection and redirect:
		odbc_close($db_conn);
		header("Location: dashboard_login.php");
		exit();
	}
	else {
		header("Location: dashboard_login.php");
		odbc_close($db_conn);
		exit();
	}
?>
