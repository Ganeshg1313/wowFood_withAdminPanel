<?php include ('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Update Order</h1>
		<br><br>


		<?php


		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$sql2 = "SELECT * FROM  tbl_order WHERE id=$id ";


			//execute the query=
			$res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

			//count the rows whether id is valid or not
			$count = mysqli_num_rows($res2);

			if ($count == 1) {
				//get all the data
				$rows = mysqli_fetch_assoc($res2);
				$food = $rows['food'];
				$price = $rows['price'];
				$qty = $rows['qty'];
				$total = $rows['total'];
				$status = $rows['status'];


			} else {
				$_SESSION['no-order-found'] = "<div class='error'>Order not found!!</div>";
				#Redirect page to manage order
				header("location: " . SITEURL . 'admin/manage-order.php');
			}
		} else {
			header("location: " . SITEURL . 'admin/manage-food.php');
		}



		?>

		<form action="" method="POST">
			<table class="tbl-full">
				<tr>
					<td>Food Name:</td>
					<td name="food"><b><?php echo $food; ?></b></td>
				</tr>
				<tr>
					<td>Qty:</td>
					<td>
						<input type="number" name="qty" value="<?php echo $qty; ?>">
					</td>
				</tr>
				<tr>
					<td>Status:</td>
					<td>
						<select name="status">
							<option <?php if($status == 'Ordered') {echo 'selected';} ?> value="Ordered">Ordered</option>
							<option <?php if($status == 'On Delivery'){ echo 'selected';} ?> value="On Delivery">On Delivery</option>
							<option <?php if($status == 'Delivered') {echo 'selected';} ?> value="Delivered">Delivered</option>
							<option <?php if($status == 'Cancelled') {echo 'selected';} ?> value="Cancelled">Cancelled
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="price" value="<?php echo $price; ?>">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" value="update order" class="btn-secondary">
					</td>

				</tr>

			</table>
		</form>
		<?php
		if (isset($_POST['submit'])) {
			$id = $_POST['id'];
			$price = mysqli_escape_string($conn, $_POST['price']);
			$qty = mysqli_escape_string($conn, $_POST['qty']);
			$total = $price * $qty;
			$status = $_POST['status'];



			#create a sql query to upadte admin
			$sql3 = "UPDATE tbl_order SET 
                qty=$qty,
                total=$total,
                status='$status'
				
				WHERE id='$id'

		";


			//execute the query
			$res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

			#check whether the query has successfully executed
			if ($res3 == true) {
				#create a session variable to display message
				$_SESSION['order-update'] = "<div class='success'>Order Update Successfully!!</div>";
				#Redirect page to manage food
				header("location: " . SITEURL . 'admin/manage-order.php');
			} else {
				$_SESSION['order-update'] = "<div class='error'>Failed To Update Order!!</div>";

				header("location: " . SITEURL . 'admin/manage-order.php');
			}
		}





		?>

	</div>
</div>

<?php include ('partials/footer.php'); ?>