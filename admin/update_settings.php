<?php
require '../DB/db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shippingFee = $_POST['shipping_fee'];
    $minOrderForFreeShipping = $_POST['min_order_for_free_shipping'];

    try {
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = 'shipping_fee'");
        $stmt->execute(['value' => $shippingFee]);

        $stmt = $pdo->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = 'min_order_for_free_shipping'");
        $stmt->execute(['value' => $minOrderForFreeShipping]);

        header('Location: admin_dash.php');
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
