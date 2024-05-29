<?php
require '../DB/db_con.php';

if (isset($_GET['status'])) {
    $status = $_GET['status'];

    $query = "SELECT o.order_id, u.first_name, a.barangay, a.street, o.order_status
          FROM orders o
          INNER JOIN users u ON o.user_id = u.user_id
          INNER JOIN address a ON o.address_id = a.address_id
          WHERE o.order_status = :status"; 


    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table id='ordersTable' style='width: 100%' >";
    echo "<tr><th>Order ID</th><th>Order Details</th><th>Status</th><th>Action</th></tr>";

    if ($stmt->rowCount() > 0) {
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['order_id'] . "</td>";
            echo "<td>" . $row['first_name'] . '<br>' . $row['barangay'] . ' - ' . '"' . $row['street'] . '"' . "</td>";
            echo "<td>" . $row['order_status'] . "</td>";
            //echo "<td><button class='view-button' data-id='". $row['order_id']. "'>View</button></td>";
            echo "<td><a href='view-order.php?order_id=" . $row['order_id'] . "'><i class='fa-solid fa-eye'></i></a></td>";
           
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No events found with status: " . $status . "</td></tr>";
    }

    echo "</table>";

    echo "<script>
    $(document).ready(function() {
        $('.view-button').click(function() {
            var orderId = $(this).data('id');
            window.location.href = 'http://localhost/E-commerce/admin/view-order.php?order_id=' + orderId;
        });
    });
  </script>";
  
} else {
    echo "<tr><td colspan='4'>Status not PROVIDED.</td></tr>";
}
?>
