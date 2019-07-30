<?php
	//Check if user is already logged in:
	//Check cookie:
	if(isset($_COOKIE["session_id"])) {
		//Check if session cookie exists in database:
		//Make connection:
		$db_conn=odbc_connect("MariaDBLocal", "root", "kingspammernerd");
		//Prepare and execute statement:
		$db_stmt=odbc_prepare("select faculty_id from login where session_id=?");
		$db_result=odbc_execute($db_stmt, array($_COOKIE["session_id"]));
		//If session ID exists, redirect to dashboard.php:
		if(odbc_fetch_row($db_result)) {
			header("Location: dashboard.php");
			odbc_close($db_conn);
			exit();
		}
		odbc_close($db_conn);
	}
?>

<!--This is the page to register/login for the faculty members' dashboard-->
<html>
	<head>
		<title>Faculty Dashboard Login</title>
	</head>
	<body>
		<div id="title">
			<h2>Clone University Dashboard</h2>
		</div>
		
		<?php
			//Check if an error message was given during login/registration:
			//Error code from URL:
			$errcode=$_GET["errcode"];
			//Print corresponding error:
			echo "<div id=\"login_error\">";
			switch($errcode) {
				//Registration error codes:
				case "r0":
					echo "Registration Successful!";
					break;
				case "r1":
					echo "Registration Error: One or more fields empty!";
					break;
				case "r2":
					echo "Registration Error: Faculty ID is already registered!";
					break;
				case "r3":
					echo "Registration Error: Passwords do not match!";
					break;
				case "r4":
					echo "Registration Error: Invalid Faculty ID!";
					break;
				//Login error codes:
				case "l1":
					echo "Login error: One or more fields empty!";
					break;
				case "l2":
					echo "Login error: Invalid Faculty ID or password!";
					break;
			}
			echo "</div>";
		?>
		
		<h3>Please login to continue:</h3>
		<form action="login.php" method="post">
			<table>
			<tr>
				<td>Faculty ID:</td>
				<td><input type="text" name="faculty_id"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Login"><td>
			</tr>
			</table>
		</form>
		<h3>Register, if not registered:</h3>
		<form action="register.php" method="post">
			<table>
			<tr>
				<td>Faculty ID:</td>
				<td><input type="text" name="faculty_id"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td>Confirm Password:</td>
				<td><input type="password" name="confirm_password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Register"><td>
			</tr>
			</table>
		</form>
	</body>
</html>
