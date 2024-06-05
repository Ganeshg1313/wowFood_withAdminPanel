<?php include ('partials-front/menu.php'); ?>
<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>
        <?php

        //query to get all category 
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

        //Execute the query
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($rows = mysqli_fetch_assoc($res)) {
                //using while to get all the data
                //get individual data
                $id = $rows['id'];
                $title = $rows['title'];
                $image_name = $rows['image_name'];
                ?>
                <a href="<?php echo SITEURL; ?>/category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        //check whether image_name is available or not
                        if ($image_name != '') {
                            //display the image
                            // Load an image from PNG URL
                

                            ?>
                            <img src="<?php echo SITEURL; ?>/images/category/<?php echo $image_name; ?>
                                                         " class="img-responsive img-curve">

                            <?php
                        } else {
                            //display the message
                            echo "<div class='error'>Image not Available</div>";
                        }
                        ?>

                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>
                <?php

            }
        } else {
            echo "<div class='error'>No category Added.</div>";
        }


        ?>






        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include ('partials-front/footer.php'); ?>