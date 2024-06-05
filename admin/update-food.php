<?php include ('partials/menu.php') ?>


<div class="main-content">
	<div class="wrapper">
		<h1>Update Food</h1>
		<br><br><br>
		<?php


		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$sql = "SELECT * FROM  tbl_food WHERE id=$id ";


			//execute the query
			$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

			//count the rows whether id is valid or not
			$count = mysqli_num_rows($res);

			if ($count == 1) {
				//get all the data
				$rows = mysqli_fetch_assoc($res);
				$title = $rows['title'];
				$description = $rows['description'];
				$price = $rows['price'];
				$current_image = $rows['image_name'];
				$current_category = $rows['category_id'];
				$featured = $rows['featured'];
				$active = $rows['active'];

			} else {
				$_SESSION['no-category-found'] = "<div class='error'>Food not found!!</div>";
				#Redirect page to manage admin
				header("location: " . SITEURL . 'admin/manage-food.php');
			}
		} else {
			header("location: " . SITEURL . 'admin/manage-food.php');
		}



		?>
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-full">
				<tr>
					<td>Title:</td>
					<td><input type="text" name="title" value="<?php echo $title; ?>"></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td>
						<textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
					</td>
				</tr>
				<tr>
					<td>Price:</td>
					<td><input type="number" name="price" value="<?php echo $price; ?>"></td>
				</tr>
				<tr>
					<td>Current Image: </td>
					<td>
						<!-- Image will be displayed -->
						<?php
						//check whether image_name is available or not
						if ($current_image != '') {
							//display the image
							// Load an image from PNG URL
						

							?>
							<img src="http://localhost/foodOrder/images/food/<?php echo $current_image; ?>" width="100px">

							<?php
						} else {
							//display the message
							echo "<div class='error'>Image not Added</div>";
						}
						?>


					</td>
				</tr>
				<tr>
					<td>New Image: </td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				<tr>
					<td>Category:</td>
					<td>
						<select name="category">

							<?php

							$sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";

							//execute the query
							$res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

							//count the rows whether id is valid or not
							$count = mysqli_num_rows($res2);

							if ($count > 0) {
								while ($rows = mysqli_fetch_assoc($res2)) {
									$category_title = $rows['title'];
									$category_id = $rows['id'];
									?>
									<option <?php
									if ($current_category == $category_id) {
										echo "selected ";
									}
									?>
										value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
									<?php
								}
							} else {
								echo "<option value='0'>category not available</option>";
							}

							?>

						</select>
					</td>
				</tr>
				<tr>

					<td>Featured:</td>
					<td><input <?php if ($featured == 'Yes') {
						echo "checked";
					} ?> type="radio" name="featured"
							value="Yes">Yes</td>
					<td><input <?php if ($featured == 'No') {
						echo "checked";
					} ?> type="radio" name="featured" value="No">No
					</td>

				</tr>
				<tr>
					<td>Active:</td>
					<td><input <?php if ($active == 'Yes') {
						echo "checked";
					} ?> type="radio" name="active" value="Yes">Yes
					</td>
					<td><input <?php if ($active == 'No') {
						echo "checked";
					} ?> type="radio" name="active" value="No">No
					</td>

				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
						<input type="hidden" name="current_category" value="<?php echo $current_category; ?>">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<button type="submit" name="submit" value="Update Category" class="btn-secondary">Update
							Food</button>
					</td>
				</tr>
			</table>
		</form>


		<?php
		if (isset($_POST['submit'])) {
			$id = $_POST['id'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$current_image = $_POST['current_image'];
			$category = $_POST['category'];
			$featured = $_POST['featured'];
			$active = $_POST['active'];

			//check whether upload button is clicked or not
			if (isset($_FILES['image']['name'])) {
				$image_name = $_FILES['image']['name'];
				//Upload image only if image is selectes
				if ($image_name != '') {
					//Auto rename our image
					//get the extension of our image(jpg,png)e.g. 'food1.jpg'
					$type = explode('.', $image_name);
					$ext = end($type);

					//Rename the image
					$image_name = "Food_Name_" . rand(000, 999) . '.' . $ext;//e.g. 'Food_Category_011.jpg'
		
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
						header("location: " . SITEURL . 'admin/manage-food.php');
						//stop the process
						die();
					}
					//remove the image
					if ($current_image != "") {
						$path = "../images/food/$current_image";
						$remove = unlink($path);

						//if failed to remove image
						if ($remove == false) {
							//session message
							$_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Image!!</div>";
							#Redirect page to manage category
							header("location: " . SITEURL . 'admin/manage-food.php');
							//stop the process
							die();

						}
					}
				} else {
					$image_name = $current_image;
				}
			} else {
				$image_name = $current_image;
			}
			#create a sql query to upadte admin
			$sql3 = "UPDATE tbl_food SET 
				title='$title',
				description='$description',
				price=$price,
				image_name='$image_name',
				category_id=$category,
				featured='$featured',
				active='$active'
				WHERE id='$id'

		";




			//execute the query
			$res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

			#check whether the query has successfully executed
			if ($res3 == true) {
				#create a session variable to display message
				$_SESSION['update'] = "<div class='success'>Category Update Successfully!!</div>";
				#Redirect page to manage food
				header("location: " . SITEURL . 'admin/manage-food.php');
			} else {
				$_SESSION['update'] = "<div class='error'>Failed To Update Category!!</div>";
				#Redirect page to add food
				header("location: " . SITEURL . 'admin/manage-food.php');
			}

		}

		?>


	</div>
</div>



<?php include ('partials/footer.php') ?>