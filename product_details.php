<?php
require 'DB/db_con.php';
require 'count-cart.php';

$product = null;

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

    $sql = "SELECT products.*, category.category_name, product_variations.discounted_price, product_variations.retail_price, product_variations.variation_type
    FROM products 
    INNER JOIN category ON products.category_id = category.category_id
    LEFT JOIN product_variations ON products.product_id = product_variations.product_id
    WHERE products.product_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

$reviews_sql = "SELECT ratings.*, users.username
                FROM ratings 
                INNER JOIN users ON ratings.user_id = users.user_id 
                WHERE ratings.order_id IN (SELECT order_id FROM orders_details WHERE product_id = ?)";
$reviews_stmt = $pdo->prepare($reviews_sql);
$reviews_stmt->execute([$product_id]);
$reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
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
                <li><a href="http://localhost/E-commerce/customer_dash.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="my_orders.php">My Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
                <!-- <li><a href="">Account</a></li> -->
            </ul>
        </nav>

        <div class="setting-sec">
            <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
                <!-- <img src="images/profile-icon.png" width="30px" height="30px" class="icon"> -->
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

    <div class="prod-container">
        <div class="product-item">
            <?php if ($product !== null): ?>
                <img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" class="prod-img">
                <h3 style="text-align: center;"><?php echo $product['prod_name']; ?></h3>
                
                <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Wholesale_Customer'):
                ?>
                <p>Price: ₱ <?php echo number_format($product['discounted_price'], 2); ?></p>
                <?php else: ?>
                    <p>Price: ₱ <?php echo number_format($product['retail_price'], 2); ?></p>
                <?php endif; ?>
                <p>Stock: <span id="stock"><?php echo number_format($product['stock']); ?></span></p>
                
                <p style="text-align: center;">Category Name: <?php echo $product['category_name']; ?></p>
                <p style="text-align: center;">Product Description:<?php echo $product['prod_desc']; ?></p>

                <span class="input-group-btn">
                    <button type="button" id="minus" class="btn btn-default btn-flat btn-lg"><i class="fa fa-minus"></i></button>
                </span>
                <input type="text" name="quantity" id="quantity" class="form-control input-lg" value="1">
                <span class="input-group-btn">
                    <button type="button" id="add" class="btn btn-default btn-flat btn-lg"><i class="fa fa-plus"></i></button>
                </span>
                <input type="hidden" value="<?php echo $product['product_id']; ?>" name="id" id="quantity">
            
                <button class="addToCart" type="button" onclick="addToCart(<?php echo $product['product_id']; ?>)">
                    <i class="fa fa-cart-arrow-down"></i> Add To Cart
                </button>

                <a href="http://localhost/E-commerce/customer_dash.php" class="back">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            <?php else: ?>
                <p>Product not found</p>
            <?php endif; ?>
        </div>

        <div class="product-reviews">
            <h4>Product Reviews</h4>
            <?php if (count($reviews) > 0): ?>
                <ul>
                    <?php foreach ($reviews as $review): ?>
                        <li>
                            <div class="review-user">
                                <span><?php echo $review['username']; ?></span>
                            </div>
                            <div class="review-rating">Rating: <?php echo $review['rating_value']; ?></div>
                            <div class="review-comment">Comment: <?php echo $review['feedback']; ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No reviews for this product yet.</p>
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
        var menuItems = document.getElementById("menuItems");
        function menutoggle() {
            menuItems.classList.toggle("show");
        }
        // MenuItems.style.maxHeight = "0px";
        // function menutoggle() {
        //     if (MenuItems.style.maxHeight === "0px") {
        //         MenuItems.style.maxHeight = "200px";
        //     } else {
        //         MenuItems.style.maxHeight = "0px";
        //     }
        // }
    </script>

    <script>
    $(function(){
        $('#add').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        var stock = parseInt($('#stock').text());

        if (quantity < stock) {
            quantity++;
            $('#quantity').val(quantity);
        } else {
            // alert("Cannot add more. Stock limit reached.");
            Swal.fire({
            icon: 'error',
            title: 'Cannot add more.',
            text: 'Stock limit reached.',
            confirmButtonText: 'OK'
            });
        }
    });
        
        $('#minus').click(function(e){
            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            
            if(quantity > 1){
                quantity--;
                $('#quantity').val(quantity);
            }
        });
    });

        function addToCart(product_id) {
            var quantity = $('input[name="quantity"]').val();
            var stock = parseInt($('#stock').text());
            console.log('Product ID:', product_id);
            console.log('Quantity:', quantity);
            if (stock <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'This product is out of stock.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (parseInt(quantity) > stock) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Quantity exceeds available stock.',
                confirmButtonText: 'OK'
            });
            return;
            }
            $.ajax({
                url: 'addToCart.php',
                type: 'POST',
                data: { product_id: product_id, quantity: quantity }, 
                dataType: 'json',
                success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'http://localhost/E-commerce/cart-view.php';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Unable to connect to the server',
                confirmButtonText: 'OK'
            });
        }
    });
}
    </script>
</body>
</html>