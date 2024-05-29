<?php
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

require '../DB/db_con.php';
// Pagination settings
$limit = 10; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    $sql = "SELECT products.*, category.category_name, product_variations.discounted_price, 
            product_variations.retail_price, product_variations.variation_type
        FROM products
        INNER JOIN category ON products.category_id = category.category_id
        LEFT JOIN product_variations ON products.product_id = product_variations.product_id
        WHERE products.prod_name LIKE :search
        LIMIT :start, :limit";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total number of products (for pagination)
$totalProducts = $pdo->prepare("SELECT COUNT(*) FROM products WHERE prod_name LIKE :search");
$totalProducts->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$totalProducts->execute();
$totalResults = $totalProducts->fetchColumn();
} catch (PDOException $e) {
die("PDOException: " . $e->getMessage());
} catch (Exception $e) {
die("Error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $("#select_category").change(function () {
            var selectedCategory = $(this).val();

            $.ajax({
                url: 'fetch_products.php',
                type: 'POST',
                data: { category: selectedCategory },
                success: function (response) {
                    $('table tbody').html(response);
                },
                error: function () {
                    alert('Error fetching products.');
                }
            });
        });
    });
</script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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
    .prod-container {
    margin-top: 15rem;
}
    .cat-search-con{
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
        margin-left:70px;
    }
    .btn-add:hover{
        background-color: #2ecc71;
    }
    .btn-close {
        background-color: #cf9292;
        padding: 2px 10px;
    }
    label.search {
        margin-left: 500px;
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
    form.search {
        display: contents;
    }
    select#select_category {
        margin-right: 38%;
    }
    button.btn.btn-sucess {
    background-color: #cf9292;
    color: #080808;
    padding: 8px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    margin-left: 10px;
}
    input.form-control {
        height: 30px;
        width: 18%;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination a {
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
        margin: 0 4px;
    }
    .pagination a.active {
        background-color: #f05d5d;
        color: white;
        border: 1px solid #000;
    }
    .pagination a:hover:not(.active) {
        background-color: #ddd;
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
<div class="prod-container">
    <div class="cat-search-con">
        <!-- <h2 style="text-align: center;">Products</h2> -->
        <a href="http://localhost/E-commerce/admin/add-product.php" class="btn-add"> <i class="fa fa-plus"></i>New</a>
        <label>Category: </label>
        <select class="form-control input-sm" id="select_category">
            <option value="0">ALL</option>
            <?php
            include '../DB/db_con.php';

            $query = "SELECT category_id, category_name FROM category";
            $result = $pdo->query($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
            }
            ?>
        </select>
        <form class="search" method="GET" action="">
            <input type="text"  class="form-control" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-sucess">Search</button>
        </form>
        <a href="http://localhost/E-commerce/admin/admin_dash.php"  class="btn-close" ><i class="fa fa-close"></i> Close</a>
    </div>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Variation Type</th>
            <th>Discounted Price</th>
            <th>Retail Price</th>
            <th>Description</th>
            <th>Expiration Date</th>
            <th>Photo</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['prod_name']; ?></td>
                <!-- <td><?php echo $product['type_code']; ?></td> -->
                <td><?php echo $product['variation_type']; ?></td>
                <td><?php echo $product['discounted_price']; ?></td>
                <td><?php echo $product['retail_price']; ?></td>
                <td><?php echo $product['prod_desc']; ?></td>
                <!-- <td><?php echo $product['category_name']; ?></td> -->
                <!-- <td><?php echo $product['stock']; ?></td> -->
                <td><?php echo $product['expiration_date']; ?></td>
                <td><img src="../images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" style="max-width: 100px; max-height: 100px;"></td>
                <td><a href="http://localhost/E-commerce/admin/edit-prod.php?product_id=<?php echo $product['product_id']; ?>" class="edit-button"><i class="fa fa-edit"></i>Edit</a></td>

            </tr>
        <?php endforeach; ?>
    </table>
    <?php if ($totalResults > 0 && $totalResults > $limit): ?>
    <div class="pagination">
        <?php
        $totalPages = ceil($totalResults / $limit);
        $previous = $page - 1;
        $next = $page + 1;
        ?>
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $previous; ?>&search=<?php echo $search; ?>">Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" <?php if ($page == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $next; ?>&search=<?php echo $search; ?>">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<br>
<br>
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