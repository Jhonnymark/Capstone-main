<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
        .settings-container {
            margin: 20px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgb(2 2 2);
            border-radius: 5px;
        }
        .settings-container h2 {
            margin-bottom: 20px;
        }
        .settings-container label {
            display: block;
            margin-bottom: 10px;
        }
        .settings-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .settings-container button {
            display: inline-block;
            background-color: #cf9292;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .settings-container button:hover {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/admin/admin_dash.php">
                <img src="../images/Logo.png" width="125">
            </a>
        </div>
        <nav id="menuItems">
            <ul>
                <li><a href="http://localhost/E-commerce/admin/admin_dash.php">Dashboards</a></li>
                <li><a href="http://localhost/E-commerce/admin/reports.php">Reports</a></li>
                <li><a href="http://localhost/E-commerce/admin/manage_order.php">Manage Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/products.php">Manage Products</a></li>
                <li><a href="http://localhost/E-commerce/admin/promo.php">Promo</a></li>
                <li><a href="http://localhost/E-commerce/admin/category.php">Manage Categories</a></li>
                <li><a href="http://localhost/E-commerce/admin/user.php">Manage Users</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
            </ul>
        </nav>
        <div class="setting-sec">
            <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
            </a>
            <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>

    <!-- Add the settings form -->
    <div class="settings-container">
        <h2>Shipping Settings</h2>
        <form action="update_settings.php" method="post">
            <label for="shipping_fee">Shipping Fee ($):</label>
            <input type="number" step="0.01" id="shipping_fee" name="shipping_fee" value="<?php echo htmlspecialchars($shippingFee); ?>">

            <label for="min_order_for_free_shipping">Minimum Order Amount for Free Shipping ($):</label>
            <input type="number" step="0.01" id="min_order_for_free_shipping" name="min_order_for_free_shipping" value="<?php echo htmlspecialchars($minOrderForFreeShipping); ?>">

            <button type="submit">Update Settings</button>
        </form>
    </div>

    <!-- Existing code for dashboard -->
    <div class="smallbox-con">
        <!-- Your existing dashboard code -->
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <img src="../images/logo2.png" width="100px" height="60px">
                </div>
                <div class="footer-col-2">
                    <p>&copy; <?php echo date('Y'); ?> 4M Minimart Online Store. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        var menuItems = document.getElementById("menuItems");
        function menutoggle() {
            menuItems.classList.toggle("show");
        }
    </script>
</body>
</html>
