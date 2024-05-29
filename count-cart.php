<?php 
require 'DB/db_con.php'; 

session_start();

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
$stmt = $pdo->prepare("SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$cart_count = $stmt->fetchColumn();
?>

