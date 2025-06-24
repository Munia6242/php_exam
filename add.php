<?php
    //Include database connection
    require_once 'includes/config.php';

    //Get the form data
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = $_POST['product_description'];
    $image = $_FILES['image'];
    $expired_date = $_POST['expired_date'];

    //Product image upload
    if(!empty($image)) {
        $target_dir = "product_images/";
        $target_file = $target_dir . basename($image["name"]);

        //Move the uploaded file to the target directory
        move_uploaded_file($image["tmp_name"], $target_file);

        //Check file size (2MB limit)
        if ($image["size"] > 2 * 1024 * 1024) {
            die("Sorry, your file is too large. Maximum file size is 2MB.");
        }


        //Check file type (only allow jpg, png, jpeg, gif)
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, $allowed_types)) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
    }

    //Insert product into database
    if ($is_connected) {
        $query = "INSERT INTO product_store (name, price, description, image, expired_date) VALUES ('$name', '$price', '$description', '$target_file', '$expired_date')";

        if (mysqli_query($connection, $query)) {
            header('Location: index.php');
            exit;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    } else {
        echo "Database connection failed.";
    }
?>