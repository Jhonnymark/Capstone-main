
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
            a{
        text-decoration: none;
        color: #000000;
        font-weight: bold;
    }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        form {
            max-width: 30%;
            margin: 0 auto;
            background-color: #ddc8c5;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: solid;
            border-color: crimson;
            margin-bottom: 20px;
            text-align: center;
        }
        .cat-con {
            min-height: 50vh;
            margin-top: 5rem;
        }
        label {
            display: inline-block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
            width: 300px; 
        }
        input, select {
            width: 300px;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            /* background-color: transparent; */
        }
        button {
            background-color: crimson;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .fa {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale
    }
    </style>
</head>

<body>
<div class="header">
    <div class="container">
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
    </div>
</div>
<div class="cat-con">
    <h2>Add New Category</h2>
    <form method="post" action="caterory-add.php">
        <div class="form-group add row">
            <div class="col-6">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" pattern="[A-Za-z\s]+" required placeholder="Enter Category Name"><br>
            </div> 
        </div>
        <button type="submit"><i class="fa fa-save"></i>ADD</button>
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
</body>

</html>