<?php include ("partials/menu.php"); ?>


<!-- Main Content Section Starts -->
<div class="main-content">
	<div class="wrapper">
		<h1>Manage Admin</h1>
		<br>
		<br>
		<?php

		if (isset($_SESSION['add'])) {
			echo $_SESSION['add'];	//displaying
			unset($_SESSION['add']); // removing
		}
		if (isset($_SESSION['delete'])) {
			echo $_SESSION['delete'];	//displaying
			unset($_SESSION['delete']); // removing
		}
		if (isset($_SESSION['update'])) {
			echo $_SESSION['update'];	//displaying
			unset($_SESSION['update']); // removing
		}
		if (isset($_SESSION['user-not-found'])) {
			echo $_SESSION['user-not-found'];	//displaying
			unset($_SESSION['user-not-found']); // removing
		}
		if (isset($_SESSION['not-match'])) {
			echo $_SESSION['not-match'];	//displaying
			unset($_SESSION['not-match']); // removing
		}
		if (isset($_SESSION['change-pwd'])) {
			echo $_SESSION['change-pwd'];	//displaying
			unset($_SESSION['change-pwd']); // removing
		}

		?>
		<br><br>
		<!-- Button to add Admin -->
		<a href="add-admin.php" class="btn-primary">Add Admin</a>
		<br>
		<br>
		<table class="tbl-full">
			<tr>
				<th>S.N</th>
				<th>Full Name</th>
				<th>Username</th>
				<th>Actions</th>
			</tr>
			<?php
			//Query to get all admin
			$sql = "SELECT * FROM tbl_admin";
			#execute the query
			$res = mysqli_query($conn, $sql);
			#check whether the query is executed or not
			if ($res == true) {
				//count rows to check whether we have data in database or not
				$count = mysqli_num_rows($res);//function to get all the rows in databse
			
				$sn = 1;//create a variable and assign a value
			
				//check the no. of rows
				if ($count > 0) {
					//we have data in databse
					while ($rows = mysqli_fetch_assoc($res)) {
						//using while to get all the data
						//get individual data
						$id = $rows['id'];
						$full_name = $rows['full_name'];
						$username = $rows['username'];

						//display the values in table
						?>
						<tr>
							<td><?php echo $sn++; ?></td>
							<td><?php echo $full_name; ?></td>
							<td><?php echo $username; ?></td>
							<td>
								<a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>"
									class="btn-primary">Change Password</a>
								<a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>"
									class="btn-secondary">Update Admin</a>
								<a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>"
									class="btn-danger">Delete Admin</a>
							</td>
						</tr>



						<?php


					}
				} else {
					//we do  it have data in database
				}
			} else {

			}
			?>
		</table>
	</div>
</div>
<!-- Main Content Section Ends -->


<?php include ("partials/footer.php"); ?>