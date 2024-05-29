<?php

session_start();

include 'DB/db_con.php';

$output = array();

try {
    if (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'Retail_Customer' || $_SESSION['role'] === 'Wholesale_Customer')) {
    // if (isset($_SESSION['user_id']) && strcasecmp($_SESSION['role'], 'customer') === 0) {
        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        $stmt = $pdo->prepare("SELECT cart.*, products.prod_name, 
        CASE 
            WHEN :role = 'Retail_Customer' THEN products.retail_price
            WHEN :role = 'Wholesale_Customer' THEN products.discounted_price
            ELSE products.retail_price 
        END AS price, 
        products.photo 
        FROM cart
        INNER JOIN products ON cart.product_id = products.product_id
        WHERE user_id = :user_id");

        // Bind the role value separately
        $stmt->bindValue(':role', $role);

        $stmt->execute(['user_id' => $user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $output = $cartItems;
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
