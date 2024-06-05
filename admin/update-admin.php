<?php include ('partials/menu.php') ?>


<div class="main-content">
	<div class="wrapper">
		<h1>Update Admin</h1>
		<br><br><br>
		<?php



		//Get the id of admin to be deleted
		$id = $_GET['id'];

		//Create sql query to delete admin
		$sql = "SELECT * FROM  tbl_admin WHERE id=$id";

		//execute the query
		
		$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

		if ($res == true) {

			$count = mysqli_num_rows($res);
			if ($count == 1) {
				// echo "Admin Available";
				$row = mysqli_fetch_assoc($res);

				$full_name = $row['full_name'];
				$username = $row['username'];
			} else {
				header("location: " . SITEURL . 'admin/manage-admin.php');
			}

		}


		//Redirect to manage admin page with message(success/error)
		



		?>
		<form action="" method="POST">
			<table class="tbl-full">
				<tr>
					<td>Full Name:</td>
					<td><input type="text" name="full_name" value="<?php echo $full_name; ?>"></td>
				</tr>

				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" value="<?php echo $username; ?>"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<button type="submit" name="submit" value="Update Admin" class="btn-secondary">Update
							Admin</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<?php

//check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
	// echo "clicked";
	//get all the values from form to update
	$id = mysqli_escape_string($conn, $_POST['id']);
	$full_name = mysqli_escape_string($conn, $_POST['full_name']);
	$username = mysqli_escape_string($conn, $_POST['username']);


	#create a sql query to upadte admin
	$sql = "UPDATE tbl_admin SET 
				full_name='$full_name',
				username='$username'
				WHERE id='$id'
		";




	//execute the query
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	#check whether the query has successfully executed
	if ($res == true) {
		#create a session variable to display message
		$_SESSION['update'] = "<div class='success'>Admin Update Successfully!!</div>";
		#Redirect page to manage admin
		header("location: " . SITEURL . 'admin/manage-admin.php');
	} else {
		$_SESSION['update'] = "<div class='error'>Failed To Update Admin!!</div>";
		#Redirect page to add admin
		header("location: " . SITEURL . 'admin/manage-admin.php');
	}
}


?>


<?php include ('partials/footer.php') ?>