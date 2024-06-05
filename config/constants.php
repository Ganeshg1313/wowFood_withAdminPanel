<?php 

//Start Session
session_start();

//SITE URL
define("SITEURL","http://wowfood.free.nf/");

//Database paramters
define("servername","");
define("username","");
define("password","");
define("dbname","");

$conn = mysqli_connect(servername, username, password);
$db_select = mysqli_select_db($conn, dbname) or die(mysqli_error($conn));

