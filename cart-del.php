<?php
session_start();
require 'DB/db_con.php';
$output = array('message' => '');
$cart_id = $_POST['cart_id'];

if (isset($_SESSION['user_id'])) { 
    try {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE cart_id=:cart_id AND user_id=:user_id");
        $stmt->execute(['cart_id' => $cart_id, 'user_id' => $_SESSION['user_id']]);
        $output['message'] = 'Deleted';

        echo json_encode(['message' => $output['message']]); 
    } catch (PDOException $e) {
        $output['message'] = $e->getMessage();
        echo json_encode($output);
    }
} else {
    $output['message'] = 'User not logged in';
    echo json_encode($output); 
}
?>
