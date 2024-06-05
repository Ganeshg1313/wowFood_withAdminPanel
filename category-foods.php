<?php include ('partials-front/menu.php'); ?>


<?php

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

    //Execute the query
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $rows = mysqli_fetch_assoc($res);

    if ($rows <= 0) {
        header('location:' . SITEURL);
    }

    $category_title = $rows['title'];
} else {
    header('location:' . SITEURL);
}

?>


<! -- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php


            //query to get all category 
            // $sql = "SELECT * FROM tbl_food WHERE title='$search'";
            $sql2 = "SELECT * FROM tbl_food WHERE category_id='$category_id'";

            //Execute the query
            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));


            $count = mysqli_num_rows($res2);

            if ($count > 0) {
                while ($rows = mysqli_fetch_assoc($res2)) {

                    $id = $rows['id'];
                    $title = $rows['title'];
                    $price = $rows['price'];
                    $description = $rows['description'];
                    $image_name = $rows['image_name'];
                    ?>

                    <div class="food-menu-box">
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
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>/order.php?food_id=<?php echo $id; ?>"
                                class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<div class='error'>Food Not Available.</div>";
            }


            ?>




            <div class="clearfix"></div>



        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include ('partials-front/footer.php'); ?>