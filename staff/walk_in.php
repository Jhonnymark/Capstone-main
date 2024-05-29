<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>   
        .walkin-container {
            display: flex;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .sales-entry-container {
            width: 100%;
            max-width: 40%;
            padding: 20px;
            /* margin-left: 80px;  */
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        select#order-type {
            /* margin-left: 28rem; */
            margin-left: auto;
            width: 100px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            margin-top: 20px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        #suggestions, #product-suggestions {
            border: 1px solid #ccc;
            max-height: 100px;
            overflow-y: auto;
            position: absolute;
            width: 37%; 
            background-color: #fff;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }
        #suggestions li,  #product-suggestions li {
            list-style: none;
            padding: 8px;
            cursor: pointer;
        }
        #suggestions li:hover,  #product-suggestions li:hover {
            background-color: #f0f0f0;
        }
        .prod-qty {
            display: flex;
            flex-direction: column;
        }
        .product-quantity {
            display: flex;
            justify-content: space-between;
        }
        input#quantity {
            height: 10px;
            width: 50px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .btn-enter {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 10px;
        }
        .btn-submit {
            display: flex;
            justify-content: flex-end;
        }
        .receipt {
            width: 100%;
            max-width: 40%;
            margin: 20px auto;
            /* margin-left: 20px;  */
            border: 1px solid #ccc;
            padding: 10px;
            max-height: auto;
            overflow-y: auto;
            font-family: Arial, sans-serif; 
        }
        .receipt h2 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .receipt .customer-name {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .receipt table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt th, .receipt td {
            /* border: 1px solid #ccc; */
            padding: 8px;
            text-align: left;
        }
        .receipt th {
            background-color: #f9f9f9;
        }
        h4#total-amount {
            text-align: right;
            font-weight: bold;
            margin-right: 10px;
        }


        @media screen and (max-width: 768px) {
            .walkin-container {
                flex-direction: column;
            }
            select#order-type {
                    margin-left: 14rem;
                    width: 100px;
                }
            .receipt {
                margin-left: 0;
                margin-top: 20px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="staff-container">
        <div class="navbar">
            <div class="logo">
                <a href="http://localhost/E-commerce/staff/staff_dash.php">
                    <img src="../images/Logo.png" class="pic" width="125">
                </a>
            </div>
            <nav id="menuItems">
                <ul>
                    <!-- <li><a href="http://localhost/E-commerce/staff/staff_dash.php">Dashboards</a></li> -->
                    <!-- <li><a href="staff_view_order.php">View Orders</a></li> -->
                </ul>
            </nav>
                
            <div class="setting-sec">
                <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
                <!-- <img src="images/profile-icon.png" width="30px" height="30px" class="icon"> -->
                </a>
                <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>

    <div class="walkin-container">
        <div class="sales-entry-container">
            <div class="form-header">
                <h1>Create Order</h1>
            </div>
            
            <form id="order-form" action="walkin_process.php" method="POST">

                <select id="order-type" name="order-type">
                    <option value="retail">Retail</option>
                    <option value="wholesale">Wholesale</option>
                </select>
                <label for="customer-name">Customer Name:</label>
                <input type="text" id="customer-name" name="customer-name" autocomplete="off" disabled>
                <ul id="suggestions"></ul>

                <label for="category">Category:</label>
                <select id="category" name="category" disabled>
                    <option value="0">All</option> 
                </select>

                <div class="prod-qty">
                    <div class="product-input">
                        <label for="product">Product:</label>
                        <input type="text" id="product" name="product" autocomplete="off" disabled>
                        <ul id="product-suggestions"></ul>
                    </div>

                    <div class="product-quantity">
                        <div class="quantity-input">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1">
                        </div>
                        <div class="btn-enter">
                            <button type="button" id="enter-button">Enter</button>
                        </div>
                    </div>
                </div>
                
                <div class="btn-submit">
                    <button type="submit">Create Order</button>
                </div>
            </form>
        </div>

        <div class="receipt" id="receipt">
            <h2>Receipt</h2>
            <!-- <ul id="receipt-list"></ul> -->
            <div class="customer-name" id="customer-name-receipt"></div>
            <table>
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="receipt-list"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right"><strong>Total Amount:</strong></td>
                        <td id="total-amount">0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <img src="../images/logo2.png" width="100px" height="60px">
                </div>
                <div class="footer-col-2">
                    <p>&copy; <?php echo date('Y'); ?> 4M Minimart Online Store. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <script>
        $(document).ready(function() {
            let items = [];

            $('#order-type').change(function() {
                $('#customer-name').val('');
                $('#suggestions').fadeOut();
                $('#category').empty().prop('disabled', true);
                $('#product').val('').prop('disabled', true);
                $('button[type="submit"]').prop('disabled', true);
                if ($(this).val() !== '') {
                    $('#customer-name').prop('disabled', false);
                } else {
                    $('#customer-name').prop('disabled', true);
                }
            });

            $('#customer-name').on('input', function() {
                let query = $(this).val();
                let type = $('#order-type').val();
                if (query.length > 0 && type) {
                    $.ajax({
                        url: 'fetch_customers.php',
                        method: 'POST',
                        data: { query: query, type: type },
                        success: function(data) {
                            $('#suggestions').fadeIn();
                            $('#suggestions').html(data);
                        }
                    });
                } else {
                    $('#suggestions').fadeOut();
                }
            });

            $(document).on('click', '#suggestions li', function() {
                let customerName = $(this).text();
                let userId = $(this).data('id');

                $('#customer-name').val(customerName); 
                $('#user-id').val(userId);
                $('#suggestions').fadeOut();
                $('#category').prop('disabled', false);
                $.ajax({
                    url: 'fetch_categories.php', 
                    method: 'GET',
                    success: function(data) {
                        $('#category').html('<option value="0">All</option>' + data); 
                    }
                });

                displayCustomerNameOnReceipt(customerName);
            });

            $('#category').change(function() {
                let categoryId = $(this).val();
                if (categoryId !== '0') {
                    $('#product').prop('disabled', false); 
                    $('#product').trigger('input');
                } else {
                    $('#product').val('').prop('disabled', true); 
                    $('#product-suggestions').fadeOut(); 
                }
            });

            $('#product').on('input', function() {
                let query = $(this).val().trim();
                if (query.length > 0) {
                    let type = $('#order-type').val();
                    let categoryId = $('#category').val();
                    $.ajax({
                        url: 'fetch_prod.php',
                        method: 'POST',
                        data: { type: type, categoryId: categoryId, query: query },
                        success: function(data) {
                            $('#product-suggestions').fadeIn();
                            $('#product-suggestions').html(data); 
                        }
                    });
                } else {
                    $('#product-suggestions').fadeOut();
                }
            });

            $(document).on('click', '#product-suggestions li', function() {
                // let productName = $(this).text();
                let productName = $(this).text().split(' (')[0];
                let productPrice = $(this).data('price');
                let productStock = $(this).data('stock');
                $('#product').val(productName).data('price', productPrice).data('stock', productStock);
                $('#product-suggestions').fadeOut();

                if (productStock > 0) {
                    $('#quantity').prop('max', productStock).val(1).prop('disabled', false);
                    $('#enter-button').prop('disabled', false);
                } else {
                    $('#quantity').prop('disabled', true).val(0);
                    $('#enter-button').prop('disabled', true);
                    
                    alert('Out of Stock');
                }

                $('button[type="submit"]').prop('disabled', false);
            });

            $('#enter-button').on('click', function() {
                let productName = $('#product').val();
                let productPrice = parseFloat($('#product').data('price'));
                let quantity = parseInt($('#quantity').val());
                let stock = parseInt($('#product').data('stock'));

                if (quantity > stock) {
                    alert('Quantity exceeds available stock');
                    return;
                }

                items.push({ product: productName, quantity: quantity, price: productPrice });

                displayOnReceipt(productName, quantity, productPrice);

                $('#product').val('');
                $('#quantity').val(1).prop('disabled', true);
                $('#enter-button').prop('disabled', true);

            });

            $('#order-form').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                formData.push({ name: 'items', value: JSON.stringify(items) });

                let selectedCustomerName = $('#customer-name').val();
                formData.push({ name: 'customer-name', value: selectedCustomerName });

                $.ajax({
                    url: $(this).attr('action'), 
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        alert('Order successfully processed!');
                        window.location.href = 'staff_dash.php';
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); 
                        alert('Error processing order');
                    }
                });
            });

            function displayCustomerNameOnReceipt(customerName) {
                $('#customer-name-receipt').text(`${customerName}`);
            }
        });

        // document.getElementById('enter-button').addEventListener('click', function() {
        //     displayOnReceipt();
        // });

        // function displayOnReceipt() {
        //     let customerName = $('#customer-name').val();
        //     let product = $('#product').val();
        //     let price = parseFloat($('#product').data('price'));
        //     let quantity = parseInt($('#quantity').val());
        //     let stock = parseInt($('#product').data('stock'));
        //     let subtotal = price * quantity;

        //     if (quantity > stock) {
        //         alert('Quantity exceeds available stock');
        //         return;
        //     }
        //     let newRow = `<tr>
        //         <td>${quantity}</td>
        //         <td>${product}</td>
        //         <td>${price.toFixed(2)}</td>
        //         <td>${subtotal.toFixed(2)}</td>
        //     </tr>`;

        //     $('#receipt-list').append(newRow);

        //     let totalAmount = parseFloat($('#total-amount').text());
        //     totalAmount += subtotal;
        //     $('#total-amount').text(totalAmount.toFixed(2));

        function displayOnReceipt(product, quantity, price) {
        let subtotal = price * quantity;
        let newRow = `<tr>
            <td>${quantity}</td>
            <td>${product}</td>
            <td>${price.toFixed(2)}</td>
            <td>${subtotal.toFixed(2)}</td>
        </tr>`;

        $('#receipt-list').append(newRow);

        let totalAmount = parseFloat($('#total-amount').text());
        totalAmount += subtotal;
        $('#total-amount').text(totalAmount.toFixed(2));

            // Reset the quantity input field
            $('#quantity').val(1);
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                displayOnReceipt();
            }
        });
    </script> 
</body>
</html>
