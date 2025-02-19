<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Hamburger Menu Icon -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fa-xs"></i> <!-- Small Hamburger Icon -->
        </button>

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
         <img src="logo.jpg" alt="Logo" class="navbar-logo" style="height: 30px; margin-right: 10px;"> <!-- Adjust logo height -->
         <span class="navbar-text">Flavors by HAT</span>
         </a>



        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Links -->
            <ul class="navbar-nav me-auto">
                <?php
                $isAdminLoggedIn = isset($_SESSION['admin_logged_in']);
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $isAdminLoggedIn ? 'admin.php' : 'login.php'; ?>">Seller Dashboard</a>
                </li>
            </ul>

            <!-- Search Bar -->
            <form class="d-flex mx-auto" method="GET" action="search.php" style="flex: 1; max-width: 600px;">
    <input class="form-control" type="search" name="query" placeholder="Search for flavors, products..." aria-label="Search" style="background-color: #333; color: #fff; border: 1px solid #555;">
    <button class="btn btn-outline-primary ml-2" type="submit" style="border-color: #007bff; color: #007bff; background-color: transparent;">
        <i class="fas fa-search"></i>
    </button>
</form>


            <!-- Collapsible Items -->
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Logout Option in Hamburger Menu -->
                <li class="nav-item d-lg-none"> <!-- Logout visible only in hamburger menu -->
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>

                <!-- Cart Icon -->
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-pill badge-primary"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
                    </a>
                </li>

                <!-- Logout Option for Large Screens -->
                <li class="nav-item d-none d-lg-block"> <!-- Logout visible only on large screens -->
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
