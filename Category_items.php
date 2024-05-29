<?php
session_start();
require 'DB/db_con.php';

if(isset($_POST['categoryId'])) {
    $category = $_POST['categoryId'];

    try {
        if ($category == 0) {
            $sql = "SELECT products.*, product_variations.discounted_price, product_variations.retail_price, product_variations.variation_type, category.category_name
                    FROM products
                    INNER JOIN category ON products.category_id = category.category_id
                    LEFT JOIN product_variations ON products.product_id = product_variations.product_id";
        } else {
            $sql = "SELECT products.*, product_variations.discounted_price, product_variations.retail_price, product_variations.variation_type, category.category_name
                    FROM products
                    INNER JOIN category ON products.category_id = category.category_id
                    LEFT JOIN product_variations ON products.product_id = product_variations.product_id
                    WHERE products.category_id = :category";
        }

        $stmt = $pdo->prepare($sql);

        if ($category != 0) {
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        }

        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($products as $product) {
            echo '<div class="product-item">';
            if (isset($_SESSION['user_id'])) {
                echo '<a href="product_details.php?product_id=' . $product['product_id'] . '">';
                echo '<img src="images/upload/' . $product['photo'] . '" alt="Product Photo" class="prod-img">';
                echo '</a>';
                // echo '<h3 style="text-align: center;">' . $product['prod_name'] . '</h3>';
                echo '<h3 style="text-align: center; font-weight: bold;  border-bottom: 1px solid red;">';
                echo '<a href="product_details.php?product_id=' . $product['product_id'] . '">';
                echo $product['prod_name'];
                echo '</a>';
                echo '</h3>';
            } else {
                echo '<a href="login_form.php">';
                echo '<img src="images/upload/' . $product['photo'] . '" alt="Product Photo" class="prod-img">';
                echo '</a>';
                echo '<h3 style="text-align: center;">';
                echo '<a href="login.php">';
                echo $product['prod_name'];
                echo '</a>';
                echo '</h3>';
            }
            // echo '<p style="text-align: center;">"Avail 3pcs above to get Discounted price"</p>';
            // echo '<p>Discounted Price: ₱ ' . number_format($product['discounted_price'], 2) . '</p>';
            // echo '<p>Regular Retail Price: ₱ ' . number_format($product['retail_price'], 2) . '</p>';

            if (isset($_SESSION['role']) && $_SESSION['role'] == 'Wholesale_Customer') {
                echo '<p>Price: ₱' . number_format($product['discounted_price'], 2) . '</p>';
            } else {
                echo '<p>Price: ₱' . number_format($product['retail_price'], 2) . '</p>';
            }
            
            echo '<p>Variation Type: ' . ucfirst(str_replace('_', ' ', $product['variation_type'])) . '</p>';
            echo '<p>Stock: ' . number_format($product['stock']) . '</p>';
            echo '</div>';
        }
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "categoryId parameter not received.";
}
?>
