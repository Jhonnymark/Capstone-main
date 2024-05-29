<?php
require '../DB/db_con.php';

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    try {
        // $sql = "SELECT * FROM products WHERE product_id = :product_id";
        $sql = "SELECT p.*, pv.discounted_price, pv.retail_price 
        FROM products p 
        LEFT JOIN product_variations pv ON p.product_id = pv.product_id
        WHERE p.product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Product not found");
        }
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid Product ID");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve form data
        $newExpirationDate = $_POST['expiration_date'];
        // Update the expiration date in the database
        $sqlUpdate = "UPDATE products SET expiration_date = :expiration_date WHERE product_id = :product_id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':expiration_date', $newExpirationDate, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmtUpdate->execute();
        // Redirect to products.php after updating
        header("Location: products.php");
        exit();
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $newprod_name = $_POST['prod_name'];
        $newtype_code = $_POST['type_code'];
        $newprod_desc = $_POST['prod_desc'];
        $newstock = $_POST['stock'];


        if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '../images/upload/';
            $newPhotoPath = $uploadDir . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $newPhotoPath);
            
            // Update the photo in the database
            $sqlUpdatePhoto = "UPDATE products SET photo = :photo WHERE product_id = :product_id";
            $stmtUpdatePhoto = $pdo->prepare($sqlUpdatePhoto);
            $stmtUpdatePhoto->bindParam(':photo', basename($_FILES['photo']['name']), PDO::PARAM_STR);
            $stmtUpdatePhoto->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmtUpdatePhoto->execute();
        }
        
        $sqlUpdate = "UPDATE products SET prod_name = :prod_name, type_code = :type_code, discounted_price = :discounted_price, retail_price = :retail_price, prod_desc = :prod_desc, stock = :stock WHERE product_id = :product_id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':prod_name', $newprod_name, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':type_code', $newtype_code, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':discounted_price', $newdiscounted_price, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':retail_price', $newretail_price, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':prod_desc', $newprod_desc, PDO::PARAM_STR);
        // $stmtUpdate->bindParam(':category_name', $newcategory_name, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':stock', $newstock, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmtUpdate->execute();
   Update the product details in the 'products' table
            // $sqlUpdateProduct = "UPDATE products 
            // SET prod_name = :prod_name, 
            //     type_code = :type_code, 
            //     prod_desc = :prod_desc, 
            //     stock = :stock 
            // WHERE product_id = :product_id";
            //     $stmtUpdateProduct = $pdo->prepare($sqlUpdateProduct);
            //     $stmtUpdateProduct->bindParam(':prod_name', $newprod_name, PDO::PARAM_STR);
            //     $stmtUpdateProduct->bindParam(':type_code', $newtype_code, PDO::PARAM_STR);
            //     $stmtUpdateProduct->bindParam(':prod_desc', $newprod_desc, PDO::PARAM_STR);
            //     $stmtUpdateProduct->bindParam(':stock', $newstock, PDO::PARAM_STR);
            //     $stmtUpdateProduct->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            //     $stmtUpdateProduct->execute();

            //     // Update the variation prices in the 'product_variations' table
            //     $newdiscounted_price = $_POST['discounted_price'];
            //     $newretail_price = $_POST['retail_price'];

            //     $sqlUpdateVariations = "UPDATE product_variations 
            //         SET discounted_price = :discounted_price,
            //             retail_price = :retail_price
            //         WHERE product_id = :product_id";
            //     $stmtUpdateVariations = $pdo->prepare($sqlUpdateVariations);
            //     $stmtUpdateVariations->bindParam(':discounted_price', $newdiscounted_price, PDO::PARAM_STR);
            //     $stmtUpdateVariations->bindParam(':retail_price', $newretail_price, PDO::PARAM_STR);
            //     $stmtUpdateVariations->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            //     $stmtUpdateVariations->execute();

        header("Location: products.php");
        exit();
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
    <title>Edit Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
</head>
<style>

form {
    max-width: 850px;
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
h2 {
    text-align: center;
    margin-bottom: 20px;
    margin-top: 20px;
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
    margin-top: 20px;
    margin-left: 50px;
    margin-right: 15px;
    margin-bottom: 5px;
    box-sizing: border-box;
    border: 1px solid #ff8d8d;
    border-radius: 4px;
    height: 50px;
}

button {
    background-color: #ff523b;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin: 0 auto; 
    margin-bottom: 20px;
    display: block;
}
button :hover{
    background-color: crimson;
}
.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale
}
#photo, img {
    margin-top: 10px;
}
</style>
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
<!-- --end-- -->


<div class="container">
    <h2>Edit Category</h2>
    
    <form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="prod_name">Product Name:</label>
        <input type="text" id="prod_name" name="prod_name" pattern="[A-Za-z\s]+" value="<?php echo $product['prod_name']; ?>"required><br>
    </div>  
    <div class="form-group">
        <label for="type_code">Type Code:</label>
        <input type="text" id="type_code" name="type_code" value="<?php echo $product['type_code']; ?>"required><br>
    </div>
    <div class="form-group">
        <label for="prod_desc">Product Description:</label>
        <textarea id="prod_desc" name="prod_desc" required><?php echo $product['prod_desc']; ?></textarea>
    </div>
    <div class="form-group">
        <label for="prod_price">Discounted Price:</label>
        <input type="number" id="discounted_price" name="discounted_price" step="0.01" value="<?php echo $product['discounted_price']; ?>" required><br>
    </div>
    <div class="form-group">
        <label for="prod_price">Retail Price:</label>
        <input type="number" id="retail_price" name="retail_price" step="0.01" value="<?php echo $product['retail_price']; ?>" required><br>
    </div>
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo $product['stock']; ?>"required><br>
    </div>
    <div class="form-group">
        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date">
    </div>
    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo"> 
        <img src="../images/upload/<?php echo $product['photo']; ?>" alt="Current Photo" width="100">
    </div>
        <button type="submit"><i class="fa fa-save"></i>Update</button>
    </form>
</div>


<!--footer-->
<<footer>
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
</div>
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