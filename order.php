<?php include ('partials-front/menu.php'); ?>

<?php

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

    //Execute the query=
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $rows = mysqli_fetch_assoc($res);
        $title = $rows['title'];
        $price = $rows['price'];
        $image_name = $rows['image_name'];

    } else {
        header('location:' . SITEURL);
    }
} else {
    header('location:' . SITEURL);
}

?>



<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        <?php

        function display(){
            if (isset($_SESSION['order'])) {
                echo $_SESSION['order'];
                unset($_SESSION['order']);
            }
        }
        ?>

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    //check whether image_name is available or not
                    if ($image_name != '') {
                        //display the image
                        // Load an image from PNG URL
                    

                        ?>
                        <img src="<?php echo SITEURL; ?>/images/food/<?php echo $image_name; ?>
                                                         " class="img-responsive img-curve">

                        <?php
                    } else {
                        //display the message
                        echo "<div class='error'>Image not Available</div>";
                    }
                    ?>

                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>

                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <p class="food-price">$<?php echo $price; ?></p>

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Ganesh Ghodke" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. ganeshghodke@mail.com" class="input-responsive"
                    required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>
        <?php

        if (isset($_POST['submit'])) {
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];

            $total = $price * $qty;

            $order_date = date('Y-m-d H:i:s');

            $status = "Ordered"; //Ordered,On Delivery, Delivered, Cancelled
        
            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];


            // save the order in database
        
            $sql2 = "INSERT INTO tbl_order SET 
                food='$food',
                price=$price,
                qty=$qty,
                total=$total,
                order_date='$order_date',
                status='$status',
                customer_name='$customer_name',
                customer_contact='$customer_contact',
                customer_email='$customer_email',
                customer_address='$customer_address'

        ";
            //Execute the query
            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

            if ($res2 == true) {
                #create a session variable to display message
                $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully!!</div>";
                display();


            } else {
                $_SESSION['order'] = "<div class='error text-center'>Failed To Order Food!!</div>";
                display();
            }
        }

        ?>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->


<?php include ('partials-front/footer.php'); ?>