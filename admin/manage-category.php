<?php include ('../admin/partials/menu.php') ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>tp</title>
</head>

<body>
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Category</h1>
			<br><br>

			<?php

			if (isset($_SESSION['add'])) {
				echo $_SESSION['add'];	//displaying
				unset($_SESSION['add']); // removing
			}
			if (isset($_SESSION['remove'])) {
				echo $_SESSION['remove'];	//displaying
				unset($_SESSION['remove']); // removing
			}
			if (isset($_SESSION['delete'])) {
				echo $_SESSION['delete'];	//displaying
				unset($_SESSION['delete']); // removing
			}
			if (isset($_SESSION['delete'])) {
				echo $_SESSION['delete'];	//displaying
				unset($_SESSION['delete']); // removing
			}
			if (isset($_SESSION['no-category-found'])) {
				echo $_SESSION['no-category-found'];	//displaying
				unset($_SESSION['no-category-found']); // removing
			}
			if (isset($_SESSION['update'])) {
				echo $_SESSION['update'];	//displaying
				unset($_SESSION['update']); // removing
			}
			if (isset($_SESSION['upload'])) {
				echo $_SESSION['upload'];	//displaying
				unset($_SESSION['upload']); // removing
			}
			if (isset($_SESSION['failed-remove'])) {
				echo $_SESSION['failed-remove'];	//displaying
				unset($_SESSION['failed-remove']); // removing
			}



			?>
			<br>
			<!-- button to add admin -->
			<a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
			<br><br><br>
			<table class="tbl-full">
				<tr>
					<th>S.N.</th>
					<th>Title</th>
					<th>Image</th>
					<th>Featured</th>
					<th>Active</th>
					<th>Actions</th>
				</tr>
				<?php

				//query to get all category 
				$sql = "SELECT * FROM tbl_category";

				//Execute the query
				$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

				$count = mysqli_num_rows($res);

				$sn = 1;//create a variable and assign a value
				
				if ($count > 0) {
					while ($rows = mysqli_fetch_assoc($res)) {
						//using while to get all the data
						//get individual data
						$id = $rows['id'];
						$title = $rows['title'];
						$image_name = $rows['image_name'];
						$featured = $rows['featured'];
						$active = $rows['active'];

						?>

						<tr>
							<td><?php echo $sn++; ?></td>
							<td><?php echo $title; ?></td>

							<td>
								<?php
								//check whether image_name is available or not
								if ($image_name != '') {
									//display the image
									// Load an image from PNG URL
						

									?>
									<img src="<?php echo SITEURL; ?>/images/category/<?php echo $image_name; ?>" width="100px">

									<?php
								} else {
									//display the message
									echo "<div class='error'>Image not Added</div>";
								}
								?>
							</td>

							<td><?php echo $featured; ?></td>
							<td><?php echo $active; ?></td>
							<td>
								<a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>"
									class="btn-secondary">Update Category</a>
								<a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name ?>"
									class="btn-danger">Delete Category</a>
							</td>
						</tr>

						<?php

					}
				} else {
					//we will display the message inside table
					?>

					<tr>
						<td colspan="6">
							<div class="error">No category Added.</div>
						</td>
					</tr>

					<?php
				}

				?>
			</table>

		</div>
	</div>

</body>

</html>
<?php include ('../admin/partials/footer.php') ?>