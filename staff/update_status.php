<?php foreach ($orders as $order): ?>
    <div>
        <p>Order ID: <?php echo $order['order_id']; ?></p>
        <p>Date Ordered: <?php echo $order['date_ordered']; ?></p>
        <p>Status: <?php echo $order['status']; ?></p>
        
        <form method="post">
            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
            <select name="new_status">
                <option value="Pending">Pending</option>
                <option value="To Ship">To Ship</option>
                <option value="To Receive">To Receive</option>
                <option value="Completed">Completed</option>
            </select>
            <button type="submit" name="update_status">Update Status</button>
        </form>
    </div>
<?php endforeach; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->execute([$newStatus, $orderId]);

    header("Location: my_orders.php");
    exit();
}
?>
