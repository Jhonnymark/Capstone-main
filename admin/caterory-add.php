<?php
require __DIR__ . '/../DB/db_con.php';

if(isset($_POST['category_name']) && !empty($_POST['category_name'])) {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO category (category_name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$category_name])) {
        header("location: http://localhost/E-commerce/admin/category.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    
    // Close the PDO connection
    $pdo = null;
}
?>
