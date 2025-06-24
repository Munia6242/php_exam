<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require_once 'includes/head.php';
        // database connection
        require_once 'includes/config.php';
    ?>
    <?php
        //Database connection
        $id = $_GET['id'];
        $sql = "SELECT * FROM product_table WHERE id = $id";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $product_store = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    ?>
</head>
<body>
    <!-- Header -->
    <?php
        require_once 'includes/header.php';
    ?>
    
    <!-- Product Edit Form -->
    <main role="main" class="flex-shrink-0">
        <div class="container">
            <h1>Edit Product</h1>
            <?php if (!empty($product_store)): ?>
                <?php foreach ($product_store as $row): ?>
                    <form action="update.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $row['product_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="product_description">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="3"><?php echo $row['product_description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" step="0.01" value="<?php echo $row['product_price']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <img src="<?php echo $row['product_image']; ?>" alt="Product Image" class="img-fluid" style="width: 100px; height: 100px;">
                            <input type="file" class="form-control-file" id="image" name="product_image" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="expired_date">Expired Date</label>
                            <input type="date" class="form-control" id="expired_date" name="expired_date" value="<?php echo $row['expired_date']; ?>" required>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="old_image" value="<?php echo $row['product_image']; ?>">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>