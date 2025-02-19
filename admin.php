<?php
session_start();
include('config.php');

$conn = getDbConnection();
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $sql = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$imagePath')";
            if (mysqli_query($conn, $sql)) {
                header("Location: admin.php");
                exit();
            } else {
                die("Error: " . mysqli_error($conn));
            }
        } else {
            die("Error: Failed to move the uploaded file.");
        }
    } else {
        die("Error: No image uploaded or an error occurred during file upload.");
    }
}

if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM products WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CRUD Operations</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* General body styling */
    body {
        background-color: #121212; /* Dark background */
        color: #ffffff; /* Light text */
    }

    /* Navbar styling */
    .navbar {
        background-color: #1e1e1e;
        border-bottom: 1px solid #333;
    }
    .navbar-brand {
    color: #007bff !important; /* Blue color */
    }
    .navbar-brand:hover {
    color: #0056b3 !important; /* Darker blue color on hover */
    }
    .logo {
        max-height: 50px;
    }

    /* Table styling */
    table {
        background-color: #1e1e1e; /* Table background */
        color: #ffffff; /* Table text color */
    }
    table thead {
        background-color: #333; /* Table header background */
    }
    table th {
    color: #007bff; /* Change to blue */
    }
    table td {
        color: #ffffff; /* Table data text color */
    }
    table img {
        width: 70px;
        height: auto;
    }
    table th, table td {
        text-align: center;
        vertical-align: middle;
    }
    table tr:hover {
        background-color: #272727; /* Highlight row on hover */
    }

    /* Form styling */
  
    .form-group label {
    color: #007bff; /* Change label color to blue */
    }

    .form-control {
        background-color: #1e1e1e;
        color: #ffffff;
        border: 1px solid #333;
    }
    .form-control:focus {
        background-color: #1e1e1e;
        color: #ffffff;
        border-color:  #007bff;
        box-shadow: 0 0 5px  #007bff;
    }

    /* Button styling */
    .btn-primary {
    background-color: #007bff; /* Blue color */
    border-color: #007bff;
    color: #ffffff;
    }
   .btn-primary:hover {
    background-color: #0056b3; /* Darker blue color on hover */
    border-color: #0056b3;
    }
    .btn-danger {
        background-color: #ff5252;
        border-color: #ff5252;
        color: #ffffff;
    }
    .btn-danger:hover {
        background-color: #ff1744;
        border-color: #ff1744;
    }
    .btn-info {
    background-color: #007bff; /* Blue color */
    border-color: #007bff;
    color: #ffffff;
    }
    .btn-info:hover {
    background-color: #0056b3; /* Darker blue color on hover */
    border-color: #0056b3;
}

    /* Card styling */
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

    /* Footer styling */
    footer {
        background-color: #1e1e1e;
        color: #ffffff;
    }
</style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="index.php">
        <img src="logo.jpg" alt="Logo" class="logo">
        Home
    </a>
    <div class="ml-auto">
        <a class="nav-link text-white d-flex align-items-center" href="logout.php">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add New Product</h2>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
    </form>

    <hr>
    <h2 class="mt-4">Products</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td>$<?php echo number_format($product['price'], 2); ?></td>
            <td><?php echo substr($product['description'], 0, 100); ?>...</td>
            <td><img src="<?php echo $product['image']; ?>" alt="product image"></td>
            <td>
                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                <a href="admin.php?delete=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
