<?php
require '../DB/db_con.php';

if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    try {
        $sql = "SELECT * FROM category WHERE category_id = :category_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            die("Category not found");
        }
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid category ID");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $newCategoryName = $_POST['category_name'];

        $sqlUpdate = "UPDATE category SET category_name = :category_name WHERE category_id = :category_id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':category_name', $newCategoryName, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmtUpdate->execute();

        header("Location: category.php");
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
    <title>Edit Category</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
</head>
<style>

.edit-container{
    max-width: 1300px;
    margin: auto;
    padding-left: 25px;
    padding-right: 25px;
    min-height: 60vh;
}
form {
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

label {
    margin-right: 10px; 
}

input {
    flex: 1;
    padding: 6px;
    margin-right: 10px; 
    max-width: 200px;
}

button {
    background-color: #ff523b;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
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
</style>
<body>

    <div class="nav-container">
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
<!-- --end-- -->


<div class="edit-container">
    <h2 style="text-align: center;">Edit Category</h2>
    
    <form method="POST" action="">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" value="<?php echo $category['category_name']; ?>" required>
        
        <button type="submit"><i class="fa fa-save"></i>Update</button>
    </form>
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