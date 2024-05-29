<?php
require '../DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $user_id = $_POST['user_id']; // Ensure user_id is being sent from the form

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Update the orders table
        $sql = "UPDATE orders SET order_status = :status WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        // Check if the status is 'ToReceive' and then perform operations on the delivery table
        if ($status === 'ToReceive') {
            // Check if a record exists
            $checkSql = "SELECT * FROM delivery WHERE order_id = :order_id";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->bindParam(':order_id', $order_id);
            $checkStmt->execute();

            if ($checkStmt->rowCount() == 0) {
                // Insert new record into the delivery table
                $insertSql = "INSERT INTO delivery (delivery_date, status, user_id, order_id) VALUES (NOW(), :status, :user_id, :order_id)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->bindParam(':status', $status);
                $insertStmt->bindParam(':user_id', $user_id);
                $insertStmt->bindParam(':order_id', $order_id);
                $insertStmt->execute();
            } else {
                // Optionally update existing delivery entry if needed
                $updateDeliverySql = "UPDATE delivery SET status = :status WHERE order_id = :order_id";
                $updateDeliveryStmt = $pdo->prepare($updateDeliverySql);
                $updateDeliveryStmt->bindParam(':status', $status);
                $updateDeliveryStmt->bindParam(':order_id', $order_id);
                $updateDeliveryStmt->execute();
            }
        }

        // Commit the transaction
        $pdo->commit();

        // Redirect back to the page where the form was submitted
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack(); // Rollback the transaction on error
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        $pdo->rollBack(); // Rollback the transaction on error
        die("Error: " . $e->getMessage());
    }
}
?>
