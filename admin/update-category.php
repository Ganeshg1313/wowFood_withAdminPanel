<?php include('partials/menu.php')?>


<div class="main-content">
		<div class="wrapper">
			<h1>Update Category</h1>
			<br><br><br>
<?php

 
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$sql = "SELECT * FROM  tbl_category WHERE id=$id ";


			//execute the query=
			$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

			//count the rows whether id is valid or not
			$count = mysqli_num_rows($res);

			if($count==1)
			{
				//get all the data
				$rows = mysqli_fetch_assoc($res);
				$title = $rows['title'];
				$current_image = $rows['image_name'];
				$featured = $rows['featured'];
				$active = $rows['active'];
				
			}
			else
			{
					$_SESSION['no-category-found'] = "<div class='error'>Category not found!!</div>";
					#Redirect page to manage admin
					header("location: ".SITEURL.'admin/manage-category.php');
			}
			}
	else{
		header("location: ".SITEURL.'admin/manage-category.php');
	}


?>
			<form action="" method="POST" enctype="multipart/form-data">
				<table class="tbl-full">
				<tr>
					<td>Title:</td>
					<td><input type="text" name="title" value="<?php echo $title; ?>"></td>
				</tr>	
				<tr>
					<td>Current Image: </td>
					<td>
						<!-- Image will be displayed -->
<?php 
    										//check whether image_name is available or not
    										if($current_image!='')
    										{
    											//display the image
    											// Load an image from PNG URL
													
												
														      ?>
														<img src="http://localhost/foodOrder/images/category/<?php echo $current_image;?>" width="100px">
														  
														<?php
											}
														
    											
    										
    										else
    										{
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
						<td>Featured:</td>
						<td><input <?php if($featured=='Yes'){echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes</td>
						<td><input <?php if($featured=='No'){echo "checked"; } ?> type="radio" name="featured" value="No" >No</td>

				</tr>
					<tr>	
						<td>Active:</td>
						<td><input <?php if($active=='Yes'){echo "checked"; } ?> type="radio" name="active" value="Yes">Yes</td>
						<td><input <?php if($active=='No'){echo "checked"; } ?> type="radio" name="active" value="No" >No</td>

					</tr>
					<tr>	
						<td colspan="2">
							<input type="hidden" name="current_image" value="<?php echo $current_image ;?>">
							<input type="hidden" name="id" value="<?php echo $id ;?>">
							<button type="submit" name="submit" value="Update Category" class="btn-secondary">Update Category</button>
						</td>
					</tr>
			</table>
			</form>
		</div>
	</div>


<?php

//check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
	// echo "clicked";
	//get all the values from form to update
	$title = mysqli_escape_string($conn, $_POST['title']);
	$current_image = $_POST['current_image'];
	$featured = $_POST['featured'];
	$active = $_POST['active'];



		//check whether upload button is clicked or not
	if(isset($_FILES['image']['name']))
	{
		$image_name=$_FILES['image']['name'];
		//Upload image only if image is selectes
	    	if($image_name!='')
	    	{
	    	//Auto rename our image
	    	//get the extension of our image(jpg,png)e.g. 'food1.jpg'
	    	$parts = explode('.', $image_name);
            $ext = end($parts);


	    	//Rename the image
	    	$image_name = "Food_Category_".rand(000,999).'.'.$ext;//e.g. 'Food_Category_011.jpg'

	    	$source_path=$_FILES['image']['tmp_name'];

	    	$destination_path="../images/category/".$image_name;

	    	//upload the image
	    	$upload=move_uploaded_file($source_path, $destination_path);

	    	//check whether the image is uploaded or not
	    	//if the image is not uploaded then we will stop the process and redirect with error message
	    	if($upload==false)
	    	{
	    	//set message
			$_SESSION['upload'] = "<div class='error'>Failed to upload image!!</div>";
			#Redirect page to add category
			header("location: ".SITEURL.'admin/manage-food.php');
			//stop the process
			die();
	    	}
	    	//remove the image
		    if($current_image!=""){
			$path = "../images/category/$current_image";
			$remove = unlink($path);

			//if failed to remove image
			if($remove==false)
			{
				//session message
					$_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Image!!</div>";
					#Redirect page to manage category
					header("location: ".SITEURL.'admin/manage-food.php');
					//stop the process
					die();

			}
		}
		    }
		    else
		    {
		    	$image_name=$current_image;
		    }
	}
	else
	{
		$image_name=$current_image;
	}



	#create a sql query to upadte admin
		$sql2 = "UPDATE tbl_category SET 
				title='$title',
				image_name='$image_name',
				featured='$featured',
				active='$active'
				WHERE id='$id'

		";

	

	//execute the query
	$res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

	#check whether the query has successfully executed
	if($res2==true)
	{
			#create a session variable to display message
			$_SESSION['update'] = "<div class='success'>Category Update Successfully!!</div>";
			#Redirect page to manage category
			header("location: ".SITEURL.'admin/manage-category.php');
	}
	else{
			$_SESSION['update'] = "<div class='error'>Failed To Update Category!!</div>";
			#Redirect page to add category
			header("location: ".SITEURL.'admin/manage-category.php');
	}
}


?>

<?php include('partials/footer.php')?>