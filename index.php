<?php
session_start();
include('config.php');

$conn = getDbConnection();
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - E-commerce</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  

<style>
/* General Styles */
body {
    background-color: #121212; /* Dark background */
    color: #ffffff; /* Light text */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
/* Add this CSS to change the color of the Flavors by HAT text to blue */
.navbar-text {
    color: #007bff; /* Blue color */
}

.navbar-brand {
        color: #bb86fc !important;
        transition: transform 0.3s ease; /* Add transition for smooth logo scaling */
    }
    .navbar-brand:hover {
        color: #985eff !important;
        transform: scale(1.1); /* Add hover effect for logo scaling */
    }
    .logo {
        max-height: 50px;
        transition: transform 0.3s ease; /* Smooth transition effect */
    }

/* Card Styles */
.card {
    background-color: #1e1e1e;
    border: 1px solid #333;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.5);
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
    text-align: center;
}

.card img {
    height: 200px;
    object-fit: contain;
    margin-bottom: 1rem;
    border-radius: 8px;
}

.card-title {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    color: #ffffff;
}

.card-text {
    font-size: 0.9rem;
    color: #dcdcdc;
    margin-bottom: 1rem;
}

/* Button Styles */
.card .btn {
    width: 48%; /* Equal button width */
    font-weight: 600;
    border-radius: 8px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 5px 1%; /* Space between buttons */
}

.card .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.card .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.card .btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
}

.card .btn-info:hover {
    background-color: #117a8b;
    border-color: #117a8b;
}

.card .btn i {
    margin-right: 8px; /* Space between icon and text */
}

/* Icon-only Buttons */
.card .btn-primary i,
.card .btn-info i {
    margin-right: 0; /* No margin for icon-only buttons */
}

/* Sale Badge */
.sale-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: red;
    color: white;
    padding: 5px 10px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    z-index: 10;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.8); /* Dark background for better visibility */
    width: 50px;
    height: 50px;
    border-radius: 50%; /* Rounded buttons */
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-control-prev-icon::after,
.carousel-control-next-icon::after {
    content: ''; /* Clear default content */
}

.carousel-control-prev span,
.carousel-control-next span {
    font-size: 2rem; /* Large arrow size */
    font-weight: bold;
    color: white; /* White arrows for contrast */
}

/* Hover effect for carousel buttons */
.carousel-control-prev:hover .carousel-control-prev-icon,
.carousel-control-next:hover .carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 1); /* Darker background on hover */
}

.carousel-control-prev,
.carousel-control-next {
    top: 50%;
    transform: translateY(-50%);
}

/* Carousel Styles */
.carousel-item img {
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
}

/* Footer Styles */
footer {
    background-color: #1e1e1e;
    color: #ffffff;
    padding: 1rem 0;
    text-align: center;
}
</style>


</head>
<body>

<?php include('navbar.php'); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Our Flavors</h1>

    <!-- Carousel for Flavors -->
    <div id="flavorCarousel" class="carousel slide mb-4" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($products as $index => $product): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="<?php echo $product['image']; ?>" class="d-block w-100" alt="<?php echo $product['name']; ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $product['name']; ?></h5>
                        <p><?php echo substr($product['description'], 0, 50); ?>...</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#flavorCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#flavorCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Flavors Section -->
    <div class="row">
        <?php foreach ($products as $product): 
            $discounted_price = $product['price'] * 0.7; // 30% off
        ?>
            <div class="col-md-3 mb-4">
                <div class="card position-relative">
                    <!-- New Year Sale Badge -->
                    <div class="sale-badge">New Year Sale!</div>
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo substr($product['description'], 0, 100); ?>...</p>
                        <p class="card-text">
                            <span class="text-decoration-line-through text-muted">$<?php echo number_format($product['price'], 2); ?></span><br>
                            <span class="text-success">$<?php echo number_format($discounted_price, 2); ?></span>
                        </p>
                        <div class="d-flex justify-content-center">
                            <!-- Add to Cart Button with Icon -->
                            <button class="btn btn-primary add-to-cart" data-id="<?php echo $product['id']; ?>" data-name="<?php echo $product['name']; ?>" data-price="<?php echo $discounted_price; ?>" data-image="<?php echo $product['image']; ?>">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <!-- View Details Button with Icon -->
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div> 

<footer class="py-4 mt-3">
    <div class="container text-center">
        <div class="d-flex justify-content-center align-items-center social-icons mt-3">
            <a href="https://www.instagram.com/hat_pods" target="_blank" class="mx-3 d-flex align-items-center">
                <i class="fab fa-instagram fa-2x"></i>
                <span class="ml-2">hat_pods</span>
            </a>
            <a href="https://www.facebook.com/hat_pods" target="_blank" class="mx-3 d-flex align-items-center">
                <i class="fab fa-facebook fa-2x"></i>
                <span class="ml-2">hat_pods</span>
            </a>
            <a href="mailto:dummy@gmail.com" class="mx-3 d-flex align-items-center">
                <i class="fas fa-envelope fa-2x"></i>
                <span class="ml-2">hatpods@gmail.com</span>
            </a>
        </div>
        <div class="contact-info mt-4">
            <p>Address: Szabist 100 , Karachi, Pakistan</p>
        </div>
        <p>&copy; 2024 E-commerce. All Rights Reserved @HAT.</p>
    </div>
</footer>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {
    $(".add-to-cart").click(function () {
        const productId = $(this).data("id");
        const productName = $(this).data("name");
        const productPrice = $(this).data("price");
        const productImage = $(this).data("image");

        $.ajax({
            url: "cart.php",
            method: "POST",
            data: {
                action: "add_to_cart",
                product_id: productId,
                quantity: 1
            },
            success: function (response) {
                alert(productName + " has been added to the cart!");
                $("#cart-count").text(response.cart_count);
            },
            error: function () {
                alert("Failed to add the product to the cart. Please try again.");
            }
        });
    });
});
</script>

</body>
</html>
