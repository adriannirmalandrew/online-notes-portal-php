<?php
	//Get the post_id from URL:
	$post_id=$_GET["post_id"];
	//Check if $post_id is valid:
	$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
	$check_post=odbc_prepare($db_conn, "select * from posts where post_id=?");
	odbc_execute($check_post, array($post_id));
	//If $post_id is invalid, redirect back to browse.php:
	$post_id_valid=odbc_fetch_row($check_post);
	if(!$post_id_valid) {
		odbc_close($db_conn);
		header("Location: browse.php");
		exit();
	}
	//Else, store post attributes:
	$faculty_id=odbc_result($check_post, "faculty_id");
	$course_code=odbc_result($check_post, "course_code");
	$title=odbc_result($check_post, "title");
	$media_type=odbc_result($check_post, "media_type");
	//Get faculty name using $faculty_id:
	$get_faculty_name=odbc_prepare($db_conn, "select * from faculty where faculty_id=?");
	odbc_execute($get_faculty_name, array($faculty_id));
	$faculty_name=odbc_result($get_faculty_name, "name");
	$faculty_school=odbc_result($get_faculty_name, "school");
	//Close connection:
	odbc_close($db_conn);
?>
<!--This script is used to display a single post-->
<html>
	<head>
		<title>Clone University</title>
	</head>
	<body>
		<div id="title">
			<h2>Clone University Portal</h2>
			<h3>
				Showing resource for course: 
				<?php echo $course_code."\n"; ?>
			</h3>
			<h3>
				Uploaded by:
				<?php
					echo $faculty_name.", ";
					echo $faculty_school;
					echo " (";
					echo $faculty_id;
					echo ")\n";
				?>
			</h3>
			<h2>
				<?php echo $title."\n"; ?>
			</h2>
		</div>
		<?php
			if($media_type!="NONE") {
				//Get name of uploaded file:
				$media_file_name=scandir($_SERVER['DOCUMENT_ROOT']."/media/".$post_id)[2];
				//Display media content, if any:
				echo "<div id=\"media-content\">\n\t\t\t";
				if($media_type=="IMAGE") {
					//Display image as-is:
					echo "<img src=\"/media/".$post_id."/".$media_file_name."\" width=100%>";
					echo "\r";
				} else if($media_type=="VIDEO") {
					//Display video in frame:
					//DOESN'T WORK. FIX LATER
					echo "<embed src=\"/media/".$post_id."\" width=100%>";
					echo "\r";
				} else if($media_type=="TEXT") {
					//Open text file:
					$text_file=fopen($_SERVER['DOCUMENT_ROOT']."/media/".$post_id."/".$media_file_name, "r");
					//Read contents, line by line:
					while(!feof($text_file)) {
						$temp_line=fgets($text_file);
						echo $temp_line;
						echo "<br>";
					}
					//Close file:
					fclose($text_file);
				} else if($media_type=="RAW") {
					//Provide download link:
					echo "<h3>";
					echo "Attached file: ";
					echo "<a href=\"/media/".$post_id."/".$media_file_name."\">";
					echo "Download File";
					echo "</a>";
					echo "</h3>";
				}
				echo "\t\t</div>\n";
			} else echo "<h3>(No Attached Media)<h3>";
		?>
	</body>
</html>
