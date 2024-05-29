<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .order-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .order-details {
            margin-bottom: 5px;
        }
       
    </style>
</head>
<body>
    <div class="delivery-staff-container">
        <div class="navbar">
            <div class="logo">
                <a href="http://localhost/E-commerce/delivery-staff/delivery_dash.php">
                    <img src="../images/Logo.png" class="pic" width="125">
                </a>
            </div>
            <nav id="menuItems">
                <ul>
                </ul>
            </nav>
            <div class="setting-sec">
                <a href="http://localhost/E-commerce/Account.php">
                <i class="fa fa-user"></i>
                </a>
                <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>

        <!-- Status filter form -->
        <form action="" method="GET">
            <!-- <select name="status">
                <option value="all">All Deliveries</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
            </select>
            <button type="submit">Filter</button> -->
            <?php
            require '../DB/db_con.php'; 

            try {
                $sql = "SELECT d.*, o.*, u.first_name, u.last_name, a.street, a.barangay, o.total_price AS total_amount
                        FROM delivery d 
                        INNER JOIN orders o ON d.order_id = o.order_id 
                        INNER JOIN users u ON o.user_id = u.user_id
                        INNER JOIN address a ON u.address_id = a.address_id
                        WHERE d.status != 'verified' AND d.status != 'completed'";

                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $deliveries = $stmt->fetchAll();

                if (count($deliveries) > 0) {
                    echo "<h2>Active Deliveries</h2>";
                    foreach ($deliveries as $delivery) {
                        $address = htmlspecialchars($delivery['street']) . ', ' . htmlspecialchars($delivery['barangay']);
                        $status = htmlspecialchars($delivery['status']);
                        echo "<div class='order-box'>";
                        echo "<div class='order-details delivery-id' style='display:none;'>Delivery ID: " . htmlspecialchars($delivery['delivery_id']) . "</div>";
                        echo "<div class='order-details'>Status: " . $status . "</div>";
                        echo "<div class='order-details'>Order Name: " . htmlspecialchars($delivery['first_name'] . ' ' . $delivery['last_name']) . "</div>";
                        echo "<div class='order-details'>Address: " . $address . "</div>";
                        echo "<div class='order-details'>Total Amount: " . htmlspecialchars($delivery['total_amount']) . "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No active deliveries found.</p>";
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
            ?>

        </form>
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
