<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
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
body, h1, h2, h3, p, ul, li {
    margin: 0;
    padding: 0;
}
i.fa-solid.fa-user {
    font-size:28px;
    margin-bottom: 8px;
    margin-right: 10px;
    color: black;
}
.small-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
}
h1, h2, h3 {
    color: #333;
}
p {
    color: #555;
    line-height: 1.6;
}
ul {
    list-style-type: none;
    padding: 0;
}
ul li {
    margin-bottom: 8px;
}
ul li strong {
    font-weight: bold;
}
a:hover {
    text-decoration: underline;
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
                <img src="../images/Logo.png" width="125">
            </div>
            <nav>
            <ul id="MenuItems">
            <?php
            $dashboardLink = '';
            if (isset($_SESSION['role'])) {
                switch ($_SESSION['role']) {
                    case 'Admin':
                        $dashboardLink = 'http://localhost/E-commerce/admin/admin_dash.php';
                        break;
                    case 'Staff':
                        $dashboardLink = 'staff_dash.php';
                        break;
                    case 'Delivery_personnel':
                        $dashboardLink = 'delivery_dash.php';
                        break;
                    case 'Customer':
                        $dashboardLink = 'http://localhost/E-commerce/customer_dash.php';
                        break;
                    default:
                        $dashboardLink = 'http://localhost/E-commerce/index.php';
                        break;
                }
            } else {
                $dashboardLink = 'http://localhost/E-commerce/index.php';
            }
            ?>
                <li><a href="<?php echo $dashboardLink; ?>">Dashboards</a></li>
                <li><a href="">Manage Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/products.php">Manage Products</a></li>
                <li><a href="http://localhost/E-commerce/admin/category.php">Manage Categories</a></li>
                <li><a href="http://localhost/E-commerce/admin/user.php">Manage Users</a></li>
                <li><a href="about.php">About</a></li>
                <!-- <li><a href="http://localhost/E-commerce/Account.php">Account</a></li> -->
            </ul>
            </nav>
            <a href="http://localhost/E-commerce/Account.php">
            <i class="fa-solid fa-user"></i>
            <!-- <img src="../images/profile-icon.png" width="30px" height="30px" class="icon"> -->
            </a>
            <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div>
    <header>
    </header>

<div class="small-container">
    <h1>About Us</h1>

    <h2>Welcome to Our Website</h2>

    <p>4M Minimart, a family business established in 2013 and initially managed by Ginalyn 
Garis, has evolved into a thriving retail store catering to the essential needs of its community. <br>
Recognizing the potential for further contribution, owners Marivic and Michael decided to embark 
on a new venture—entering the wholesale business. <br>This expansion aims to provide a broader 
range of products to retail stores in their neighborhood and neighboring areas</p>

    <h2>Our Mission</h2>
    <h3>High Quality Product</h3>
    <p>Our business is to offer high quality food products and outstanding services.</p>

    <h3>Provide Best Quality</h3>
    <p>Our wish to provide the best quality is a continuous process that involves a rigorous purchasing process.</p>
    
    <ul>
        <li><strong>Marivic Alulod</strong> - Business Owner</li>
        <li><strong>Filipina</strong> -Employee/seller</li>
        <li><strong>Mary Grace</strong> -Employee/seller</li>
        <li><strong>Susan</strong> -Employee/seller</li>
        <li><strong>Lino</strong> - Delivery Personnel</li>
    </ul>
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
