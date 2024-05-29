<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
<style>
    h2 {
        text-align: center;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    form {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        background-color: #ddc8c5;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: solid;
        border-color: crimson;
        margin-bottom: 20px;
    }
    .form-group {
        display: flex;
        margin-bottom: 10px;
    }
   label {
        margin-top: 10px;
        font-weight: bold;
    }
    label,input, textarea, select {
        padding: 8px;
        width: 300px;
        height: 50px;
        margin-top: 20px;
        margin-left: 50px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ff8d8d;
        border-radius: 4px;
    }
    button {
        background-color: #ff523b;
        color: #ffffff;
        padding: 10px 15px;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 0 auto; 
        margin-bottom: 20px;
        display: block;
    }
    button:hover {
        background-color: crimson;
    }
    textarea {
        resize: vertical; 
        min-height: 100px;
        max-height: 200px;
    }
</style>

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
    <h2>Add Product</h2>
    <form method="post" action="http://localhost/E-commerce/admin/product-add.php" enctype="multipart/form-data">
    <div class="form-group">
        <label for="prod_name">Product Name:</label>
        <input type="text" id="prod_name" name="prod_name"  required placeholder="Enter Product Name" style="text-transform: capitalize;"><br>
        <!-- pattern="[A-Za-z][A-Za-z0-9\s]*" -->
    </div>
    <div class="form-group">
        <label for="type_code">Type Code:</label>
        <input type="text" id="type_code" name="type_code" required placeholder="Enter Product Type Code"><br>
    </div>
    <div class="form-group">
        <label for="prod_desc">Product Description:</label>
        <textarea id="prod_desc" name="prod_desc" required style="text-transform: capitalize;"></textarea>
    </div>
    <!-- variation -->
    <div class="form-group">
        <label for="variation_type">Variation Type:</label>
        <input type="text" id="variation_type" name="variation_type[]" required placeholder="Enter Variation Type (e.g., per pcs, per case)">
    </div>
    <div class="form-group">
        <label for="discounted_price">Discounted Price:</label>
        <input type="number" id="discounted_price" name="discounted_price[]" step="0.01" required placeholder="Enter Discounted Price">
    </div>
    <div class="form-group">
        <label for="retail_price">Retail Price:</label>
        <input type="number" id="retail_price" name="retail_price[]" step="0.01" required placeholder="Enter Retail Price">
    </div>
    <!-- end -->
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required placeholder="Enter Product Stock"><br>  
    </div>
    <div class="form-group">
        <label for="category">Product Category:</label>
        <select id="category" name="category" required>
        <option value="" selected>- Select -</option>
            <?php
            include '../DB/db_con.php';

            $query = "SELECT category_id, category_name FROM category";
            $result = $pdo->query($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
            }
            ?>
        </select>
        </div>
        <div class="form-group">
            <label for="expiration_date">Expiration Date:</label>
            <input type="date" id="expiration_date" name="expiration_date">
        </div>
        <div class="form-group">
            <label for="photo" class="col-sm-1 control-label">Photo</label>
        <div class="col-sm-5">
            <input type="file" id="photo" name="photo">
        </div>
        </div>
        <button type="submit"><i class="fa fa-save"></i>ADD</button>
    </form>
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
