<?php
// Include database connection
include('config.php');
$conn = getDbConnection();

// Check if a search query is provided
if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']); // Sanitize user input

    // Prepare the SQL query to search in the products table
    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm); // Bind parameters to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "";
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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

        .btn-primary, .btn-info {
            background-color: #bb86fc;
            border-color: #bb86fc;
        }

        .btn-primary:hover, .btn-info:hover {
            background-color: #985eff;
            border-color: #985eff;
        }

        footer {
            background-color: #1e1e1e;
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
        }

        .alert {
            background-color: #333;
            color: #bb86fc;
            border-color: #bb86fc;
        }
    </style>
</head>
<body>
    <!-- Include your navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h2>Search Results for "<?php echo $query; ?>"</h2>
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img class="card-img-top" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text">
                                    <?php echo substr($row['description'], 0, 100); ?>...
                                </p>
                                <p class="card-text"><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                                <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View Product</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="alert alert-warning">No products found matching your search.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
