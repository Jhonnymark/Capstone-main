<?php
require '../DB/db_con.php';
session_start();

if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    try {
        $sql = "SELECT *
        FROM orders
        INNER JOIN orders_details ON orders.order_id = orders_details.order_id
        INNER JOIN products ON orders_details.product_id = products.product_id
        INNER JOIN users ON orders.user_id = users.user_id
        WHERE orders.order_id = :order_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
       .order-container{ 
        min-height: calc(100% - 256px);
       }
       table {
            width: 90%;
            border-collapse: collapse;
            margin: auto;
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        th {
            background-color: #9f7b7b;
            color: Black;
            text-align: center;
        }
        th, td {
            border: 1px solid #767575;
            padding: 8px;
        }
        .btn {
            display: inline-block;
            background-color: #cf9292;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2ecc71;
        }
    </style>
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
            <!-- <img src="../images/profile-icon.png" width="30px" height="30px" class="icon"> -->
            </a>
        <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>

    <div class="order-container">
    <?php if (!empty($orders)) : ?>
        <h2 style="text-align: center;">Order ID: <?php echo $orders[0]['order_id']; ?> - Customer: <?php echo $orders[0]['first_name'] . ' ' . $orders[0]['last_name']; ?></h2>
        <div style="text-align: center; margin-bottom: 20px;">
    <?php endif; ?>
    
    <?php if (empty($orders)) : ?>
        <p style="text-align: center; margin-top: 20px;">No orders found for the selected status.</p>
    <?php else : ?>
              
    <table>
        <tr>
            <th>Product Name</th>
            <th>Name</th>
            <th>Date Ordered</th>
            <th>Total Price</th>
            <!-- <th>Status</th>
            <th>Date Receive</th> -->
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?php echo $order['prod_name']; ?></td>
                <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                <!-- <td><?php echo $order['date_ordered']; ?></td> -->
                <td>
                    <?php 
                        $dateOrdered = new DateTime($order['date_ordered']);
                        echo $dateOrdered->format('F j, Y g:i a');
                    ?>
                </td>
                <td><?php echo $order['total_price']; ?></td>
                <!-- <td><?php echo $order['order_status']; ?></td> -->
                <!-- <td><?php echo $order['order_status'] == 'Completed' ? ($order['date_received'] ?? 'Not received yet') : ''; ?></td> -->
                <!-- <td><?php echo $order['order_status'] == 'Completed' ? ($order['date_received'] ?? 'Not received yet') : 'Not received yet'; ?></td> -->

        <td>
            <form action="update_order.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                <select name="status">
                    <?php if ($order['order_status'] == 'Pending') : ?>
                        <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="ToShip">To Ship</option>
                        <option value="ToReceive">To Receive</option>
                    <?php elseif ($order['order_status'] == 'ToShip') : ?>
                        <option value="ToReceive">To Receive</option>
                        <!-- <option value="Completed">Completed</option> -->
                    <?php elseif ($order['order_status'] == 'ToReceive') : ?>
                        <!-- <option value="Completed">Completed</option> -->
                    <?php endif; ?>
                </select>
                <button type="submit" name="update_order">
                <i class="fa-solid fa-save"></i>
                    <!-- <i class="fa-solid fa-sync-alt"></i>  -->
                </button>
            </form>
            </td>
        </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="generate_receipt.php?order_id=<?php echo $order_id; ?>" class="btn">Generate Receipt</a>
    <?php endif; ?>
</div>
<!--footer-->
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
<!-- js for toggle menu -->
<script>
var menuItems = document.getElementById("menuItems");
    function menutoggle() {
        menuItems.classList.toggle("show");
    }
    
</script>
</html>
</body>