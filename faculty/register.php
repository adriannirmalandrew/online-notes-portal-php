<?php
	/*
	Error codes:
	r0 - Registration Successful!
	r1 - Registration Error: One or more fields empty!
	r2 - Registration Error: Faculty ID is already registered!
	r3 - Registration Error: Passwords do not match!
	r4 - Registration Error: Invalid Faculty ID!
	*/
	
	//Get the arguments:
	$faculty_id=$_POST["faculty_id"];
	$password=$_POST["password"];
	$confirm_password=$_POST["confirm_password"];
	
	//Make sure all fields are filled:
	if($faculty_id=="" || $password=="" || $confirm_password=="") {
		header("Location: dashboard_login.php?errcode=r1");
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
			header("Location: dashboard_login.php?errcode=r2");
			odbc_close($db_conn);
			exit();
		}
		//If not, check the password fields:
		else {
			if($password!=$confirm_password) {
				header("Location: dashboard_login.php?errcode=r3");
				odbc_close($db_conn);
				exit();
			}
			//Hash the password:
			$password_hash=hash("sha256", $password);
			//Finally, insert values into table:
			$register_faculty_res=odbc_prepare($db_conn, "insert into login values(?,?,?)");
			odbc_execute($register_faculty_res, array($faculty_id, $password_hash, "none"));
			//Close connection and redirect:
			odbc_close($db_conn);
			header("Location: dashboard_login.php?errcode=r0");
			exit();
		}
	}
	//If not, show error message and redirect:
	else {
		header("Location: dashboard_login.php?errcode=r4");
		odbc_close($db_conn);
		exit();
	}
?>
