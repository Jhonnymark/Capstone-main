<?php
// session_start();
require 'DB/db_con.php';
require 'count-cart.php';

// Function to fetch active promo
function getBestPromo($pdo, $total) {
    $currentDate = date('Y-m-d');
    $sql = "SELECT * FROM promo WHERE start_date <= :currentDate AND end_date >= :currentDate ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
    $stmt->execute();
    $promos = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    
    $bestPromo = null;
    $maxDiscount = 0;

    foreach($promos as $promo){
        if ($total >= $promo['minimum_spend']){
            $discount = $total * ($promo ['discount_percentage'] / 100);
            if ($discount > $maxDiscount){
                $maxDiscount= $discount;
                $bestPromo = $promo;
            }
        }
    }
    return $bestPromo;
}

if (!isset($_SESSION['role'])){
    header("Location: login_form.php");
    exit();
}

if(isset($_POST['selectedItems'])) {
    $selectedItems = $_POST['selectedItems'];

    $selectedProducts = array();
    $total = 0;

    foreach ($selectedItems as $itemId) {
        // $stmt = $pdo->prepare("SELECT cart.*, products.prod_name, products.discounted_price, products.retail_price, products.photo 
        //                         FROM cart 
        //                         INNER JOIN products ON cart.product_id = products.product_id 
        //                         WHERE cart.cart_id = :cart_id");
        $stmt = $pdo->prepare("SELECT cart.*, products.prod_name, product_variations.discounted_price, 
                                        product_variations.retail_price, products.photo 
                                FROM cart 
                                INNER JOIN products ON cart.product_id = products.product_id 
                                INNER JOIN product_variations ON cart.product_id = product_variations.product_id 
                                WHERE cart.cart_id = :cart_id");
        $stmt->execute(['cart_id' => $itemId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // $price = ($product['quantity'] <= 2) ? $product['retail_price'] : $product['discounted_price'];
            $price = ($_SESSION['role'] === 'Retail_Customer') ? $product['retail_price'] : $product['discounted_price'];
            $subtotal = $price * $product['quantity'];
            $total += $subtotal;

            $product['price'] = $price;
            $product['subtotal'] = $subtotal;
            $selectedProducts[] = $product;
        }
    }
    
    $bestPromo = getBestPromo ($pdo, $total);
    $promoDiscount= 0;
    if ($bestPromo){
        $promoDiscount =$total * ($bestPromo[ 'discount_percentage'] / 100);
        $total -= $promoDiscount;
    }
    $deliveryFee = 0;
    if (isset($_POST['pickupDelivery']) && $_POST['pickupDelivery'] === 'delivery' && $total < 2000) {
        $deliveryFee = 50.00;
    }

    $total += $deliveryFee;

} else {
    header("Location: cart-view.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
<style>
form {
    min-height: calc(100% - 255px);
}
table {
    width: 80%;
    border-collapse: collapse;
    margin: 20px auto;
    border: 2px solid #656262;
}
th, td {
    padding: 10px;
    /* border-bottom: 2px solid #656262;
    border-top: 2px solid #656262; */
    text-align: Center;
    background-color: #cfcfcf;
}
button {
    background-color: #cf9292;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    outline: none;
    padding: 10px;
    margin-bottom: 20px;
    margin-top: 10px;
    margin-left: 78%;
    font-weight: bold;
}
button:hover {
    background-color: #2ecc71; 
}

input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid #000;
    outline: none;
    cursor: pointer;
    margin-right: 10px; /* Adjust as needed */
}

input[type="radio"]:checked {
    background-color: #000;
}

</style>
</head>
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
        <li><a href="http://localhost/E-commerce/my_orders.php">My Orders</a></li>
        <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
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
<body>
<form action="place-order.php" method="POST">
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($selectedProducts as $product): ?>
            <tr>
                <td><img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" style="max-width: 50px; max-height: 50px;"></td>
                <td><?php echo isset($product['prod_name']) ? $product['prod_name'] : ''; ?></td>
                <!-- <td><?php echo isset($product['prod_price']) ? $product['prod_price'] : ''; ?></td> -->
                <td><?php echo isset($product['price']) ? $product['price'] : ''; ?></td>
                <td><?php echo isset($product['quantity']) ? $product['quantity'] : ''; ?></td>
                <td class="subtotal"><?php echo isset($product['subtotal']) ? number_format($product['subtotal'], 2) : ''; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2"><label for="pickupDelivery">Choose Delivery Option:</label></td>
                <td colspan="5" style="text-align: center;">
                    <input type="radio" id="pickup" name="pickupDelivery" value="pickup">
                    <label for="pickup">Pickup</label>
                
                    <input type="radio" id="delivery" name="pickupDelivery" value="delivery"> 
                    <label for="delivery">Delivery</label>
                </td>
            </tr>
            <!-- <tr>
                <td colspan="4" style="text-align: right;"><strong>Delivery Fee:</strong></td>
                <td><?php echo number_format($deliveryFee, 2); ?></td>
            </tr> -->
            <tr id="deliveryFeeRow" style="display: none;">
                <td colspan="4" style="text-align: right;"><strong>Delivery Fee:</strong></td>
                <td id="deliveryFee"><?php echo number_format($deliveryFee, 2); ?></td>
            </tr>
            <tr id="promoDiscountRow" style="display: <?php echo ($promoDiscount > 0) ? 'table-row' : 'none'; ?>;">
                <td colspan="4" style="text-align: right;"><strong>Promo Discount:</strong></td>
                <td id="promoDiscount"><?php echo number_format($promoDiscount, 2); ?></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                <td id="total"><?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>
    
        <button type="submit">Place Order</button>
        <?php foreach ($selectedProducts as $product): ?>
            <input type="hidden" name="selectedItems[]" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="selectedQuantities[]" value="<?php echo $product['quantity']; ?>">
            <input type="hidden" name="selectedPrices[]" value="<?php echo isset($price) ? $price : ''; ?>">
        <?php endforeach; ?>
    </form>
    
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

    var deliveryOption = document.querySelectorAll('input[name="pickupDelivery"]');
    var deliveryFeeRow = document.getElementById('deliveryFeeRow');

    // deliveryOption.forEach(function(option) {
    //     option.addEventListener('change', function() {
    //         if (option.value === 'delivery') {
    //             deliveryFeeRow.style.display = 'table-row'; 
    //         } else {
    //             deliveryFeeRow.style.display = 'none'; 
    //         }
    //     });
    // });

    deliveryOption.forEach(function(option) {
    option.addEventListener('change', function() {
        let deliveryFee = 0;
        let originalTotal = parseFloat(document.getElementById('total').textContent.replace(/,/g, ''));
        
        if (option.value === 'delivery' && originalTotal < 2000) {
            deliveryFee = 50.00;
            deliveryFeeRow.style.display = 'table-row'; 
        } else {
            deliveryFeeRow.style.display = 'table-row'; 
        }

        document.getElementById('deliveryFee').textContent = deliveryFee.toFixed(2);
        document.getElementById('total').textContent = (originalTotal + deliveryFee).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    });
});
</script>

</body>
</html>
