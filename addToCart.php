<?php
include 'DB/db_con.php';
require 'count-cart.php';
$output = array('success' => false);

try {
    if (isset($_SESSION['user_id']) && ($_SESSION['role'] == 'Retail_Customer' || $_SESSION['role'] == 'Wholesale_Customer')) {
     // if (isset($_SESSION['user_id']) && strcasecmp($_SESSION['role'], 'customer') === 0) {
        if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
            $user_id = $_SESSION['user_id'];
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];

            $stmt = $pdo->prepare
            // ('SELECT * FROM products WHERE product_id = ?');
            ('SELECT products.*, category.category_name, product_variations.discounted_price, 
                    product_variations.retail_price, product_variations.variation_type
                FROM products 
                INNER JOIN category ON products.category_id = category.category_id
                LEFT JOIN product_variations ON products.product_id = product_variations.product_id
                WHERE products.product_id = ?');

            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product && $quantity > 0) {
                if ($product['stock'] > 0) { 
                    // $price = ($quantity <= 2) ? $product['retail_price'] : $product['discounted_price'];
                    
                     // Choose price based on user role
                     if ($_SESSION['role'] == 'Retail_Customer') {
                        $price = $product['retail_price'];  // Always use retail price for retail customers
                    } else if ($_SESSION['role'] == 'Wholesale_Customer') {
                        $price = $product['discounted_price'];
                        // $price = ($quantity >= 3) ? $product['discounted_price'] : $product['retail_price'];  // Use discounted price if quantity is 3 or more
                    }
                    $stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM cart WHERE user_id = :user_id AND product_id = :product_id");
                    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
                    $row = $stmt->fetch();

                    if ($row['numrows'] < 1) {
                        $stmt = $pdo->prepare("INSERT INTO cart (user_id, status, order_id, quantity, product_id) VALUES (:user_id, :status, :order_id, :quantity, :product_id)");
                        $stmt->execute(['user_id' => $user_id, 'status' => 'pending', 'order_id' => 0, 'quantity' => $quantity, 'product_id' => $product_id]);
                        
                        $stmt = $pdo->prepare("SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = :user_id");
                        $stmt->execute(['user_id' => $user_id]);
                        $cart_count = $stmt->fetchColumn();

                        $output['success'] = true;
                        $output['message'] = 'Item added to cart';
                        $output['cart_count'] = $cart_count;
                    } else {
                        $output['error'] = true;
                        $output['message'] = 'Product already in cart';
                    }
                } else {
                    $output['error'] = true;
                    $output['message'] = 'Sorry, the product is out of stock.';
                }
            } else {
                $output['error'] = true;
                $output['message'] = 'Invalid product or quantity';
            }
        } else {
            $output['error'] = true;
            $output['message'] = 'Invalid request - Missing product_id or quantity';
        }
    } else {
        $output['error'] = true;
        $output['message'] = 'Invalid request - Role not set or not customer';
    }
} catch (PDOException $e) {
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

echo json_encode($output);
?>
