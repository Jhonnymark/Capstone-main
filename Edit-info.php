<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login_form.php");
    exit();
}

include('DB/db_con.php');

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_username = $_POST['username'];
    $new_phone_number = $_POST['phone_number'];

    $sqlUpdate = "UPDATE users SET first_name = :first_name, last_name = :last_name, username = :username, phone_number = :phone_number WHERE user_id = :user_id";
    $stmtsqlUpdate = $pdo->prepare($sqlUpdate);

    if ($stmtsqlUpdate) {
        $stmtsqlUpdate->bindParam(':first_name', $new_first_name);
        $stmtsqlUpdate->bindParam(':last_name', $new_last_name);
        $stmtsqlUpdate->bindParam(':username', $new_username);
        $stmtsqlUpdate->bindParam(':phone_number', $new_phone_number);
        $stmtsqlUpdate->bindParam(':user_id', $_SESSION['user_id']);

        if ($stmtsqlUpdate->execute()) {
            $_SESSION['first_name'] = $new_first_name;
            $_SESSION['last_name'] = $new_last_name;
            $_SESSION['username'] = $new_username;
            $_SESSION['phone_number'] = $new_phone_number;

            echo "Details successfully updated!";
            header("location: http://localhost/E-commerce/Account.php");
            exit();
        } else {
            echo "Error updating details: " . $stmtsqlUpdate->errorInfo()[2];
        }
    }
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Details</title>
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
.container-Change-info {
    display: flex;
    flex-direction: column;
    align-items: center;
}
form {
    margin: 30px;
    padding: 30px;
    border: 1px solid #ccc;
    width: 35%;
}
.input-group {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
}
button {
    display: inline-block;
    color: black;
    padding: 2px 10px;
    border: 1px solid;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    text-decoration: none;
    margin-top: 10px;
    /* margin-right: 32px; */
    margin-left: 130px;
    padding: 5px;
}
button:hover {
    background-color: crimson;
}
.fa {
    margin-left: 5px;
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.container-Change-info {
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
<!-- ----header----- -->
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
                echo '<img src="images/karla.jpg" alt="User Photo">';
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

    <div class="container-Change-info">
        <form action="" method="post">
        <div class="input-group">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" pattern="[A-Za-z\s]+" value="<?php echo $user['first_name']; ?>"required>
        </div>
        <div class="input-group">  
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" pattern="[A-Za-z\s]+" value="<?php echo $user['last_name']; ?>" required>
        </div>
        <div class="input-group">
            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]{10}" value="<?php echo $user['phone_number']; ?>" required >
        </div>
        <div class="input-group"> 
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" pattern="[A-Za-z\s]+" value="<?php echo $user['username']; ?>" required>
        </div>
            <button type="submit"><i class="fa fa-save"></i>Update</button>
        </form>
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
