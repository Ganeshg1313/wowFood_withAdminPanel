<?php

include ('../config/constants.php');

//Get the id of admin to be deleted
$id = $_GET['id'];

//Create sql query to delete admin
$sql = "DELETE FROM  tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

if ($res == true) {
	#create a session variable to display message
	$_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully!!</div>";
	#Redirect page to manage admin
	header("location: " . SITEURL . 'admin/manage-admin.php');
} else {
	$_SESSION['delete'] = "<div class='error'>Failed To Delete Admin!!</div>";
	#Redirect page to manage admin
	header("location: " . SITEURL . 'admin/manage-admin.php');
}


