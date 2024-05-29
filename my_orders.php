
<?php
// session_start();

require 'DB/db_con.php';
require 'count-cart.php';

//echo "SELECT * FROM orders WHERE user_id = ".$_SESSION['user_id'];
$status = ''; // Default value for status
if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    $query = $pdo->prepare("SELECT product_id, prod_name, prod_price, photo, stock 
                            FROM products WHERE category_id = ?");
    $query->execute([$cart_id]);
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
}
$total = $pdo->query("SELECT FOUND_ROWS() as total")->fetch()['total'];

if (isset($_GET['status'])) {
    $status = $_GET['status'];
   
    if ($status === "to_ship") {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND order_status IN ('To Ship')");
        $stmt->execute([$_SESSION['user_id']]);
    } else if ($status === "to_receive") {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND order_status IN ('To Receive')");
        $stmt->execute([$_SESSION['user_id']]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND order_status = ?");
        $stmt->execute([$_SESSION['user_id'], $status]);
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
    <style>
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
    .order-wrapper {
        margin-top: 7rem;
    }
    .status {
        position: fixed;
        top: 6rem;
        right: 0;
        left: 0;
        background: #d9d9d9;
        padding: 10px;
        border-top: 1px solid black;
    }
    .order {
        margin-top: 5rem;
    }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="images/Logo.png" width="125">
        </div>
        <nav id="menuItems">
            <ul>
                <li><a href="customer_dash.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="my_orders.php">My Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
                <!-- <form method="post" action="search.php" class= "search">
                    <input type="search" class="form-control" name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" placeholder="Search here..." required=""/>
                    <button type="submit" class="btn btn-success" name="search">Search</button>
                </form> -->
                <!-- <form class="search" method="GET" action="">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
                    <button type="submit">Search</button>
                </form> -->
            </ul>
        </nav>
        <div class="setting-sec">
            <!-- <a href="http://localhost/E-commerce/Account.php">
            <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
            </a> -->   
            <div class="cart-sec">
                <a href="http://localhost/E-commerce/cart-view.php">
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                    <img src="images/cart.png" width="30px" height="30px">
                </a>
            </div>
                <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
    <!-- Navigation for order status -->
    <div class="order-wrapper">   
        <div class="order-container">
            <div class="profile-container">
                <?php
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                    if (!empty($username)) {
                        echo '<div class="profile">';
                        echo '<img src="images/account.png" alt="User Photo">';
                        echo '<div class="username">' . $username . '</div>';
                        echo '<div class="logout"><a href="login_form.php">Logout</a></div>';
                        echo '</div>';
                    }
                ?>
                <div class="account">
                    <div class="dropdown">
                        <img src="images/account.png" alt="Account Icon">
                        <span>My Account</span>
                        <div class="dropdown-content">
                            <a href="Account.php"><i class="fa fa-pencil"></i> Edit Profile</a></br>
                            <!-- <a href="Account.php">Profile</a></br> -->
                            <a href="address"><i class="fa-solid fa-location-dot"></i>  Addresses</a></br>
                            <a href="change-pass.php"><i class="fa fa-edit"></i>Change Password</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <img src="images/purchase.png" alt="Purchase Icon">
                        <span>My Purchase</span>
                        <div class="dropdown-content">
                            <a href="my_orders.php">My Orders</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-details">
                <div class="stats">
                    <div class="status">
                        <a class="<?php echo ($status == 'pending') ? 'active' : ''; ?>" href="my_orders.php?status=pending">Pending</a> |
                        <a class="<?php echo ($status == 'toship') ? 'active' : ''; ?>" href="my_orders.php?status=toship">To Ship</a> |
                        <a class="<?php echo ($status == 'toreceive') ? 'active' : ''; ?>" href="my_orders.php?status=toreceive">To Receive</a> |
                        <a class="<?php echo ($status == 'completed') ? 'active' : ''; ?>" href="my_orders.php?status=completed">Completed</a>
                    </div>

                </div>
                <?php if (empty($orders)) : ?>
                        <div> <p style="display: flex; justify-content: center;  margin-top: 20px; font-weight: bold;">No orders found for the selected status.</p></div>
                <?php else : ?>
                <?php
                    foreach ($orders as $order) {
                    echo '<div class="order">';
                        echo "Date Ordered: " . $order['date_ordered'] . "<br>";

                        $stmt = $pdo->prepare("SELECT orders_details.*, products.prod_name, products.photo 
                                                FROM orders_details 
                                                JOIN products
                                                ON orders_details.product_id = products.product_id 
                                                WHERE orders_details.order_id = ?");
                        $stmt->execute([$order['order_id']]);
                        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        // foreach ($orderDetails as $detail) {
                        //     echo '<div class="order-item">';
                        //     echo '<img src="images/upload/' . $detail['photo'] . '" alt="Product Photo">';
                        //     echo '<div class="product-details">';
                        //     echo '<div class="product-name">' . $detail['prod_name'] . ' <br> Qty: ' . $detail['quantity'] . '</div>';
                        //     // echo '<div class="product-name">' . $detail['prod_name'] . '</div>';
                        //     // echo '<div class="product-qty">Qty: ' . $detail['quantity'] . '</div>';
                        //     echo '<div class="product-price">Price:  ₱' . $detail['price'] . '</div>';
                        //     echo '</div>';
                        //     echo '<div class="subtotal"> ₱' . ($detail['quantity'] * $detail['price']) . '</div>';
                        //     echo '</div>';
                        // }
                        
                        $totalPrice = 0;
                        foreach ($orderDetails as $detail) {
                            $totalPrice += $detail['quantity'] * $detail['price'];
                        }
                        
                        // Calculate delivery fee for this order
                        $deliveryFee = 0;
                        if ($order['delivery_option'] === 'delivery' && $totalPrice < 2000) {
                            $deliveryFee = 50.00;
                        }

                        // Calculate the total price including delivery fee for this order
                        $totalPrice += $deliveryFee;

                        foreach ($orderDetails as $detail) {
                            echo '<div class="order-item">';
                            echo '<img src="images/upload/' . $detail['photo'] . '" alt="Product Photo">';
                            echo '<div class="product-details">';
                            echo '<div class="product-name">' . $detail['prod_name'] . ' <br> Qty: ' . $detail['quantity'] . '</div>';
                            echo '<div class="product-price">Price:  ₱' . $detail['price'] . '</div>';
                            echo '</div>';
                            echo '<div class="subtotal"> ₱' . ($detail['quantity'] * $detail['price']) . '</div>';
                            echo '</div>';
                        }
                        
                        // Display delivery fee
                        echo '<div class="delivery-fee" >Delivery Fee: ₱' . number_format($deliveryFee, 2) . '</div>';
                        echo '<div class="total-price">Total:  ₱' . number_format($totalPrice, 2) . '</div>'; 
                        
                        if ($status === "toreceive") {
                            echo '<form action="order_received.php" method="post">';
                            echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
                            echo '<button type="submit" name="order_received">Order Received</button>';
                            echo '</form>';
                        }
                        if ($order['order_status'] === "Completed") {
                            // Check if rating and feedback exist
                            $stmt = $pdo->prepare("SELECT * FROM ratings WHERE order_id = ?");
                            $stmt->execute([$order['order_id']]);
                            $ratingInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($ratingInfo) {
                                // Display the rating and feedback
                                echo '<div class="rating">';
                                echo 'Rating: ' . $ratingInfo['rating_value'] . ' Stars<br>';
                                echo 'Feedback: ' . htmlspecialchars($ratingInfo['feedback']) . '<br>';
                                echo '</div>';
                            } else {
                                // Display a form to submit rating and feedback
                                echo '<form action="submit_rating.php" method="post">';
                                echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
                                echo '<label for="rating">Rating:</label>';
                                echo '<select name="rating" id="rating">';
                                echo '<option value="5">5 Stars</option>';
                                echo '<option value="4">4 Stars</option>';
                                echo '<option value="3">3 Stars</option>';
                                echo '<option value="2">2 Stars</option>';
                                echo '<option value="1">1 Star</option>';
                                echo '</select>';
                                echo '<label for="feedback">Feedback:</label>';
                                echo '<textarea name="feedback" id="feedback" rows="4" cols="50"></textarea>';
                                echo '<button type="submit" name="submit_rating">Submit Rating</button>';
                                echo '</form>';
                            }
                        }
                    echo '</div>'; 
                        
                        // echo "<hr>"; // Add a horizontal rule between orders
                    }
                ?>
            </div>
        </div>
        <?php endif; ?>     
    </div>
</div>
    
    <!--footer-->

    <footer>
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <img src="images/logo2.png" width="100px" height="60px">
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
        // MenuItems.style.maxHeight = "0px";
        // function menutoggle() {
        //     if (MenuItems.style.maxHeight === "0px") {
        //         MenuItems.style.maxHeight = "200px";
        //     } else {
        //         MenuItems.style.maxHeight = "0px";
        //     }
        // }
        
    </script>
</body>
</html>