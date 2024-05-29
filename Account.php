<?php
// session_start();
require 'count-cart.php';

if (!isset($_SESSION['username'])) {
    header("location:login_form.php");
    exit();
}

include('DB/db_con.php');

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$sql = "SELECT users.first_name, users.last_name, users.phone_number, users.username, users.role, users.email, address.street, address.barangay 
        FROM users 
        LEFT JOIN address ON users.address_id = address.address_id 
        WHERE users.username = :username";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
    
</head>
<body>

    <div class="navbar">
        <div class="logo">
            <img src="images/Logo.png" width="125">
        </div>
        <nav id="menuItems">
        <ul>
            <?php
            $dashboardLink = '';
            switch ($_SESSION['role']) {
                case 'Admin':
                    $dashboardLink = 'admin/admin_dash.php';
                    break;
                case 'Staff':
                    $dashboardLink = 'staff/staff_dash.php';
                    break;
                case 'Delivery_personnel':
                    $dashboardLink = 'delivery_dash.php';
                    break;
                case 'Customer':
                    $dashboardLink = 'customer_dash.php';
                    break;
                default:
                    $dashboardLink = 'index.php';
                    break;
            }
            ?>
            <li><a href="<?php echo $dashboardLink; ?>">Home</a></li>
            <li><a href="about.php">About</a></li>
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
    <!-- <header>
    </header> -->
<!-- --end-- -->
<div class= "main-con">
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
                    <a href="http://localhost/E-commerce/my_orders.php">My Orders</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-account-info">
        <h2 style="text-align:center">Welcome, <?php echo $_SESSION['username'] ?? 'Guest'; ?></h2>
        <table class= "tbl-info">
            <tr class="account-info">
                <td>First Name:</td>
                <td><?php echo $user['first_name']; ?></td>
            </tr>
            <tr class="account-info">
                <td>Last Name:</td>
                <td><?php echo $user['last_name']; ?></td>
            </tr>
            <tr class="account-info">
                <td>Username:</td>
                <td><?php echo isset($user['username']) ? $user['username'] : ''; ?></td>

            </tr>
            <tr class="account-info">
                <td>Email:</td>
                <td><?php echo $user['email']; ?></td>
            </tr>
            <tr class="account-info">
                <td>Phone Number:</td>
                <td><?php echo $user['phone_number']; ?></td>
            </tr>
            <tr class="account-info">
                <td>Role:</td>
                <td><?php echo $user['role']; ?></td>
            </tr>
            <tr class="account-info">
                <td>Street:</td>
                <td><?php echo $user['street']; ?></td>
            </tr>
            <tr class="account-info">
                <td>Barangay:</td>
                <td><?php echo $user['barangay']; ?></td>
            </tr>
        </table>
        <div class="button">
            <a href="http://localhost/E-commerce/Edit-info.php" class="edit-button"><i class="fa fa-edit"></i>Edit</a>
            <a href="htt p://localhost/E-commerce/change-pass.php" class="change-button"><i class="fa fa-edit"></i>Change Password</a>   
        </div>
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
