<?php
session_start();
require 'DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selectedItems']) && !empty($_POST['selectedItems'])) {
        $selectedItems = $_POST['selectedItems'];
        $selectedQuantities = $_POST['selectedQuantities'];
        $selectedPrices = $_POST['selectedPrices'];

        $userId = $_SESSION['user_id'];
     
        $stmt = $pdo->prepare("SELECT address_id, role FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            header("Location: add-address.php");
            exit();
        }

        $addressId = $userData['address_id'];
        $userRole = $userData['role'];

        $pdo->beginTransaction();

        try {
            $dateOrdered = date("Y-m-d H:i:s");
            $order_status = 'Pending';
            $deliveryOption = $_POST['pickupDelivery'];
            $stmt = $pdo->prepare("INSERT INTO orders (date_ordered, order_status, user_id, address_id, delivery_option) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$dateOrdered, $order_status, $userId, $addressId, $deliveryOption]);
            $orderId = $pdo->lastInsertId();
          
            $totalPrice = 0;
            foreach ($selectedItems as $index => $itemId) {
                $stmt = $pdo->prepare("SELECT product_variations.discounted_price, product_variations.retail_price, products.stock FROM products
                                        INNER JOIN product_variations ON products.product_id = product_variations.product_id 
                                        WHERE products.product_id = ?");
                $stmt->execute([$itemId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($product) {
                    $price = ($userRole === 'Retail_Customer') ? $product['retail_price'] : $product['discounted_price'];
                    $quantity = $selectedQuantities[$index];
                    $subtotal = $price * $quantity;
                    $totalPrice += $subtotal;
            
                    $stmt = $pdo->prepare("INSERT INTO orders_details (quantity, price, order_id, product_id) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$quantity, $price, $orderId, $itemId]);
                    
                    $newStock = $product['stock'] - $quantity;
                    $stmt = $pdo->prepare("UPDATE products SET stock = ? WHERE product_id = ?");
                    $stmt->execute([$newStock, $itemId]);
                    
                    $stmt = $pdo->prepare("DELETE FROM cart WHERE product_id = ? AND user_id = ?");
                    $stmt->execute([$itemId, $userId]);
                } else {
                    throw new Exception("Product details not found for product ID: $itemId");
                }
            }
           
            // Calculate delivery fee based on minimum spend
            $deliveryFee = 0;
            if ($deliveryOption === 'delivery') {
                $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key = 'min_order_for_free_shipping' OR setting_key = 'shipping_fee'");
                $stmt->execute();
                $optionData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($optionData as $option) {
                    if ($option['setting_key'] === 'min_order_for_free_shipping' && $totalPrice < $option['setting_value']) {
                        $deliveryFee = isset($optionData['shipping_fee']) ? floatval($option['setting_value']) : 0;
                    }
                }
            }
            $totalPrice += $deliveryFee;
            
            $stmt = $pdo->prepare("UPDATE orders SET total_price = ? WHERE order_id = ?");
            $stmt->execute([$totalPrice, $orderId]);
            
            $pdo->commit();
        
            $_SESSION['success_message'] = "Your order was successfully placed!";
            
            header("Location: my_orders.php");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "An error occurred: " . $e->getMessage() . "<br>";
        }        

    } else {
        header("Location: cart-view.php");
        exit();
    }
} else {
    header("Location: cart-view.php");
    exit();
}
?>
