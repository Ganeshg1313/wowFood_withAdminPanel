<?php include ('partials/menu.php') ?>


<div class="main-content">
	<div class="wrapper">
		<h1>Changhe Password</h1>
		<br><br><br>
		<?php



		//Get the id of admin to be deleted
		$id = $_GET['id'];




		//Redirect to manage admin page with message(success/error)
		



		?>
		<form action="" method="POST">
			<table class="tbl-full">
				<!-- 				<tr>
					<td>Old Password:</td>
					<td><input type="password" name="current_password" placeholder="Old Password"></td>
				</tr>	 -->
				<tr>
					<td>New Password:</td>
					<td><input type="password" name="new_password" placeholder="Enter password"></td>
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="confirm_password" placeholder="Confirm password"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<button type="submit" name="submit" value="change password" class="btn-secondary">Change
							Password</button>
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
	$id = $_POST['id'];
	$new_password = md5($_POST['new_password']);
	$confirm_password = md5($_POST['confirm_password']);


	#check whether the current id and password exists or not
	$sql = "SELECT * FROM  tbl_admin WHERE id=$id ";



	//execute the query
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	#check whether the query has successfully executed
	if ($res == true) {
		$count = mysqli_num_rows($res);
		if ($count == 1) {
			if ($new_password == $confirm_password) {
				$sql2 = "UPDATE tbl_admin SET
							password='$new_password'
							WHERE id=$id;
					";
				$res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

				if ($res2 == true) {
					$_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully!!</div>";
					#Redirect page to manage admin
					header("location: " . SITEURL . 'admin/manage-admin.php');
				} else {
					$_SESSION['change-pwd'] = "<div class='error'>Password did not changed!!</div>";
					#Redirect page to manage admin
					header("location: " . SITEURL . 'admin/manage-admin.php');
				}

			} else {
				$_SESSION['not-match'] = "<div class='error'>Password did not match!!</div>";
				#Redirect page to manage admin
				header("location: " . SITEURL . 'admin/manage-admin.php');
			}
		} else {
			$_SESSION['user-not-found'] = "<div class='error'>User not found!!</div>";
			#Redirect page to manage admin
			header("location: " . SITEURL . 'admin/manage-admin.php');
		}
	}

}




?>


<?php include ('partials/footer.php') ?>