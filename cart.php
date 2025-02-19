<?php
session_start();
include('config.php');

if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $conn = getDbConnection();
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($result);

        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'image' => $product['image']
                ];
            }

            // Set success message
            $_SESSION['success_message'] = "Product added to cart successfully!";
        } else {
            echo "Product not found!";
            exit();
        }
    } else {
        echo "Invalid request!";
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'update_cart') {
    if (isset($_POST['id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['id'];
        $new_quantity = $_POST['quantity'];

        if (isset($_SESSION['cart'][$product_id])) {
            if ($new_quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'remove_from_cart') {
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];
        unset($_SESSION['cart'][$product_id]);
    }
}

$cart_empty = empty($_SESSION['cart']);
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - E-commerce</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212; /* Dark background */
            color: #ffffff; /* Light text */
        }
        .card {
            background-color: #1e1e1e; /* Dark card background */
            border: 1px solid #333;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.5);
        }
        .btn-primary {
            background-color: #bb86fc;
            border-color: #bb86fc;
        }
        .btn-primary:hover {
            background-color: #985eff;
            border-color: #985eff;
        }
        footer {
            background-color: #1e1e1e;
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
        }
        .table {
            background-color: #1e1e1e;
            color: #fff;
            border-color: #333;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle; /* Ensures proper vertical alignment of content */
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        /* Ensure proper styling for quantity input field */
        .quantity-form {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-form input[type="number"] {
            width: 60px;
            padding: 5px;
            text-align: center;
            margin-right: 10px; /* Space between input and button */
        }
        .quantity-form button {
            padding: 6px 12px;
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container mt-4">
    <h2 class="text-center">Your Cart</h2>

    <?php if ($cart_empty): ?>
        <p class="text-center">Your cart is empty.</p>
        <a href="index.php" class="btn btn-primary d-block mx-auto">Go to Home page</a>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                    <?php
                        $item_total = $item['price'] * $item['quantity'];
                        $total += $item_total;
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php echo $item['name']; ?>
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <form method="POST" action="cart.php" class="quantity-form">
                                <input type="hidden" name="action" value="update_cart">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                                <button type="submit" class="btn btn-info">Update</button>
                            </form>
                        </td>
                        <td>$<?php echo number_format($item_total, 2); ?></td>
                        <td><a href="cart.php?action=remove_from_cart&id=<?php echo $product_id; ?>" class="btn btn-danger">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h3 class="text-right">Total: $<?php echo number_format($total, 2); ?></h3>
        <a href="checkout.php" class="btn btn-success btn-block mt-3">Proceed to Checkout</a>
    <?php endif; ?>
</div>

<footer class="py-4 mt-4">
    <div class="container text-center">
        <p>&copy; 2024 E-commerce. All Rights Reserved @HAT.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
