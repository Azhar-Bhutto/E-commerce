<?php
session_start();

// Check if the user wants to log out
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // If confirmed, destroy the session and redirect
    session_destroy();
    header('Location: login.php');
    exit();
} else {
    // If not confirmed, ask the user for confirmation
    echo  '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirm Logout</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark text-white d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <h3>Are you sure you want to logout?</h3>
            <div class="mt-3">
                <a href="logout.php?confirm=yes" class="btn btn-danger">Yes, Logout</a>
                <a href="admin.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </body>
    </html>  ';
}
?>
