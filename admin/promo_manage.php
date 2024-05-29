<?php
require '../DB/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $minimumSpend = $_POST['minimum_spend'];
    $discountPercentage = $_POST['discount_percentage'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $sql = "INSERT INTO promo (minimum_spend, discount_percentage, start_date, end_date) VALUES (:minimum_spend, :discount_percentage, :start_date, :end_date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':minimum_spend', $minimumSpend, PDO::PARAM_STR);
    $stmt->bindValue(':discount_percentage', $discountPercentage, PDO::PARAM_STR);
    $stmt->bindValue(':start_date', $startDate, PDO::PARAM_STR);
    $stmt->bindValue(':end_date', $endDate, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: admin_dash.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Promos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
        }
        nav#menuItems ul li a:hover {
            color: red;
        }
        nav#menuItems ul li a.active {
            color: red;
        }
        .container1 {
            background-color: #ddc8c5;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
            margin-top: 10rem;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"], input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 22px);
        }
        button {
            padding: 10px;
            background-color: #cf9292;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 30%;
        }
        button:hover {
            background-color: #2ecc71;
        }
        .icon {
            margin-right: 8px;
        }
        .back-button {
            padding: 10px;
            background-color: #2ecc71;
            border: none;
            border-radius: 4px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        .back-button:hover {
            background-color: #cf9292;
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

    <!-- Flex container to center content -->
    <div class="flex-container">
        <div class="container1">
            <h2>Add New Promo</h2>
            <form method="POST" action="">
                <label for="minimum_spend"><i class="fas fa-money-bill-wave icon"></i>Minimum Spend:</label>
                <input type="text" id="minimum_spend" name="minimum_spend" required>

                <label for="discount_percentage"><i class="fas fa-percent icon"></i>Discount Percentage:</label>
                <input type="text" id="discount_percentage" name="discount_percentage" required>

                <label for="start_date"><i class="fas fa-calendar-alt icon"></i>Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date"><i class="fas fa-calendar-alt icon"></i>End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <button type="submit"><i class="fas fa-plus icon"></i>Add Promo</button>
            </form>
            <!-- <button class="back-button" onclick="window.location.href='admin_dash.php'"><i class="fas fa-arrow-left icon"></i>Back</button> -->
        </div>
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
