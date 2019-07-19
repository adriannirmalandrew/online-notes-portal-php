<!--
	This page is the dashboard.
	It will show: Links to: add/delete posts, logout
-->
<html>
	<head>
		<title>Faculty Dashboard</title>
	</head>
	<body>
		<h2>Clone University Faculty Dashboard</h2>
		<!--Check if valid session cookie exists. If not, display login/register form-->
		<?php
			//Forms for login and registration:
			$login_register_form=
			"<h3>Please login to continue:</h3>
			<form action=\"login.php\" method=\"post\">
				<table>
				<tr>
					<td>Faculty ID:</td>
					<td><input type=\"text\" name=\"faculty_id\"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type=\"text\" name=\"password\"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type=\"submit\" value=\"Login\"><td>
				</tr>
				</table>
			</form>
			<h3>Register, if not registered:</h3>
			<form action=\"register.php\" method=\"post\">
				<table>
				<tr>
					<td>Faculty ID:</td>
					<td><input type=\"text\" name=\"faculty_id\"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type=\"text\" name=\"password\"></td>
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type=\"text\" name=\"confirm_password\"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type=\"submit\" value=\"Register\"><td>
				</tr>
				</table>
			</form>
			</body>
			</html>";
			
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
					echo $login_register_form;
					exit();
				}
			}
			else {
				echo $login_register_form;
				exit();
			}
		?>
		<!--TODO: CREATE FACULTY DASHBOARD TOOLBOX-->
	</body>
</html>
