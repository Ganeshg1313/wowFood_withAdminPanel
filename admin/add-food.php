<?php include ('partials/menu.php') ?>


<div class="main-content">
	<div class="wrapper">
		<h1>Add Food</h1>
		<br><br><br>
		<?php
		if (isset($_SESSION['upload'])) {
			echo $_SESSION['upload'];	//displaying
			unset($_SESSION['upload']); // removing
		}

		?>
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-full">
				<tr>
					<td>Title: </td>
					<td>
						<input type="text" name="title" placeholder="Title of the food">
					</td>
				</tr>

				<tr>
					<td>Description: </td>
					<td>
						<textarea name="description" cols="30" rows="5"
							placeholder="Description of the food"></textarea>
					</td>
				</tr>

				<tr>
					<td>Price: </td>
					<td>
						<input type="number" name="price">
					</td>
				</tr>
				<tr>
					<td>Select Image: </td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				<tr>
					<td>Category:</td>
					<td>
						<select name="category">

							<?php
							//create php to display categories from databse
							//create s1l to get all active categories
							$sql = "SELECT * FROM tbl_category WHERE active='Yes'";

							// execute query and save data in database
							$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

							$count = mysqli_num_rows($res);

							if ($count > 0) {
								//we have categories
								while ($rows = mysqli_fetch_assoc($res)) {
									//get the details of category
									$id = $rows['id'];
									$title = $rows['title'];
									?>
									<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
									<?php
								}
							} else {
								//we do not have category
								?>
								<option value="0">No Categories Found</option>
								<?php
							}
							//display on dropdown
							?>


						</select>
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
						<button type="submit" name="submit" value="Add Food" class="btn-secondary">Add Food</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>


<?php

// Process the value from form and save it in database
// Check whether the submit button is clicked or not

if (isset($_POST['submit'])) {
	//button clicked
	// echo"button clicked";

	// Get the data from form
	$title = mysqli_escape_string($conn, $_POST['title']);
	$description = mysqli_escape_string($conn, $_POST['description']);
	$price = mysqli_escape_string($conn, $_POST['price']);
	$category = mysqli_escape_string($conn, $_POST['category']);

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

	if (isset($_FILES['image']['name'])) {
		//upload the image
		//to upload image we need image name and src path and destination path
		$image_name = $_FILES['image']['name'];

		//Upload image only if image is selectes
		if ($image_name != '') {

			//Auto rename our image
			//get the extension of our image(jpg,png)e.g. 'food1.jpg'
			$type = explode('.', $image_name);
			$ext = end($type);

			//Rename the image
			$image_name = "Food_Name_" . rand(0000, 9999) . '.' . $ext;//e.g. 'Food_Category_011.jpg'

			$source_path = $_FILES['image']['tmp_name'];

			$destination_path = "../images/food/" . $image_name;

			//upload the image
			$upload = move_uploaded_file($source_path, $destination_path);

			//check whether the image is uploaded or not
			//if the image is not uploaded then we will stop the process and redirect with error message
			if ($upload == false) {
				//set message
				$_SESSION['upload'] = "<div class='error'>Failed to upload image!!</div>";
				#Redirect page to add category
				header("location: " . SITEURL . 'admin/add-food.php');
				//stop the process
				die();
			}
		}
	} else {
		//Don't upload image and set the image name value as blank
		$image_name = "";
	}

	// sql query to save data into database
	$sql2 = "INSERT INTO tbl_food SET 
				title='$title',
				description='$description',
				price=$price,
				image_name='$image_name',
				category_id=$category,
				featured='$featured',
				active='$active'

		";

	// execute query and save data in database
	$res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

	if ($res2 == true) {
		#create a session variable to display message
		$_SESSION['add'] = "<div class='success'>Food Added Successfully!!</div>";
		#Redirect page to manage food
		header("location: " . SITEURL . 'admin/manage-food.php');
	} else {
		$_SESSION['add'] = "<div class='error'>Failed To Add Food!!</div>";
		#Redirect page to add food
		header("location: " . SITEURL . 'admin/manage-food.php');
	}
}

?>



<?php include ('partials/footer.php') ?>