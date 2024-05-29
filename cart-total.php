<?php
require 'DB/db_con.php';
session_start();

if (isset($_SESSION['user_id'])) { 
    try {
        // Fetch all items in the cart for the user
        $stmt_items = $pdo->prepare("SELECT (CASE WHEN c.quantity <= 2 THEN p.retail_price ELSE p.discounted_price END) * c.quantity AS subtotal
                                        FROM cart c
                                        INNER JOIN products p ON c.product_id = p.product_id 
                                        WHERE c.user_id = :user_id");
        $stmt_items->execute(['user_id' => $_SESSION['user_id']]);
        $items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

        // Compute the total based on the sum of all subtotals
        $total = 0;
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        echo json_encode(['total' => $total]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}
$pdo = null;
?>
