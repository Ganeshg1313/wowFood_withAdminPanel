<?php include ('../config/constants.php'); ?>
<html>

<head>
	<title>Login Food Order System</title>

	<link rel="stylesheet" type="text/css" href="../css/log.css">
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>

<body>
	<div class="default-credentials">
		<h3>Enter the below default username and password</h3>
		<p><b>Username: </b>admin</p>
		<p><b>Password: </b>password</p>
	</div>
	<div class="login">
		<h1 class="text-center">Login</h1>
		<br><br>

		<?php

		if (isset($_SESSION['login'])) {
			echo $_SESSION['login'];	//displaying
			unset($_SESSION['login']); // removing
		}
		if (isset($_SESSION['no-login-message'])) {
			echo $_SESSION['no-login-message'];	//displaying
			unset($_SESSION['no-login-message']); // removing
		}


		?>
		<!-- login form starts here -->

		<form action="" method="POST">
			Username:
			<input type="text" name="username" placeholder="Enter Username"><br><br>
			Password:
			<input type="password" name="password" placeholder="Enter Password"><br><br>
			<br>
			<!-- login form ends here -->

			<button type="submit" name="submit" value="Login" class="btn-primary">Login</button>
			<br><br>
		</form>
	</div>

</body>

</html>

<?php

//check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
	//  echo "clicked";
	$username = mysqli_escape_string($conn, $_POST['username']);
	$encryptedPassword = md5($_POST['password']);
	$password = mysqli_escape_string($conn, $encryptedPassword);

	//sql query to check whether the user with username and password exists or not
	$sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";

	//execute the query
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));



	//count rows to check whether the user exists or not
	$count = mysqli_num_rows($res);

	if ($count == 1) {
		$_SESSION['login'] = "<div class='success'>Login Successful!!</div>";
		$_SESSION['user'] = $username;	//to check whether is logged in or not 
		#Redirect page to Home page
		header("location: " . SITEURL . 'admin/index.php');
	} else {
		$_SESSION['login'] = "<div class='error'>Login Failed!!</div>";
		#Redirect page to login page
		header("location: " . SITEURL . 'admin/login.php');
	}

}




?>