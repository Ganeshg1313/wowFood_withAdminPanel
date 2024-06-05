<?php include ('partials/menu.php') ?>


<!-- Main Content Section Starts -->

<div class="main-content">
	<div class="wrapper">
		<h1>Add Category</h1>
		<br><br><br>
		<?php

		if (isset($_SESSION['add'])) {
			echo $_SESSION['add'];	//displaying
			unset($_SESSION['add']); // removing
		}
		if (isset($_SESSION['upload'])) {
			echo $_SESSION['upload'];	//displaying
			unset($_SESSION['upload']); // removing
		}
		?>
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-full">
				<tr>
					<td>Title:</td>
					<td><input type="text" name="title" placeholder="Category Title"></td>
				</tr>
				<tr>
					<td>Select Image: </td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				<tr>
					<td>Featured:</td>
					<td><input type="radio" name="featured" value="Yes">Yes</td>
					<td><input type="radio" name="featured" value="No">No</td>

				</tr>
				<tr>
					<td>Active:</td>
					<td><input type="radio" name="active" value="Yes">Yes</td>
					<td><input type="radio" name="active" value="No">No</td>

				</tr>
				<tr>
					<td colspan="2">
						<button type="submit" name="submit" value="Add Category" class="btn-secondary">Add
							Category</button>
					</td>
				</tr>
			</table>
		</form>

		<?php
		// Check whether the submit button is clicked or not
		
		if (isset($_POST['submit'])) {
			//button clicked
			//echo"button clicked";
		
			// Get the data from form
			$title = mysqli_escape_string($conn, $_POST['title']);

			//for radio input type we need to check whether the button is selected or not
			if (isset($_POST['featured'])) {
				//Get the value
				$featured = $_POST['featured'];
			} else {
				//set the default value
				$featured = "No";
			}
			if (isset($_POST['active'])) {
				//Get the value
				$active = $_POST['active'];
			} else {
				//set the default value
				$active = "No";
			}

			//check whether the image is selected ir not and set value for image accordingly
			//print_r($_FILES['image']);
		
			//die();//break the code here
		
			if (isset($_FILES['image']['name'])) {
				//upload the image
				//to upload image we need image name and src path and destination path
				$image_name = $_FILES['image']['name'];

				//Upload image only if image is selectes
				if ($image_name != '') {
					//Auto rename our image
					//get the extension of our image(jpg,png)e.g. 'food1.jpg'
					$parts = explode('.', $image_name);
					$ext = end($parts);


					//Rename the image  
					$image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;//e.g. 'Food_Category_011.jpg'
		
					$source_path = $_FILES['image']['tmp_name'];

					$destination_path = "../images/category/" . $image_name;

					//upload the image
					$upload = move_uploaded_file($source_path, $destination_path);

					//check whether the image is uploaded or not
					//if the image is not uploaded then we will stop the process and redirect with error message
					if ($upload == false) {
						//set message
						$_SESSION['upload'] = "<div class='error'>Failed to upload image!!</div>";
						#Redirect page to add category
						header("location: " . SITEURL . 'admin/add-category.php');
						//stop the process
						die();
					}
				}
			} else {
				//Don't upload image and set the image name value as blank
				$image_name = "";
			}

			// sql query to save data into database
			$sql = "INSERT INTO tbl_category SET 
				title='$title',
				image_name='$image_name',
				featured='$featured',
				active='$active'
		";

			// execute query and save data in database
			$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

			if ($res == true) {
				#create a session variable to display message
				$_SESSION['add'] = "<div class='success'>Category Added Successfully!!</div>";
				#Redirect page to manage admin
				header("location: " . SITEURL . 'admin/manage-category.php');
			} else {
				$_SESSION['add'] = "<div class='error'>Failed to add category!!</div>";
				#Redirect page to add admin
				header("location: " . SITEURL . 'admin/add-category.php');
			}
		}


		?>

	</div>
</div>

<!-- Main Content Section Ends -->




<?php include ('partials/footer.php') ?>