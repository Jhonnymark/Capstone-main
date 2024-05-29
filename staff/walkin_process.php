<?php
session_start();
include '../DB/db_con.php';

if (isset($_SESSION['user_id']) && ($_SESSION['role'] == 'Staff' || $_SESSION['role'] == 'Admin')) {
    $userId = $_SESSION['user_id'];

    $customerName = isset($_POST['customer-name']) ? $_POST['customer-name'] : null;
    $orderType = isset($_POST['order-type']) ? $_POST['order-type'] : null;
    $street = isset($_POST['street']) ? $_POST['street'] : null;
    $barangay = isset($_POST['barangay']) ? $_POST['barangay'] : null;
    $municipality = isset($_POST['municipality']) ? $_POST['municipality'] : null;
    $items = isset($_POST['items']) ? json_decode($_POST['items'], true) : [];
    
    // Validate and sanitize input data
    $customerName = filter_var($customerName, FILTER_SANITIZE_STRING);
    $orderType = filter_var($orderType, FILTER_SANITIZE_STRING);
    $street = filter_var($street, FILTER_SANITIZE_STRING);
    $barangay = filter_var($barangay, FILTER_SANITIZE_STRING);
    $municipality = filter_var($municipality, FILTER_SANITIZE_STRING);

    // Determine which price field to select based on the type
    //$priceField = ($orderType === 'retail') ? 'retail_price' : 'discounted_price';
    $priceField = ($orderType === 'retail') ? 'pv.retail_price' : 'pv.discounted_price';

    try {
        $pdo->beginTransaction();

        // Check if the address exists in the `address` table
        $stmtAddress = $pdo->prepare("SELECT address_id FROM address WHERE street = ? AND barangay = ? AND municipality = ?");
        $stmtAddress->execute([$street, $barangay, $municipality]);
        $addressId = $stmtAddress->fetchColumn();

        // If the address doesn't exist, insert it
        if (!$addressId) {
            $stmtAddress = $pdo->prepare("INSERT INTO address (street, barangay, municipality) VALUES (?, ?, ?)");
            $stmtAddress->execute([$street, $barangay, $municipality]);
            $addressId = $pdo->lastInsertId();
        }

        // Insert into `orders` table
        $dateOrdered = date("Y-m-d H:i:s");
        $order_status = 'Completed';
        $deliveryOption = 'InStore';
        $totalPrice = 0;

        $stmtOrder = $pdo->prepare("INSERT INTO orders (date_ordered, order_status, user_id, delivery_option, address_id, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtOrder->execute([$dateOrdered, $order_status, $userId, $deliveryOption, $addressId, $totalPrice]);
        $orderId = $pdo->lastInsertId();

        // Insert into `orders_details` table
        $stmtDetails = $pdo->prepare("INSERT INTO orders_details (quantity, price, order_id, product_id) VALUES (?, ?, ?, ?)");

        // Loop through each item and insert its details
        if (is_array($items)) {
            foreach ($items as $item) {
                $product = isset($item['product']) ? $item['product'] : null;
                $quantity = isset($item['quantity']) ? $item['quantity'] : null;

                // Fetch product ID and price from database based on product name and customer type
                //$stmtProduct = $pdo->prepare("SELECT product_id, $priceField AS price, stock FROM products WHERE prod_name = ?");
                $stmtProduct = $pdo->prepare("SELECT p.product_id,  $priceField AS price, p.stock, pv.variation_type
                                            FROM products p
                                            JOIN product_variations pv ON p.product_id = pv.product_id
                                            WHERE p.prod_name = ?");

                $stmtProduct->execute([$product]);
                $productData = $stmtProduct->fetch(PDO::FETCH_ASSOC);

                if ($productData) {
                    $productId = $productData['product_id'];
                    $price = $productData['price'];
                    $itemTotalPrice = $quantity * $price; // Calculate total price for this item

                    // Insert details into `orders_details` table
                    $stmtDetails->execute([$quantity, $price, $orderId, $productId]);

                    // Update stock
                    $newStock = $productData['stock'] - $quantity;
                    $stmtUpdateStock = $pdo->prepare("UPDATE products SET stock = ? WHERE product_id = ?");
                    $stmtUpdateStock->execute([$newStock, $productId]);

                    // Accumulate total price
                    $totalPrice += $itemTotalPrice;
                } else {
                    throw new Exception("Invalid product selected: $product.");
                }
            }

            // Update total price in `orders` table
            $stmtUpdateOrder = $pdo->prepare("UPDATE orders SET total_price = ? WHERE order_id = ?");
            $stmtUpdateOrder->execute([$totalPrice, $orderId]);
        } else {
            throw new Exception('No items provided for the order.');
        }

        $pdo->commit();

        echo "Order successfully processed!";
        header("Location: staff_dash.php");
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo "Error processing request: " . $e->getMessage();
    }
} else {
    echo "Unauthorized access"; 
}
?>
