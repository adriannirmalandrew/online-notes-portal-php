<?php
	//Action for deleting a post
	//Connect to database:
	$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
	
	//Check is user is logged in:
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
	
	//Get post ID:
	$post_id=$_POST["post_id"];
	if(!isset($post_id) || $post_id=="") {
		odbc_close($db_conn);
		header("Location: dashboard.php?errcode=d1");
		exit();
	}
	//Get post details from posts table:
	$get_post_details=odbc_prepare($db_conn, "select post_id, faculty_id, media_type from posts where post_id=?");
	odbc_execute($get_post_details, array($post_id));
	//If not found, close DB connection and redirect;
	if(!odbc_fetch_row($get_post_details)) {
		odbc_close($db_conn);
		header("Location: dashboard.php?errcode=d2");
		exit();
	}
	
	//Check if post is created by logged-in user.
	//If not, close connection and redirect:
	if(odbc_result($get_post_details, "faculty_id")!=$faculty_id) {
		odbc_close($db_conn);
		header("Location: dashboard.php?errcode=d3");
		exit();
	}
	
	//Get post media type:
	$media_type=odbc_result($get_post_details, "media_type");
	//If no errors found, delete details from the DB:
	$delete_post=odbc_prepare($db_conn, "delete from posts where post_id=?");
	odbc_execute($delete_post, array($post_id));
	
	//If a file was uploaded with the post, delete it:
	if($media_type!="NONE") {
		//Get folder path:
		$file_dir_path=$_SERVER['DOCUMENT_ROOT']."/media/".$post_id;
		//Get full file name:
		$media_file_name=scandir($file_dir_path)[2];
		//Delete file:
		unlink($file_dir_path."/".$media_file_name);
		//Delete folder:
		rmdir($file_dir_path);
	}
	
	//Close and redirect:
	odbc_close($db_conn);
	header("Location: dashboard.php");
?>
