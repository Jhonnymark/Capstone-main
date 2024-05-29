<?php
include '../DB/db_con.php';

if(isset($_POST['type']) && !empty($_POST['type']) && isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
    $type = $_POST['type'];
    $categoryId = $_POST['categoryId'];
    $query = '%' . $_POST['query'] . '%';

    // Determine which price field to select based on the type
    $priceField = ($type === 'retail') ? 'pv.retail_price' : 'pv.discounted_price';

    $sql = "SELECT p.prod_name, pv.discounted_price, pv.retail_price as price, p.stock, pv.variation_type
            FROM products p
            INNER JOIN product_variations pv ON p.product_id = pv.product_id
            WHERE p.category_id = :category_id AND p.prod_name LIKE :query";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(':category_id', $categoryId);
    $statement->bindParam(':query', $query);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            //echo '<li data-price="' . htmlspecialchars($row['price']) . '" data-stock="' . htmlspecialchars($row['stock']) . '">' . htmlspecialchars($row['prod_name']) . htmlspecialchars($row['variation_type']) .  '</li>';
            echo '<li data-price="' . htmlspecialchars($row['price']) . '" data-stock="' . htmlspecialchars($row['stock']) . '">' . htmlspecialchars($row['prod_name']) . ' (' . htmlspecialchars($row['variation_type']) . ')</li>';
        }
    } else {
        echo "No products found.";
    }
} else {
    echo "Type or category not specified.";
}
?>
