<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login_form.php");
    exit();
}

include('DB/db_con.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_SESSION['username'];

    if ($new_password === $confirm_password) {
        $check_query = "SELECT password FROM users WHERE username = :username";
        $stmt_check = $pdo->prepare($check_query);

        if ($stmt_check) {
            $stmt_check->bindParam(':username', $username);
            $stmt_check->execute();
            $user = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $hashed_password = $user['password'];

                if (password_verify($current_password, $hashed_password)) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET password = :new_password WHERE username = :username";
                $stmt_update = $pdo->prepare($update_query);

                    if ($stmt_update) {
                    $stmt_update->bindParam(':new_password', $hashed_new_password);
                    $stmt_update->bindParam(':username', $username);
                    $stmt_update->execute();
                    echo "Password successfully changed!";
                    header("Location: login_form.php");
                    exit();
                } else {
                    echo "Failed to prepare update statement.";
                }
            } else {
                echo "Incorrect current password. Please try again.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Failed to prepare check statement.";
    }
} else {
    echo "New password and confirmation password do not match.";
}
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }
    .navbar{
        display: flex;
        align-items: center;
        padding: 5px;
        border: 5px solid red;
    }
    nav{
        flex: 1;
        text-align: center;
    }
    nav ul{
        display: inline-block;
        list-style-type: none;
        
    }
    nav ul li{
        display: inline-block;
        margin-right: 20px;
        font-size: bold;
    }
    a{
        text-decoration: none;
        color: #000000;
        font-weight: bold;
    } 
    .form-con {
        margin: 30px;
        padding: 30px;
        border: 1px solid #ccc;
    }
    .input-group {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
    }
    .input-group label {
        display: block;
        margin-bottom: 5px;
        margin-right: 10px;
    }
    .input-group input {
        width: 300px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .confirm-button, .back-button {
        display: inline-block;
        /* background-color: #ff523b; */
        color: black;
        padding:  2px 10px;
        border: 1px solid;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        margin-top: 10px;
        margin-right: 20px;
        margin-left: 80px;
    }
    .confirm-button:hover,.back-button:hover {
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
    .container-Change-pass {
        flex: 1;
        margin: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .main-con {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin: 20px;
    }
    .Profile-container {
        width: 250px;
        margin: 30px 15px;
        padding: 20px;
    }
    .profile {
        display: flex;
        align-items: center;
        flex-direction: column;
        margin-bottom: 10px;
    }
    .profile img {
        width: 100px; 
        height: 100px;
    }
    .username {
        font-weight: bold;
        margin-bottom: 5px; 
    }
    .logout {
        text-align: center; 
    }
    .logout a:hover {
        color: red;
    }
    .account {
        display: flex;
        flex-direction: column;
    }
    .dropdown {
        margin-bottom: 10px;
        position: relative;
    }
    .dropdown img {
        width: 20px; 
        margin-right: 5px;
    }
    .dropdown-content {
        display: none;
        border: 1px solid #ccc; 
        border-radius: 5px;
        padding: 10px;
        width: 200px;
    }
    .dropdown:hover .dropdown-content {
        display: block;
        color: red; 
    }
    .dropdown-content a {
        color: black; 
        text-decoration: none; 
        padding: 5px 0; 
    }
    .dropdown-content a:hover {
        color: red; 
    }
    footer {
        border: 5px solid #000000;
    }  
    .footer-col-1 img {
        width: 180px;
        bottom: 20px;
    }
    .footer-col-2{
        text-align: center;
        font-weight: bold;
    }

    .row {
        display: flex; 
        justify-content: space-evenly;
    }

    .menu-icon{
        width: 30px;
        margin-left: 20px;
        display: none;
    }
    /*--media qyuery for menu---*/

@media only screen and (max-width: 800px){
    nav ul{
        position: absolute;
        top: 70px;
        left: 0;
        background: #e4b8b8;
        width: 100%;
        overflow: hidden;
        transition: max-height 0.5s;
    }
    nav ul li{
        display: block;
        margin-right: 50px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    nav ul li a{
        color: #000000;
        font-weight: bold;
    }
    .menu-icon{
        display: block;
        cursor: pointer;
    }
}
    </style>
</head>
<body>

<div class="navbar">
            <div class="logo">
                <img src="images/Logo.png" width="125">
            </div>
            <nav>
            <ul id="MenuItems">
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
            <!-- <a href="http://localhost/E-commerce/Account.php">
            <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
            </a> -->
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div>
        
<!-- --end-- -->
<div class= "main-con">
    <div class="Profile-container">
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
                    <a href="address">Addresses</a></br>
                    <a href="change-pass.php">Change Password</a>
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
    <!-- <div class="container" style="text-align: center;">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    </div> -->

    <div class="container-Change-pass">
        <form class="form-con" action="" method="post">
            <div class="input-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" required placeholder="Enter Your Current Password">
            </div>
            <div class="input-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" pattern="^(?=*[A-Za-z])(?=*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" required placeholder="Enter Your New Password">
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" required placeholder="Confirm New Password">
            </div>
            <!-- <button type="submit" class="confirm-button"><i class="fa fa-check"></i> Confirm</button> -->
            <a href="http://localhost/E-commerce/login_form.php" class="confirm-button"><i class="fa fa-check"></i> Confirm</a>
            <a href="http://localhost/E-commerce/account.php" class="back-button"><i class="fa fa-chevron-left"></i> Back</a>
        </form>
    </div>

</div>
<!--footer-->

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
    var MenuItems = document.getElementById("MenuItems");
    
    MenuItems.style.maxHeight = "0px";

    function menutoggle() {
        if (MenuItems.style.maxHeight =="0px")
        {
            MenuItems.style.maxHeight = "300px";
        }
        else{
            MenuItems.style.maxHeight = "0px";
        }
    }
</script>
</html>
</body>
