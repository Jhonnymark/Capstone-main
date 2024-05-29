<?php
require '../DB/db_con.php';

try {
    $sql = "SELECT * FROM category";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     // Pagination settings
//     $perPage = 10;
//     $totalCategories = count($categories);

//   // Calculate total number of pages
//   $pages = ceil($totalCategories / $perPage);

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
    <title>Category</title>
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
    .cat-container {
    margin-top: 12rem;
}
    .btn-con{
        position: fixed;
        top: 7rem;
        right: 0;
        left: 0;
        background: #d9d9d9;
        border-top: 1px solid black;
        padding: 10px;
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
        margin-bottom: 20px;
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
    .edit-button,
    .btn-add, .btn-close {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
    }
    .edit-button {
        background-color: #cf9292;
        color: white;
    }
    .edit-button:hover {
        background-color: #2ecc71;
    }
    .btn-add{
        background-color: #cf9292;
        padding: 2px 10px;
        margin-left: 70px;
    }
    .btn-add:hover{
        background-color: #2ecc71;
    }
    .btn-close {
        background-color: #cf9292;
        padding: 2px 10px;
        margin-left: 77%;
    }
    .btn-close:hover {
        background-color: #2ecc71;
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
    
</style>
</head>
<body>

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

<div class="cat-container">
    <div class= "btn-con">
        <!-- <h2 style="text-align: center;">Categories</h2> -->
        <a href="http://localhost/E-commerce/admin/add-cat.php" class="btn-add"> <i class="fa fa-plus"></i>New</a>
        <a href="http://localhost/E-commerce/admin/admin_dash.php"  class="btn-close" ><i class="fa fa-close"></i> Close</a>
    </div>   
    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?php echo $category['category_id']; ?></td>
                <td><?php echo $category['category_name']; ?></td>
                <td><a href="edit-cat.php?category_id=<?php echo $category['category_id']; ?>" class="edit-button"><i class="fa fa-edit"></i>Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="col-md-12">
        <!-- <div class="well well-sm">
            <div class="paginate">
                <?php for ($x = 1; $x <= $pages; $x++) : ?>
                    <ul class="pagination">
                        <li>
                            <a href="?page=<?php echo $x; ?>&per-page=<?php echo $perPage; ?>">
                                <?php echo $x; ?>
                            </a>
                        </li>
                    </ul>
                <?php endfor; ?>
            </div>
        </div>
    </div> -->
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