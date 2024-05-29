<?php
require '../DB/db_con.php';

$name = isset($_GET['name']) ? $_GET['name'] : '';

$stmt = $pdo->prepare("SELECT user_id, first_name, last_name FROM users WHERE first_name LIKE CONCAT('%', :name, '%') OR last_name LIKE CONCAT('%', :name, '%')");
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->execute();

$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($customers) {
    echo json_encode($customers);
} else {
    echo json_encode([]);
}
?>
