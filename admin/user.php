<?php
require '../DB/db_con.php';
try {
    $sql = "SELECT *
            FROM users 
            INNER JOIN address ON users.address_id = address.address_id
            WHERE role IN ('Retail_customer', 'Wholesale_Customer')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("PDOException: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
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
    .user-container {
        min-height: calc(100% - 255px);
        margin-top: 10rem;
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
    .edit-button, .btn-close {
        display: table-cell;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
    }
    /* .edit-button {
        background-color: #ff523b;
        color: white;
    }
    .edit-button:hover {
        background-color: crimson;
    } */
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
    .row1{
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }
    .icon {
        font-size: 48px;
        color: black;
        margin-left: 60px;
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
            <!-- <li><a href="http://localhost/E-commerce/Account.php">Account</a></li> -->
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

<div class="user-container">
    <!-- <h2 style="text-align: center;">Users</h2> -->
    <!-- <a href="http://localhost/E-commerce/admin/admin_dash.php"  class="btn-close" ><i class="fa fa-close"></i> Close</a> -->
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Street</th>
            <th>Barangay</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $customer) : ?>
            <tr>
            <td><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></td>
                <td><?php echo $customer['email']; ?></td>
                <td><?php echo $customer['phone_number']; ?></td>
                <td><?php echo $customer['street']; ?></td>
                <td><?php echo $customer['barangay']; ?></td>
                <td><?php echo $customer['role']; ?></td>
                <td>
                    <a href="http://localhost/E-commerce/admin/view_user_order.php?user_id=<?php echo $customer['user_id']; ?>" class="edit-button" style="margin-right: 10px;"> 
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="http://localhost/E-commerce/admin/upgrade_user.php?user_id=<?php echo $customer['user_id']; ?>" class="edit-button">
                        <i class="fas fa-arrow-alt-circle-up"></i>
                    </a>
                </td>
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