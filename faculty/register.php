<?php
	//Get the arguments:
	$faculty_id=$_POST["faculty_id"];
	$password=$_POST["password"];
	$confirm_password=$_POST["confirm_password"];
	
	//Make sure all fields are filled:
	if($faculty_id=="" || $password=="" || $confirm_password=="") {
		echo "<h3>One or more fields empty!</h3>";
		exit();
	}
	
	//Check if faculty ID is valid:
	//Open ODBC connection:
	$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
	//Prepare and execute:
	$valid_faculty_id_res=odbc_prepare($db_conn, "select * from faculty where faculty_id=?");
	odbc_execute($valid_faculty_id_res, array($faculty_id));
	//If faculty ID is valid, check if already registered:
	if(odbc_fetch_row($valid_faculty_id_res)) {
		//Prepare and execute:
		$reg_faculty_id_res=odbc_prepare($db_conn, "select * from login where faculty_id=?");
		odbc_execute($reg_faculty_id_res, array($faculty_id));
		//If ID is already registered, show error message and redirect:
		if(odbc_fetch_row($reg_faculty_id_res)) {
			echo "<h3>Faculty ID is already registered! Redirecting...</h3>";
			sleep(5);
			header("Location: dashboard_login.php");
			exit();
		}
		//If not, check the password fields:
		else {
			//TODO
		}
	}
	//If not, show error message and redirect:
	else {
		echo "<h3>Invalid Faculty ID!</h3>";
		exit();
	}
?>
