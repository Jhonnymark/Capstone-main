<?php
require '../DB/db_con.php';

try {
    // Retrieve promo data from the database
    $sql = "SELECT * FROM promo";
    $stmt = $pdo->query($sql);
    $promos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("PDOException: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Function to determine if a promo is active based on its start and end dates
function isPromoActive($start_date, $end_date) {
    $current_date = date('Y-m-d');
    return ($current_date >= $start_date && $current_date <= $end_date);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
    a{
    text-decoration: none;
    color: #000000;
    font-weight: bold;
    }
    table {
        width: 90%;
        border-collapse: collapse;
        margin: 20px auto;
    }
    th, td {
        border: 1px solid #767575;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #9f7b7b;
        color: Black;
        text-align: center;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
    .edit-button,
    .btn-add, .btn-close {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        margin-right: 5px;
    }
    .edit-button {
        background-color: #cf9292;
        color: white;
    }
    .edit-button:hover {
        background-color: #2ecc71;
    }
    .btn-add{
        background-color: #cf9292;
        padding: 2px 10px;
        margin-left:70px;
    }
    .btn-add:hover{
        background-color: #2ecc71;
    }
    .btn-close {
        background-color: #cf9292;
        padding: 2px 10px;
    }
    label.search {
        margin-left: 500px;
    }
    .btn-close:hover {
        background-color: 2ecc71;
    }
    .fa {
        margin-left: 5px;
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale
    }
    form.search {
        display: contents;
    }
    select#select_category {
        margin-right: 38%;
    }
    button.btn.btn-sucess {
    background-color: #cf9292;
    color: #080808;
    padding: 8px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    margin-left: 10px;
}
    input.form-control {
        height: 30px;
        width: 18%;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .pagination a {
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
        margin: 0 4px;
    }
    .pagination a.active {
        background-color: #f05d5d;
        color: white;
        border: 1px solid #000;
    }
    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }
   h2{
    text-align: center;
   }
   .active-status {
            color: green;
        }

        .inactive-status {
            color: red;
        }
</style>
</head>
<body>
<div class="header">
<div class="navbar">
        <div class="logo">
            <a href="http://localhost/E-commerce/admin/admin_dash.php">
                <img src="../images/Logo.png" width="125">
            </a>
        </div>
        <nav id="menuItems">
        <ul>
        <li><a href="http://localhost/E-commerce/admin/admin_dash.php">Dashboards</a></li>
        <li><a href="http://localhost/E-commerce/admin/reports.php">Reports</a></li>
            <li><a href="http://localhost/E-commerce/admin/manage_order.php">Manage Orders</a></li>
            <li><a href="http://localhost/E-commerce/admin/products.php">Manage Products</a></li>
            <li><a href="http://localhost/E-commerce/admin/promo.php">Promo</a></li>
            <li><a href="http://localhost/E-commerce/admin/category.php">Manage Categories</a></li>
            <li><a href="http://localhost/E-commerce/admin/user.php">Manage Users</a></li>
            <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
        </ul>
        </nav>
        <div class="setting-sec">
            <a href="http://localhost/E-commerce/Account.php">
            <i class="fa-solid fa-user"></i>
            <!-- <img src="../images/profile-icon.png" width="30px" height="30px" class="icon"> -->
            </a>
        <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
    <div class="container1">
        <h2>Promos List</h2>
        <a href="http://localhost/E-commerce/admin/promo_manage.php" class="btn-add"> <i class="fa fa-plus"></i>New</a>
        <table>
            <thead>
                <tr>
                    <th>Minimum Spend</th>
                    <th>Discount Percentage</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promos as $promo): ?>
                    <tr>
                        <td><?php echo $promo['minimum_spend']; ?></td>
                        <td><?php echo $promo['discount_percentage']; ?></td>
                        <td><?php echo $promo['start_date']; ?></td>
                        <td><?php echo $promo['end_date']; ?></td>
                        <td class="<?php echo (isPromoActive($promo['start_date'], $promo['end_date']) ? 'active-status' : 'inactive-status'); ?>">
                    <?php echo (isPromoActive($promo['start_date'], $promo['end_date']) ? 'Active' : 'Inactive'); ?>
                </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
