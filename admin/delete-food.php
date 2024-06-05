<?php

include ('../config/constants.php');

//Get the id of admin to be deleted
if (isset($_GET['id']) and isset($_GET['image_name'])) {
	$id = $_GET['id'];
	$image_name = $_GET['image_name'];

	//Remove the physical image file 
	if ($image_name != "") {

		//image is available
		$path = "../images/food/$image_name";
		$remove = unlink($path);

		//if failed to remove image
		if ($remove == false) {
			//session message
			$_SESSION['remove'] = "<div class='error'>Failed To Delete Image!!</div>";
			#Redirect page to manage category
			header("location: " . SITEURL . 'admin/manage-food.php');
			//stop the process
			die();

		}
	}
	//Create sql query to delete food
	$sql = "DELETE FROM  tbl_food WHERE id=$id";

	//execute the query
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	if ($res == true) {
		#create a session variable to display message
		$_SESSION['delete'] = "<div class='success'>Food Deleted Successfully!!</div>";
		#Redirect page to manage category
		header("location: " . SITEURL . 'admin/manage-food.php');
	} else {
		$_SESSION['delete'] = "<div class='error'>Failed To Delete Food!!</div>";
		#Redirect page to manage category
		header("location: " . SITEURL . 'admin/manage-food.php');
	}



} else {
	header("location: " . SITEURL . 'admin/manage-category.php');
}







?>