<?php
session_start();
include('config.php');  

$conn = getDbConnection();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='container mt-4 alert alert-danger'>Product not found!</div>";
        exit;
    }
} else {
    echo "<div class='container mt-4 alert alert-danger'>Product ID is missing!</div>";
    exit;
}

if (isset($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
} else {
    $cart_count = 0;
}

// Display success message if exists
if (isset($_SESSION['success_message'])) {
    echo "<div class='container mt-4 alert alert-success'>".$_SESSION['success_message']."</div>";
    unset($_SESSION['success_message']); // Clear the success message after displaying it
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Product Detail</title>
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

    <?php
        include('navbar.php');
    ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
        
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="col-md-6">
                <h3 class="text-success">$<?php echo number_format($product['price'], 2); ?></h3>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

                <form action="cart.php" method="POST">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" required>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="action" value="add_to_cart"> <!-- Add hidden action field -->
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg- py-4 mt-4">
    <div class="container text-center">
        <p>&copy; 2024 E-commerce. All Rights Reserved @HAT.</p>
    </div>
</footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
