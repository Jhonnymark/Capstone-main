<?php
require '../DB/db_con.php';

try {
    $currentDate = date('Y-m-d');

    $query_pending = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'Pending'";
    $stmt_pending = $pdo->query($query_pending);
    $pending_count = $stmt_pending->fetch(PDO::FETCH_ASSOC)['numrows'];
    
    $query_toShip = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'ToShip'";
    $stmt_toShip = $pdo->query($query_toShip);
    $toShip_count = $stmt_toShip->fetch(PDO::FETCH_ASSOC)['numrows'];

    $query_toReceive = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'ToReceive'";
    $stmt_toReceive = $pdo->query($query_toReceive);
    $toReceive_count = $stmt_toReceive->fetch(PDO::FETCH_ASSOC)['numrows'];

    $query_completed = "SELECT COUNT(*) AS numrows FROM orders WHERE order_status = 'Completed' AND DATE(date_ordered) = :currentDate";
    $stmt_completed = $pdo->prepare($query_completed);
    $stmt_completed->bindParam(':currentDate', $currentDate);
    $stmt_completed->execute();
    $completed_count = $stmt_completed->fetch(PDO::FETCH_ASSOC)['numrows'];

    echo json_encode(array(
        'Pending' => $pending_count,
        'ToShip' => $toShip_count,
        'ToReceive' => $toReceive_count,
        'Completed' => $completed_count
    ));
} catch (PDOException $e) {
    echo '<script>';
    echo 'console.error(' . json_encode('Error occurred while fetching order counts: ' . $e->getMessage()) . ');';
    echo '</script>';
    echo json_encode(array(
        'error' => 'Error occurred while fetching order counts: ' . $e->getMessage()
    ));
}
?>
