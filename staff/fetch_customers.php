<?php
include '../DB/db_con.php';

if (isset($_POST['query']) && isset($_POST['type'])) {
    $query = '%' . $_POST['query'] . '%';
    $type = $_POST['type'] === 'retail' ? 'Retail_Customer' : 'Wholesale_Customer';

    $sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name 
            FROM users 
            WHERE (first_name LIKE ? OR last_name LIKE ?) 
              AND role = ?
            LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$query, $query, $type]);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch()) {
            echo '<li data-id="' . htmlspecialchars($row['user_id']) . '">' . htmlspecialchars($row['full_name']) . '</li>';
        }
    } else {
        echo '<li>No results found</li>';
    }
}
?>
