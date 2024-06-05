<?php include ("partials/menu.php"); ?>


<!-- Main Content Section Starts -->
<div class="main-content">
	<div class="wrapper">
		<h1>Add Admin</h1>
		<?php

		if (isset($_SESSION['add'])) {
			echo $_SESSION['add'];	//displaying
			unset($_SESSION['add']); // removing
		}

		?>
		<form action="" method="POST">
			<table class="tbl-full">
				<tr>
					<td>Full Name:</td>
					<td><input type="text" name="full_name" placeholder="Enter your name"></td>
				</tr>

				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" placeholder="Enter your usernmae"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" placeholder="Enter your password"></td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="submit" name="submit" value="Add Admin" class="btn-secondary">Add Admin</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<!-- Main Content Section Ends -->


<?php include ("partials/footer.php"); ?>

<?php
//process the value from form and save it in database

//Check whether the sumit butotn is clicked or not
if (isset($_POST["submit"])) {

	// echo"Button clicked";

	//Get data from form
	$full_name = mysqli_escape_string($conn, $_POST['full_name']);
	$username = mysqli_escape_string($conn, $_POST['username']);
	$password = mysqli_escape_string($conn, md5($_POST['password']));  //Password Encryption with MD5

	//SQL Query to save the data into database
	$sql = "INSERT INTO tbl_admin SET 
				full_name='$full_name',
				username='$username',
				password='$password'
		";

	//Execute query and save data in the database
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	if ($res == true) {
		#create a session variable to display message
		$_SESSION['add'] = "<div class='success'>Admin Added Successfully!!</div>";
		#Redirect page to manage admin
		header("location: " . SITEURL . 'admin/manage-admin.php');
	} else {
		$_SESSION['add'] = "<div class='error'>Failed To Add Admin!!</div>";
		#Redirect page to add admin
		header("location: " . SITEURL . 'admin/add-admin.php');
	}
}
?>