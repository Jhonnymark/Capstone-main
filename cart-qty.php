<?php
session_start();
require 'DB/db_con.php';

$output = array('message' => '');

$cart_id = $_POST['cart_id']; 
$qty = $_POST['quantity']; 

if(isset($_SESSION['user_id'])){
    try{
        // Update quantity for the specific cart item
        $stmt = $pdo->prepare("UPDATE cart SET quantity=:quantity WHERE cart_id=:cart_id");
        $stmt->execute(['quantity'=>$qty, 'cart_id'=>$cart_id]); 
        $output['message'] = 'Updated';

        // Recalculate subtotal
        $stmt_subtotal = $pdo->prepare("SELECT 
        CASE 
            WHEN :role = 'Retail_Customer' THEN p.retail_price
            WHEN :role = 'Wholesale_Customer' THEN p.discounted_price
            ELSE p.retail_price 
        END AS price,
        :qty * 
        CASE 
            WHEN :role = 'Retail_Customer' THEN p.retail_price
            WHEN :role = 'Wholesale_Customer' THEN p.discounted_price
            ELSE p.retail_price 
        END AS subtotal
        FROM cart c
        INNER JOIN products p ON c.product_id = p.product_id
        WHERE c.cart_id=:cart_id");
        // $stmt_subtotal->execute(['cart_id' => $cart_id]);
        $stmt_subtotal->execute(['cart_id' => $cart_id, 'role' => $_SESSION['role'], 'qty' => $qty]);    
        $result = $stmt_subtotal->fetch(PDO::FETCH_ASSOC);

        // Calculate total
        $stmt_total = $pdo->prepare("SELECT 
        SUM(
            :qty * 
            CASE 
                WHEN :role = 'Retail_Customer' THEN p.retail_price
                WHEN :role = 'Wholesale_Customer' THEN p.discounted_price
                ELSE p.retail_price 
            END
        ) AS total 
        FROM cart c
        INNER JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id=:user_id");
        // $stmt_total->execute(['user_id' => $_SESSION['user_id']]);
        $stmt_total->execute(['user_id' => $_SESSION['user_id'], 'role' => $_SESSION['role'], 'qty' => $qty]);
        $total = $stmt_total->fetchColumn();

        echo json_encode(['message' => $output['message'], 'subtotal' => $result['subtotal'], 'total' => $total, 'price' => $result['price']]);
    }
    catch(PDOException $e){
        $output['message'] = $e->getMessage();
        echo json_encode($output);
    }
}
else{
    $output['message'] = 'User not logged in';
    echo json_encode($output);
}

$pdo = null;
?>
