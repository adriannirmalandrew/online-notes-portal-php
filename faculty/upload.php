<?php
	//Function to generate post_id_new:
	function gen_post_id($username): string {
		//Get current system time in milliseconds:
		$token=(string)time();
		//Add the username to $token:
		$token.="_";
		$token.=$username;
		//Return token string:
		return $token;
	}
	
	//Action for uploading a post:
	//Connect to database:
	$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
	
	//Faculty ID:
	$faculty_id="";
	//Check cookie, make sure user is logged in:
	if(isset($_COOKIE["session_id"])) {
		//Check if session cookie exists in database:
		//Prepare and execute statement:
		$db_stmt=odbc_prepare($db_conn, "select faculty_id from login where session_id=?");
		odbc_execute($db_stmt, array($_COOKIE["session_id"]));
		//If session ID exists:
		if(odbc_fetch_row($db_stmt)) {
			//Fetch faculty ID:
			$faculty_id=odbc_result($db_stmt, "faculty_id");
		} else {
			header("Location: dashboard_login.php?errcode=s1");
			odbc_close($db_conn);
			exit();
		}
	} else {
		header("Location: dashboard_login.php?errcode=s1");
		odbc_close($db_conn);
		exit();
	}
	
	//Get post ID. Concatenate system time to faculty ID:
	$post_id_new=gen_post_id($faculty_id);
	//Get course code:
	$course_code_new=$_POST["post_course_code"];
	//Get title:
	$title_new=$_POST["post_title"];
	//Get media type:
	$media_type_new=$_POST["post_media_type"];
	
	//Check if any fields are empty:
	if($course_code_new=="" || $title_new=="" || $media_type_new=="") {
		odbc_close($db_conn);
		header("Location: dashboard.php?errcode=c1");
		exit();
	}
	
	//Connect to database:
	$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
	//Insert values into posts table:
	$db_stmt=odbc_prepare($db_conn, "insert into posts values(?,?,?,?,?)");
	odbc_execute($db_stmt, array($post_id_new, $faculty_id, $course_code_new, $title_new, $media_type_new));
	
	//Upload file to server, if it exists:
	if($media_type_new!="NONE") {
		//Get file name:
		$file_name=$_FILES['post_file']['name'];
		//Get file size:
		$file_size=$_FILES['post_file']['size'];
		//Get "actual" file name:
		$file_tmp_name=$_FILES['post_file']['tmp_name'];
		//Rename and transfer file to /media/$post_id_new:
		$file_dir_path=$_SERVER['DOCUMENT_ROOT']."/media/".$post_id_new;
		mkdir($file_dir_path);
		move_uploaded_file($file_tmp_name, $file_dir_path."/".$file_name);
	}
	
	//Close db_conn and redirect to dashboard.php:
	odbc_close($db_conn);
	header("Location: dashboard.php");
?>
