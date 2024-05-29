<?php
require '../DB/db_con.php';
session_start();
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    try {
        $sql = "SELECT * FROM orders
        INNER JOIN orders_details ON orders.order_id = orders_details.order_id
        INNER JOIN products ON orders_details.product_id = products.product_id
        WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $user_order = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>User's Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
   <style>
    .user-order-container {
        min-height: calc(100% - 255px);
    }
    a{
        text-decoration: none;
        color: #000000;
        font-weight: bold;
    }
    table {
        width: 90%;
        border-collapse: collapse;
        margin: 20px auto;
    }
    th, td {
        border: 1px solid #767575;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #9f7b7b;
        color: Black;
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
    .edit-button,
    .btn-add, .btn-close {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
    }
    .edit-button {
        background-color: #ff523b;
        color: white;
    }
    .edit-button:hover {
        background-color: crimson;
    }
    .btn-add{
        background-color: #e4b8b8;
        padding: 2px 10px;
    }
    .btn-add:hover{
        background-color: crimson;
    }
    .btn-close {
        background-color: #e4b8b8;
        padding: 2px 10px;
        margin-left: 88%;
    }
    .btn-close:hover {
        background-color: crimson;
    }
    .fa {
        margin-left: 5px;
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale
    }
    .icon {
        font-size: 48px;
        color: black;
        margin-left: 60px;
    }
    .row1{
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }
    
</style>
</head>
<body>

<div class="header">
    <div class="container">
        <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/admin/admin_dash.php">
                <img src="../images/Logo.png" class= "pic" width="125">
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
        <div class="row">
            <div class="col-2">
                
            </div>
    
        </div>
    </div>
</div>

<div class="user-order-container">
    <h2 style="text-align: center;"><?php echo $_SESSION['username'] ?? 'Guest'; ?></h2>
    <a href="http://localhost/E-commerce/admin/admin_dash.php"  class="btn-close" ><i class="fa fa-close"></i> Close</a>
    <table>
    <tr>
            <th>Product Name</th>
            <th>Date Ordered</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Date Recieved</th>
        </tr>
        <?php foreach ($user_order as $order) : ?>
            <tr>
            <td><?php echo $order['prod_name']; ?></td>
            <td><?php echo $order['date_ordered']; ?></td>
            <td><?php echo $order['total_price']; ?></td>
            <td><?php echo $order['order_status']; ?></td>
            <td><?php echo $order['order_status'] == 'Completed' ? ($order['date_received'] ?? 'Not received yet') : 'Not received yet'; ?></td>
            <!-- <td><?php echo $order['date_recieved'] ?? 'Not received yet'; ?></td> -->
            <!-- <td><?php echo $order['date_recieved']; ?></td> -->
            </tr>
        <?php endforeach; ?>
    </table>
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
    // MenuItems.style.maxHeight = "0px";
    // function menutoggle() {
    //     if (MenuItems.style.maxHeight =="0px")
    //     {
    //         MenuItems.style.maxHeight = "300px";
    //     }
    //     else{
    //         MenuItems.style.maxHeight = "0px";
    //     }
    // }
</script>
</html>
</body>