<?php
session_start();
include('config.php');

if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

$cart_items = $_SESSION['cart'];
$total_price = 0;
$sale_percentage = 30; // Flat 30% off

// Calculate total price with a 30% discount applied to each product
foreach ($cart_items as $item) {
    $discounted_price = $item['price'] - ($item['price'] * $sale_percentage / 100);
    $total_price += $discounted_price * $item['quantity'];
}

$order_success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_success = true;
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - E-commerce</title>
    <!-- External CSS Links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
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

        .btn-primary, .btn-success {
            background-color: #bb86fc;
            border-color: #bb86fc;
        }

        .btn-primary:hover, .btn-success:hover {
            background-color: #985eff;
            border-color: #985eff;
        }

        /* Updated Button for Place Order */
        .btn-place-order {
            background-color: #007bff; /* Blue background */
            border-color: #007bff; /* Blue border */
        }

        .btn-place-order:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3; /* Darker blue border */
        }

        footer {
            background-color: #1e1e1e;
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
        }

        .table {
            background-color: #1e1e1e; /* Dark table background */
            color: #ffffff; /* Light text */
            border-color: #333;
        }

        .table th, .table td {
            border-top: 1px solid #333;
        }

        .alert {
            background-color: #007bff; /* Blue background */
            color: #ffffff; /* White text */
            border-color: #007bff; /* Blue border */
        }

        h1, h4 {
            font-weight: bold;
        }

        .container {
            margin-bottom: 2rem;
        }

        .text-right h5 {
            color: #007bff; /* Blue color for Total text */
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Checkout</h1>

    <?php if ($order_success): ?>
        <div class="alert alert-success" role="alert">
            Your order has been placed successfully!
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <h4>Your Cart</h4>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Original Price</th>
                                <th>Discounted Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): 
                                $discounted_price = $item['price'] - ($item['price'] * $sale_percentage / 100); ?>
                                <tr>
                                    <td><?php echo $item['name']; ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td>$<?php echo number_format($discounted_price, 2); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>$<?php echo number_format($discounted_price * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <h5>Total: $<?php echo number_format($total_price, 2); ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h4>Shipping Information</h4>
            <div class="card">
                <div class="card-body">
                    <form action="checkout.php" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Shipping Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <button type="submit" class="btn btn-place-order btn-block">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="py-4 mt-4">
    <div class="container text-center">
        <p>&copy; 2024 E-commerce. All Rights Reserved @HAT.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
