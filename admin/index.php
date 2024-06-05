<?php include ('partials/menu.php') ?>


<!-- Main Content Section Starts -->

<div class="main-content">
	<div class="wrapper">
		<h1>Dashboard</h1>
		<div class="boxes">

			<br>
			<?php

			if (isset($_SESSION['login'])) {
				echo $_SESSION['login'];	//displaying
				unset($_SESSION['login']); // removing
			}

			?>
			<br>
			<div class="col-4 text-center">
				<?php

				$sql = "SELECT * FROM tbl_category";
				//execute the query
				$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

				$count = mysqli_num_rows($res);

				?>
				<h1><?php echo $count; ?></h1>
				<br>
				Categories
			</div>
			<div class="col-4 text-center">
				<?php

				$sql2 = "SELECT * FROM tbl_food";
				//execute the query
				$res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

				$count2 = mysqli_num_rows($res2);

				?>
				<h1><?php echo $count2; ?></h1>
				<br>
				Foods
			</div>


			<div class="col-4 text-center">
				<?php

				$sql3 = "SELECT * FROM tbl_order";
				//execute the query
				$res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

				$count3 = mysqli_num_rows($res3);

				?>
				<h1><?php echo $count3; ?></h1>
				<br>
				Orders
			</div>


			<div class="col-4 text-center">

				<?php

				$sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
				//execute the query
				$res4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));

				$row = mysqli_fetch_assoc($res4);

				$total = $row['Total'];

				?>

				<h1>$<?php echo $total; ?></h1>
				<br>
				Revenue
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

<!-- Main Content Section Ends -->

<?php include ('partials/footer.php') ?>