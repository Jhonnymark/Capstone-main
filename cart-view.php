<?php

include 'DB/db_con.php';
require 'count-cart.php';

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        // $sql = "SELECT cart.*, products.prod_name, products.discounted_price, products.retail_price, products.photo, products.stock, users.role 
        // FROM cart
        // INNER JOIN products ON cart.product_id = products.product_id
        // INNER JOIN users ON cart.user_id = users.user_id
        // WHERE cart.user_id = :user_id";
        $sql = "SELECT cart.*, products.prod_name, product_variations.discounted_price, 
                product_variations.retail_price, products.photo, products.stock, users.role 
                FROM cart
                INNER JOIN products ON cart.product_id = products.product_id
                INNER JOIN product_variations ON cart.product_id = product_variations.product_id
                INNER JOIN users ON cart.user_id = users.user_id
                WHERE cart.user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Update cart count
        $cart_count = count($products);
        
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: login_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4M Online Store</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/customer_dash.php">
                <img src="images/Logo.png" width="125">
            </a>
        </div>
        <nav id="menuItems">
            <ul>
                <li><a href="http://localhost/E-commerce/customer_dash.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="http://localhost/E-commerce/my_orders.php">My Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
            </ul>
        </nav>

        <div class="setting-sec">
            <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
                <!-- <img src="images/profile-icon.png" width="30px" height="30px" class="icon"> -->
            </a>
            <div class="cart-sec">
                <a href="http://localhost/E-commerce/cart-view.php">
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                    <img src="images/cart.png" width="30px" height="30px">
                </a>
            </div>
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
    </div>
</div>
<div class="cart-wrapper">   
    <form action="checkout.php" method="POST">
        <table>
            <!-- <h1 style="text-align:center;" class="page-header">YOUR CART</h1> -->
            <tr>
                <th></th>
                <th>Photo</th>
                <th>Name</th>
                <th>Price</th>
                <th width="20%">Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
            <?php 
                $total = 0;
                foreach ($products as $product) : 
                   // Check if product exists and is in stock
                   if ($product['product_id'] && $product['stock'] > 0) {
                    //price based on role
                    $price = ($product['role'] === 'Retail_Customer') ? $product['retail_price'] : $product['discounted_price'];
                    $subtotal = $price * $product['quantity'];
                    $total += $subtotal;
            ?>
            <tr>
                <td><input type="checkbox" name="selectedItems[]" value="<?php echo $product['cart_id']; ?>"></td>
                <td><img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" style="max-width: 50px; max-height: 50px;"></td>
                <td><?php echo $product['prod_name']; ?></td>
                <td class="price" id="price_<?php echo $product['cart_id']; ?>">₱<?php echo number_format($price, 2); ?></td> 
                <td class='input-group'>
                    <span class='input-group-btn'>
                        <button type='button' class='btn btn-default btn-flat minus' data-id='<?php echo $product['cart_id']; ?>'><i class='fa fa-minus'></i></button>
                    </span>
                        <input type='text' class='form-control' style="width: 30px; max-width: 100px; text-align: center;" value='<?php echo $product['quantity']; ?>' id='qty_<?php echo $product['cart_id']; ?>'>
                    <span class='input-group-btn'>
                        <button type='button' class='btn btn-default btn-flat add' data-id='<?php echo $product['cart_id']; ?>' data-stock='<?php echo $product['stock']; ?>'><i class='fa fa-plus'></i></button>
                    </span>
                    <span class="stock-label">Stock:</span>
                    <span class="stock"><?php echo $product['stock']; ?></span>
                </td>
                <td class="subtotal" id="subtotal_<?php echo $product['cart_id']; ?>">₱<?php echo number_format($subtotal, 2); ?></td>
                <td><button class="btn-remove" data-id='<?php echo $product['cart_id']; ?>'>Remove</button></td>
            </tr>
            <?php
                } elseif ($product['product_id'] && $product['stock'] <= 0) {
            ?>
            <tr>
            <td><input type="checkbox" name="selectedItems[]" value="<?php echo $product['cart_id']; ?>" disabled></td>
                <td><img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" style="max-width: 50px; max-height: 50px;"></td>
                <td><?php echo $product['prod_name']; ?></td>
                <td colspan="3" style= "color: red;">This item is currently unavailable.</td>
                <td><button class="btn-remove" data-id='<?php echo $product['cart_id']; ?>'>Remove</button></td>
            </tr>
            <?php }endforeach; ?>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                <td id="total">₱<?php echo number_format($total, 2); ?></td>
                    <td></td> 
            </tr>
        </table>
            <button type="submit" id="checkout-btn">Checkout</button>
    </form> 
</div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                <img src="images/logo2.png" width="100px" height="60px">
                </div>
                <div class="footer-col-2">
                <p>&copy; <?php echo date('Y'); ?> 4M Minimart Online Store. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

<script>
var MenuItems = document.getElementById("MenuItems");
function menutoggle() {
        menuItems.classList.toggle("show");
    }
// MenuItems.style.maxHeight = "0px";
// function menutoggle() {
//     if (MenuItems.style.maxHeight =="0px")
//     {
//         MenuItems.style.maxHeight = "200px";
//     }
//     else{
//         MenuItems.style.maxHeight = "0px";
//     }
// }
function getDetails() {
    $.ajax({
    type: 'POST',
    url: 'cart-details.php',
    dataType: 'json',
    success: function(response) {
        if (!response.error) {
        var html = '';
        if (!response.error) {
                var html = '';
                var totalPrice = 0;
                for (var i = 0; i < response.length; i++) {
                    var price = (response[i].role === 'Retail_Customer') ? response[i].retail_price : response[i].discounted_price;
                    var subtotal = price * response[i].quantity;
                    totalPrice += subtotal;
                    html += '<tr>';
                    html += '<td>' + response[i].cart_id + '</td>'; 
                    html += '<td>' + response[i].photo + '</td>';
                    html += '<td>' + response[i].name + '</td>';
                    html += '<td>' + price.toFixed(2) + '</td>';
                    html += '<td>' + response[i].quantity + '</td>';
                    html += '<td>' + subtotal.toFixed(2) + '</td>';
                    html += '</tr>';
                }
                $('#tbody').html(html);
                $('#total').text('₱' + totalPrice.toFixed(2));
            } else {
                console.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' - ' + error);
        }
    });
}

$(document).ready(function() {
    getDetails();
});
</script>

<script>
$(function(){
    $(document).on('click', '.btn-remove', function(e){
        e.preventDefault(); 
        var cartId = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'cart-del.php',
            data: {cart_id: cartId},
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(!response.error){
                    $('#subtotal_' + cartId).closest('tr').remove();
                    getTotal(); 
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + ' - ' + error); 
            }
        });
    });

    $(document).on('click', '.minus, .add', function(e){
        e.preventDefault();
        var cartId = $(this).data('id');
        var qtyInput = $('#qty_'+ cartId);
        var qty = parseInt(qtyInput.val());
        var stock = parseInt($(this).data('stock')); 

        if ($(this).hasClass('add')) {
            if (qty < stock) { 
                qty++;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot add more.',
                    text: 'Stock limit reached.',
                    confirmButtonText: 'OK'
                });
                return;
            }
        } else {
            if (qty > 1) {
                qty--;
            } else {
                return;
            }
        }

        qtyInput.val(qty); 

        updateQuantity(cartId, qty);
    });
});
   
function updateQuantity(cartId, qty){
    $.ajax({
        type: 'POST',
        url: 'cart-qty.php',
        data: {
            cart_id: cartId,
            quantity: qty
        },
        dataType: 'json',
        success: function(response){
            if(!response.error && response.hasOwnProperty('subtotal') && response.hasOwnProperty('total') && response.hasOwnProperty('price')){
                $('#subtotal_' + cartId).text('₱' + response.subtotal.toFixed(2)); 
                $('#total').text('₱' + response.total.toFixed(2)); 
                $('#price_' + cartId).text('₱' + response.price.toFixed(2)); 
                 getDetails() ;
                 //console.log()
            } else {
                console.error('Unexpected response format or missing fields:', response); 
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' - ' + error); 
        }
    });
}

function getTotal(){
    $.ajax({
        type: 'GET',
        url: 'cart-total.php',
        dataType: 'json',
        success:function(response){
            console.log('Response from server:', response); 
            if (response && response.total !== undefined) {
                $('#total').text('₱' + response.total.toFixed(2));  
            } else {
                console.error('Invalid total value:', response.total);
            }
        },
        error:function(xhr, status, error){
            console.error('Error fetching total:', status, error); 
        }
    });
}

// function removeProduct(cartId) {
//     $.ajax({
//         type: 'POST',
//         url: '',
//         data: {
//             cart_id: cartId
//         },
//         dataType: 'json',
//         success: function(response) {
//             if (!response.error) {
//                 $('#row_' + cartId).remove();
//                 $('#total').text('₱' + response.total.toFixed(2));
//             } else {
//                 console.error(response.message);
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error('AJAX Error: ' + status + ' - ' + error);
//         }
//     });
// }
</script>

<script>
$('#checkout-btn').on('click', function(){
    var selectedItems = $('.item-checkbox:checked').map(function(){
        return $(this).data('id');
    }).get();
    console.log(selectedItems); 
    $('#selected-items').val(selectedItems);
    $('form').submit();
});
</script>

</body>
</html>