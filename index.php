<?php
require 'DB/db_con.php';

// $query = $pdo->prepare("SELECT product_id, prod_name, prod_price, photo, stock FROM products");
// $query->execute();
// $products = $query->fetchAll(PDO::FETCH_ASSOC);

// Pagination settings
$limit = 12; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;



$search = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $pdo->prepare("SELECT products.product_id, products.prod_name, 
                                product_variations.discounted_price, product_variations.retail_price, 
                                products.photo, products.stock, product_variations.variation_type
                        FROM products 
                        LEFT JOIN product_variations ON products.product_id = product_variations.product_id 
                        WHERE products.prod_name LIKE :search 
                        LIMIT :start, :limit");
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalProducts = $pdo->prepare("SELECT COUNT(*) FROM products WHERE prod_name LIKE :search");
    $totalProducts->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $totalProducts->execute();
    $totalResults = $totalProducts->fetchColumn();

if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    $query = $pdo->prepare("SELECT product_id, prod_name, discounted_price, retail_price, photo, stock FROM products WHERE category_id = ?");
    $query->execute([$cart_id]);
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
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
                url: 'fetch-prod.php',
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

        }
    );
</script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4M E-Commerce Homepage</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
    
<style>
    .product-list{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .product-item{
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
    img.prod-img {';
        max-width: 150px;
        max-height: 150px;
        display: block;
        margin: 0 auto; 
    }
    h3{
        border-bottom: 1px solid red;
    }
    a{
        text-decoration: none;
        color: #000000;
        font-weight: bold;
    }
    p{
        font-size: 14px;
    }
@media only screen and (max-width: 500px){
    .category-head {
        display: flex;
        flex-direction: column;
    }
    form.search {
        margin-top: 20px;
    }
}
    </style>
</head>
<body>
<div class="navbar">
    <div class="logo">
        <a href="index.php">
            <img src="images/Logo.png" width="125">
        </a>
    </div>
    <nav id="menuItems">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login_form.php">Products</a></li>
            <li><a href="login_form.php">My Orders</a></li>
            <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
        </ul>
    </nav>

    <div class="setting-sec">
        <!-- <a href="http://localhost/E-commerce/Account.php">
            <i class="fa-solid fa-user"></i>
        <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
        </a> -->
        <div class="cart-sec">
            <a href="http://localhost/E-commerce/cart-view.php">
                <!-- <span class="cart-count"><?php echo $cart_count; ?></span> -->
                <img src="images/cart.png" width="30px" height="30px">
            </a>
        </div>
        <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div>
</div>
<header>
    <div class="col-2">
        <h1>Welcome! <br> to 4M Minimart <br>Online Store</h1>
        <a href="register_form.php" class="btn-shop">Shop Now &#8594;</a>
    </div>
</header>

    <!-- <?php if (empty($search)): ?> -->
<!---- featured Categories ----->
<!-- <div class="categories">
    <div class="small-container">
        <div class="row">
            <div class="col-3">
            <img src="images/mega.jpg">
            </div>
            <div class="col-3">
                <img src="images/luckyme.jpg">
            </div>
            <div class="col-3">
                <img src="images/lollipop.jpg">
            </div>
        </div>
    </div>
</div> -->

<!---- featured Products ----->
<!-- <div class="featured">
    <div class="small-container">
        <h2 class="title">Fetured Products</h2>
        <div class="row">
            <div class="col-4">
                <img src="images/mega.jpg">
                <h4>Mega</h4>
                <p>Php 25.00</p>
            </div>
            <div class="col-4">
                <img src="images/luckyme.jpg">
                <h4>Lucky Me</h4>
                <p>Php 10.50</p>
            </div>
            <div class="col-4">
                <img src="images/lollipop.jpg">
                <h4>Lollipop</h4>
                <p>Php 25.00</p>
            </div> 
            <div class="col-4">
                <img src="images/rebisco.jpg">
                <h4>Rebisco</h4>
                <p>Php 50.00</p>
            </div>
        </div>

        <h2 class="title">Latest Products</h2>
        <div class="row">
            <div class="col-4">
                <img src="images/mega.jpg">
                <h4>Mega</h4>
                <p>Php 25.00</p>
            </div>
            <div class="col-4">
                <img src="images/luckyme.jpg">
                <h4>Lucky Me</h4>
                <p>Php 10.50</p>
            </div>
            <div class="col-4">
                <img src="images/lollipop.jpg">
                <h4>Lollipop</h4>
                <p>Php 25.00</p>
            </div> 
            <div class="col-4">
                <img src="images/rebisco.jpg">
                <h4>Rebisco</h4>
                <p>Php 50.00</p>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <img src="images/mega.jpg">
                <h4>Mega</h4>
                <p>Php 25.00</p>
            </div>
            <div class="col-4">
                <img src="images/luckyme.jpg">
                <h4>Lucky Me</h4>
                <p>Php 10.50</p>
            </div>
            <div class="col-4">
                <img src="images/lollipop.jpg">
                <h4>Lollipop</h4>
                <p>Php 25.00</p>
            </div> 
            <div class="col-4">
                <img src="images/rebisco.jpg">
                <h4>Rebisco</h4>
                <p>Php 50.00</p>
            </div>
        </div>
    </div>
</div> -->

<!-- <?php endif; ?> -->

<!-- <div class="category-buttons">
    <button class="all" onclick="showCategory(0)">All</button>
    <?php
        include 'DB/db_con.php';
        $query = "SELECT category_id, category_name FROM category";
        $result = $pdo->query($query);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<button class="cat-btn" onclick="showCategory(' . $row['category_id'] . ')">' . $row['category_name'] . '</button>';
        }
    ?>
</div> -->
<div class="category-head">
    <div class="category-dropdown">
    <label>Product Category: </label>
        <select id="category-select" onchange="showCategory(this.value)">
            <option value="0">All</option>
            <?php
                include 'DB/db_con.php';
                $query = "SELECT category_id, category_name FROM category";
                $result = $pdo->query($query);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                }
            ?>
        </select>
    </div>

    <form class="search" method="GET" action="">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
        <button type="submit">Search</button>
    </form>
</div>


<!-- --product list-- -->
<div class="productList">
    <div id="categoryItems">
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                            <img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" class="prod-img">
                        </a>
                        <h3 style="text-align: center;">
                            <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                                <?php echo $product['prod_name']; ?>
                            </a>
                        </h3>
                        <?php else: ?>
                        <a href="login_form.php">
                            <img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" class="prod-img">
                        </a>
                        <h3 style="text-align: center;">
                            <a href="login_form.php">
                                <?php echo $product['prod_name']; ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                        <!-- <p style="text-align: center; font-weight: bold;" >"Avail 3pcs above to get Discounted price"</p> -->
                        <!-- <p>Discounted Price: ₱ <?php echo number_format($product['discounted_price'], 2); ?></p> -->
                        <p>Price: ₱ <?php echo number_format($product['retail_price'], 2); ?></p>
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
                    <a href="?page=<?php echo $previous; ?>&search=<?php echo $search; ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" <?php if ($page === $i) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $next; ?>&search=<?php echo $search; ?>">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>  
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
<script>
    function search(event) {
        if (event.keyCode === 13) { 
            var searchTerm = document.getElementById("search-input").value.trim();

            if (searchTerm !== "") {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var products = JSON.parse(this.responseText);
                            updateProductList(products);
                        } else {
                            console.error("Error fetching data. Status code: " + this.status);
                        }
                    }
                };
                xhr.open("POST", "search.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("search_term=" + encodeURIComponent(searchTerm)); 
            }
        }
    }
    </script>
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
    // MenuItems.style.maxHeight = "0px";
    // function menutoggle() {
    //     if (MenuItems.style.maxHeight =="0px")
    //     {
    //         MenuItems.style.maxHeight = "200px";
    //     }
    //     else{
    //         MenuItems.style.maxHeight = "0px";
    //     }
    //}
</script>

</body>
</html>