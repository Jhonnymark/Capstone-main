<?php
session_start();
require 'DB/db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['rating'], $_POST['feedback'])) {
    $order_id = $_POST['order_id'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];
    $user_id = $_SESSION['user_id']; 

    $stmt = $pdo->prepare("INSERT INTO ratings (order_id, user_id, rating_value, feedback) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_id, $user_id, $rating, $feedback]);


    header("Location: my_orders.php");
    exit();
}
?>
