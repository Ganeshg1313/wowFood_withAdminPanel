<?php include ('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br><br>
        <!-- button to add admin -->
        <a href="add-food.php" class="btn-primary">Add Food</a>
        <br><br><br>
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
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];	//displaying
            unset($_SESSION['upload']); // removing
        }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];	//displaying
            unset($_SESSION['failed-remove']); // removing
        }
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];	//displaying
            unset($_SESSION['error']); // removing
        }
        if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];	//displaying
            unset($_SESSION['success']); // removing
        }
        ?>
        <br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>active</th>
                <th>Actions</th>
            </tr>

            <?php

            //query to get all category 
            $sql = "SELECT * FROM tbl_food";

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
                    $price = $rows['price'];
                    $image_name = $rows['image_name'];
                    $featured = $rows['featured'];
                    $active = $rows['active'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>$<?php echo $price; ?></td>
                        <td>

                            <?php
                            //check whether image_name is available or not
                            if ($image_name != '') {
                                //display the image
                                // Load an image from PNG URL
                    

                                ?>
                                <img src="<?php echo SITEURL; ?>/images/food/<?php echo $image_name; ?>" width="100px">

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
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>"
                                class="btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name ?>"
                                class="btn-danger">Delete Food</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                //we will display the message inside table
                ?>

                <tr>
                    <td colspan="6">
                        <div class="error">No Food Added.</div>
                    </td>
                </tr>

                <?php
            }

            ?>



        </table>

    </div>
</div>

<!-- Main Content Section Ends -->
<?php include ('partials/footer.php') ?>