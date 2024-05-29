<?php
session_start();
require 'DB/db_con.php';

if (isset($_POST['category'])) {
    $selectedCategory = $_POST['category'];

    if ($selectedCategory == '0') {
        $query = $pdo->prepare("SELECT product_id, prod_name, discounted_price, retail_price, photo, stock FROM products");
        $query->execute();
    } else {
        $query = $pdo->prepare("SELECT product_id, prod_name, discounted_price, retail_price, photo, stock FROM products WHERE category_id = ?");
        $query->execute([$selectedCategory]);
        // $query = $pdo->prepare("SELECT products.product_id, products.prod_name, product_variations.discounted_price, products.photo, products.stock
        //                  FROM products 
        //                  INNER JOIN product_variations ON products.product_id = product_variations.product_id
        //                  WHERE products.category_id = ?");
        // $query->execute([$selectedCategory]);
    }

    $products = $query->fetchAll(PDO::FETCH_ASSOC);


    foreach ($products as $product) {
        echo '<div class="product-item">';
        echo '<img src="images/upload/' . $product['photo'] . '" alt="Product Photo" class="prod-img">';
        echo '<h3 style="text-align: center;">' . $product['prod_name'] . '</h3>';
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Wholesale_Customer') {
            echo '<p>Price: ₱' . number_format($product['discounted_price'], 2) . '</p>';
        } else{
            echo '<p>Retail Price: ₱' . number_format($product['retail_price'], 2) . '</p>';
        }
        echo '<p>Stock: ' . number_format($product['stock']) . '</p>';
        echo '<button type="button" onclick="addToCart(' . $product['product_id'] . ')"><i class="fa fa-cart-arrow-down"></i> Add To Cart</button>';
        echo '<a href="product_details.php?id=' . $product['product_id'] . '" class="details"><i class="fa fa-eye"></i> Details</a>';
        echo '</div>';
    }
}
?>
