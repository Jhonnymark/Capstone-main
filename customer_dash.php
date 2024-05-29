<?php
require 'DB/db_con.php';
require 'count-cart.php';

// Pagination settings
$limit = 12; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search and category functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_id = isset($_GET['category']) ? $_GET['category'] : 0;

// Prepare the query based on search and category filters
$query = "SELECT products.product_id, products.prod_name, 
            product_variations.discounted_price, product_variations.retail_price, 
            products.photo, products.stock, product_variations.variation_type
        FROM products 
        LEFT JOIN product_variations ON products.product_id = product_variations.product_id 
        WHERE products.prod_name LIKE :search ";
if ($category_id != 0) {
    $query .= "AND category_id = :category_id ";
}
$query .= "LIMIT :start, :limit";

$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
if ($category_id != 0) {
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
}
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total results for pagination
$countQuery = "SELECT COUNT(*) FROM products WHERE prod_name LIKE :search ";
if ($category_id != 0) {
    $countQuery .= "AND category_id = :category_id";
}
$totalProducts = $pdo->prepare($countQuery);
$totalProducts->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
if ($category_id != 0) {
    $totalProducts->bindValue(':category_id', $category_id, PDO::PARAM_INT);
}
$totalProducts->execute();
$totalResults = $totalProducts->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4M Online Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
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
        .category-head {
            margin-top: 7rem;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            background: #d9d9d9;
            border-top: 1px solid black;
        }
        .product-list {
            margin-top: 12rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product-item {
            width: calc(22% - 10px);
            margin: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #cf9292;
            padding: 10px;
            border-radius: 5px;
            min-width: 240px;
        }
        #categoryItems {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        img.prod-img {
            max-width: 150px;
            max-height: 150px;
            display: block;
            margin: 0 auto;
        }
        h3 {
            border-bottom: 1px solid red;
        }
        a {
            text-decoration: none;
            color: #000000;
            font-weight: bold;
        }
        p {
            font-size: 14px;
        }
        @media only screen and (max-width: 500px) {
            .category-head {
                display: flex;
                flex-direction: column;
            }
            form.search {
                margin-top: 20px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#category-select").change(function () {
                var selectedCategory = $(this).val();
                var search = $("input[name='search']").val();
                window.location.href = "?category=" + selectedCategory + "&search=" + search;
            });
        });

        function menutoggle() {
            var menuItems = document.getElementById("menuItems");
            menuItems.classList.toggle("show");
        }
    </script>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/customer_dash.php">
                <img src="images/Logo.png" width="125">
            </a>
        </div>
        <nav id="menuItems">
            <ul>
                <li><a href="customer_dash.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="my_orders.php">My Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
            </ul>
        </nav> 
        <div class="setting-sec">
            <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
            </a>
            <div class="cart-sec">
                <a href="http://localhost/E-commerce/cart-view.php">
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                    <img src="images/cart.png" width="30px" height="30px">
                </a>
            </div>
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
    <!-- <header>
        <div class="col-2">
            <h1>Welcome! <br> to 4M Minimart <br>Online Store</h1>
            <a href="register_form.php" class="btn-shop">Shop Now &#8594;</a>
        </div>
    </header> -->

    <div class="category-head">
        <div class="category-dropdown">
            <label>Product Category: </label>
            <select id="category-select">
                <option value="0">All</option>
                <?php
                $query = "SELECT category_id, category_name FROM category";
                $result = $pdo->query($query);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['category_id'] . '"';
                    if ($category_id == $row['category_id']) {
                        echo ' selected';
                    }
                    echo '>' . $row['category_name'] . '</option>';
                }
                ?>
            </select>
        </div>
        <form class="search" method="GET" action="">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="productList">
        <div id="categoryItems">
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                        <img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" class="prod-img" >
                    </a>
                    <h3 style="text-align: center;  border-bottom: 1px solid red;">
                        <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                            <?php echo $product['prod_name']; ?>
                        </a>
                    </h3>
                    <?php
                    // Check if user is logged in and role is 'Wholesale'
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Wholesale_Customer'):
                    ?>
                    <!-- <p style="text-align: center; font-weight: bold;" >"Avail 3pcs above to get Discounted price"</p> -->
                    <p>Price: ₱ <?php echo number_format($product['discounted_price'], 2); ?></p>
                    <?php else: ?>
                        <p>Price: ₱ <?php echo number_format($product['retail_price'], 2); ?></p>
                    <?php endif; ?>
                    <p>Variation Type: <?php echo ucfirst(str_replace('_', ' ', $product['variation_type'])); ?></p>
                    <p>Stock: <?php echo number_format($product['stock']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
            <?php if ($totalResults > 0 && $totalResults > $limit): ?>
                <div class="pagination">
                    <?php
                        $totalPages = ceil($totalResults / $limit);
                        $previous = $page - 1;
                        $next = $page + 1;
                    ?>
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $previous; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>">Previous</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>" <?php if ($page == $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $next; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>">Next</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

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

    <script>
        function showCategory(categoryId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("categoryItems").innerHTML = this.responseText;
                }
            };
            xhr.open("POST", "Category_items.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("categoryId=" + categoryId);
        }

        var menuItems = document.getElementById("menuItems");
        function menutoggle() {
            menuItems.classList.toggle("show");
        }
    </script>

</body>
</html>
