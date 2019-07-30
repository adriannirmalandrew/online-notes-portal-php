<?php
	//Action for logging in as a faculty member:
	
	/*
	Error codes:
	l1 - Login Error: One or more fields empty!
	l2 - Login Error: Invalid Faculty ID or password!
	*/
	
	//Function to generate session_id:
	function gen_session_id($username): string {
		//Get current system time in milliseconds:
		$token=(string)time();
		//Add the username to $token:
		$token.="_";
		$token.=$username;
		//Return token string:
		return $token;
	}
	
	//Get faculty_id and password:
	$faculty_id=$_POST["faculty_id"];
	$password=$_POST["password"];
	
	//Make sure fields are not blank:
	if($faculty_id=="" || $password=="") {
		header("Location: dashboard_login.php?errcode=l1");
		exit();
	}
	
	//Check if faculty ID is registered:
	//Make ODBC connection:
	$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
	//Prepare and execute statement:
	$check_faculty_id_res=odbc_prepare($db_conn, "select faculty_id from login where faculty_id=?");
	odbc_execute($check_faculty_id_res, array($faculty_id));
	//Check if faculty_id exists:
	if(!odbc_fetch_row($check_faculty_id_res)) {
		//Close and exit:
		odbc_close($db_conn);
		header("Location: dashboard_login.php?errcode=l2");
		exit();
	}
	
	//Check if password is correct:
	//Prepare and execute statement:
	$check_password_res=odbc_prepare($db_conn, "select password_hash from login where faculty_id=?");
	odbc_execute($check_password_res, array($faculty_id));
	//Retrieve hashed password from login:
	if(odbc_fetch_row($check_password_res)) {
		$password_hash_db=odbc_result($check_password_res,"password_hash");
	} else {
		//Close connection and exit:
		odbc_close($db_conn);
		header("Location: dashboard_login.php?errcode=l2");
		exit();
	}
	//Hash and check the password entered by user:
	$password_hash_user=hash("sha256", $password);
	if($password_hash_user!=$password_hash_db) {
		//Close connection and exit:
		odbc_close($db_conn);
		header("Location: dashboard_login.php?errcode=l2");
		exit();
	}
		
	//Set session_id:
	//Prepare and execute statement:
	$session_id=gen_session_id($faculty_id);
	$set_sess_id_res=odbc_prepare($db_conn, "update login set session_id=? where faculty_id=?");
	odbc_execute($set_sess_id_res, array($session_id, $faculty_id));
	//Set cookie:
	setcookie("session_id", $session_id);
	
	//Close connection:
	odbc_close($db_conn);
	//Redirect to dashboard.php:
	header("Location: dashboard.php");
?>
