<?php
session_start();
require 'DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_received'])) {
    $order_id = $_POST['order_id'];
    
    try {
        $date_received = date("Y-m-d"); 

        $stmt = $pdo->prepare("UPDATE orders SET order_status = 'Completed', date_received = ? WHERE order_id = ?");
        $stmt->execute([$date_received, $order_id]);

        header("Location: my_orders.php");
        exit();
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>