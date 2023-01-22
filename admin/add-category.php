<?php
include('partials/menu.php');
?>


<div class="main-content">
    <div class="wrapper">
            <h1>Add Category</h1>
            <br><br>
            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add']; //displaying session message
                unset($_SESSION['add']); //removing session message
            }
?>

            <br>
            <br>
            <!-- add category starts here -->
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="add category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <!-- add category ends here -->


            <?php

// check whether the submit button clicked or not
if (isset($_POST['submit'])) {
    // echo "clicked";

    // 1.get the value from form
    $title = $_POST['title'];
    // for radio input type we need to check whether the button selected or not
    if (isset($_POST['featured'])) {
        $featured = $_POST['featured'];
    } else {
        $featured = "No";
    }
    if (isset($_POST['active'])) {
        $active = $_POST['active'];
    } else {
        $active = "No";
    }

    if (isset($_FILES['image']['name'])) {
        // upload the image
        // to upload image we need image name, source path, destination path
        $image_name = $_FILES['image']['name'];
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/category/" . $image_name;
        // finally upload the image
        $upload = move_uploaded_file($source_path, $destination_path);
        // check whether the image uploaded or not
        if ($upload==false) {
            $_SESSION['upload'] = "<div class='error'>Failed To Upload Image!!!</div>";
            // redirect to home page
            header('location:' . SITEURL . 'admin/add-category.php');
            die();
        }
    } else {
        // don't upload image and set the image name value as blank
        $image_name = "";
    }

    $sql = "INSERT INTO tbl_category SET
title = '$title',
image_name = '$image_name',
featured='$featured',
active='$active'
";
    $res = mysqli_query($conn, $sql);



    // 4.Check whether the (query is executed) data is added or not
    if ($res == true) {
        echo "success";
        // query executed and catagory added
        $_SESSION['add'] = "<div class='success'>Category Added SuccessFully</div>";
        // redirect to the manage category page
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        // failed to add catagory
        echo "failed";
        $_SESSION['add'] = "<div class='error'>Failed To Add Category</div>";
        // redirect to the manage category page
        header('location:' . SITEURL . 'admin/add-category.php');
    }
}

?>


        </div>
    </div>
</div>









<?php include('partials/footer.php'); ?>