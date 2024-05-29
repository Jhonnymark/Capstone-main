<?php
require __DIR__ . '/../DB/db_con.php';

function getCategories($pdo) {
    $sql = "SELECT category_id, category_name FROM category";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_name = $_POST['prod_name'];
    $type_code = $_POST['type_code'];
    $prod_desc = $_POST['prod_desc'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category'];
    $expiration_date = $_POST['expiration_date'];

    $prod_name = ucwords(strtolower($prod_name)); 
    $prod_desc = ucwords(strtolower($prod_desc));

    $filename = $_FILES['photo']['name'];
    $tempFilePath = $_FILES['photo']['tmp_name'];
    $targetDirectory = "../images/upload/";
    $targetFilePath = $targetDirectory . $filename;

    // Process variations
    $variation_types = $_POST['variation_type'];
    $variation_discounted_prices = $_POST['discounted_price'];
    $variation_retail_prices = $_POST['retail_price'];

    // Check if all variation fields have the same length
    if(count($variation_types) === count($variation_discounted_prices) && count($variation_types) === count($variation_retail_prices)) {
        if (move_uploaded_file($tempFilePath, $targetFilePath)) {
            try {
                // Insert product
                $sql = "INSERT INTO products (prod_name, type_code, prod_desc, stock, photo, category_id, expiration_date)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$prod_name, $type_code, $prod_desc, $stock, $filename, $category_id, $expiration_date]);

                // Get the last inserted product ID
                $product_id = $pdo->lastInsertId();

                // Process variations
                foreach ($variation_types as $index => $variation_type) {
                    $discounted_price = $variation_discounted_prices[$index];
                    $retail_price = $variation_retail_prices[$index];

                    // Insert variation
                    $sql = "INSERT INTO product_variations (product_id, variation_type, discounted_price, retail_price)
                            VALUES (?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$product_id, $variation_type, $discounted_price, $retail_price]);
                }

                header("location: http://localhost/E-commerce/admin/products.php");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Variation data is incomplete.";
    }
}
?>
