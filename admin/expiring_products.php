<?php
require '../DB/db_con.php';

$today = date('Y-m-d');
$twoWeeksLater = date('Y-m-d', strtotime('+2 weeks'));

// Query to fetch products expiring within two weeks
$stmt = $pdo->prepare("SELECT * FROM products WHERE expiration_date BETWEEN :today AND :twoWeeksLater");
$stmt->execute(['today' => $today, 'twoWeeksLater' => $twoWeeksLater]);
$expiringProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the details of expiring products
foreach ($expiringProducts as $product) {
    echo "<p>Product Name: " . $product['prod_name'] . "</p>";
    echo "<p>Expiration Date: " . $product['expiration_date'] . "</p>";
    // Add more details as needed...
}
?>
