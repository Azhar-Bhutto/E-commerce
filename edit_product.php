<?php
include('config.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $conn = getDbConnection();
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found!";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $image_name = $product['image'];  
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_folder = 'images/';
            $image_path = $image_folder . basename($image_name);
            move_uploaded_file($image_tmp, $image_path);
        }
        $sql = "UPDATE products SET name = '$name', description = '$description', price = '$price', 
                image = '$image_name', quantity = '$quantity' WHERE id = $product_id";
        
        if (mysqli_query($conn, $sql)) {
            echo "Product updated successfully!";
            header('Location: admin.php'); 
            exit();
        } else {
            echo "Error updating product: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    background-color: #121212; /* Dark background */
    color: #ffffff; /* Light text */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Edit Product</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" required><?php echo $product['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" id="image" name="image" class="form-control">
                <small>Current image: <?php echo $product['image']; ?></small>
            </div>
            <button type="submit" class="btn btn-success">Update Product</button>
        </form>
        <a href="admin.php" class="btn btn-secondary mt-3">Back to Admin Panel</a>
    </div>
</body>
</html>
