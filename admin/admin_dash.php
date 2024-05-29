<?php 

require '../DB/db_con.php';

  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

// $today = date('Y-m-d');

$twoWeeksLater = date('Y-m-d', strtotime('+2 weeks'));
// Query to count products expiring within two weeks
$stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM products WHERE expiration_date BETWEEN :today AND :twoWeeksLater");
$stmt->execute(['today' => $today, 'twoWeeksLater' => $twoWeeksLater]);
$expiringProductCount = $stmt->fetchColumn();

$salesData = [];
$ordersData = [];
for ($month = 1; $month <= 12; $month++) {
    $sql = "SELECT SUM(total_price) AS total_sales, COUNT(order_id) AS total_orders 
            FROM orders 
            WHERE YEAR(date_received) = :year 
            AND MONTH(date_received) = :month";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['year' => $year, 'month' => $month]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $salesData[$month] = $result['total_sales'] ?? 0;
    $ordersData[$month] = $result['total_orders'] ?? 0;
}

?>
<?php
// Fetch data for the top 5 most selling categories from the database
$sql = "SELECT c.category_name, COUNT(*) AS total_sales 
        FROM orders o 
        INNER JOIN orders_details od ON o.order_id = od.order_id 
        INNER JOIN products p ON od.product_id = p.product_id 
        INNER JOIN category c ON p.category_id = c.category_id 
        WHERE YEAR(o.date_received) = :year 
        GROUP BY c.category_id 
        ORDER BY total_sales DESC 
        LIMIT 5"; // Change LIMIT to the number of categories you want to display
$stmt = $pdo->prepare($sql);
$stmt->execute(['year' => $year]);
$topSellingCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
// Get the start and end date of the current week
$startOfWeek = date('Y-m-d', strtotime('monday this week'));
$endOfWeek = date('Y-m-d', strtotime('sunday this week'));

try {
    $sql = "SELECT SUM(total_price) AS weekly_sales FROM orders WHERE date_received BETWEEN :startOfWeek AND :endOfWeek";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['startOfWeek' => $startOfWeek, 'endOfWeek' => $endOfWeek]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $weeklySales = $result['weekly_sales'] ?? 0;
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
    <style>
        .btn {
            margin-top: 10px;
            margin-left: 8.5rem;
            display: inline-block;
            background-color: #cf9292;
            color: white;
            padding: 10px 10px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2ecc71;
        }
        nav#menuItems ul li a:hover {
            color: red;
        }
        nav#menuItems ul li a.active {
            color: red;
        }
        .smallbox-con {
            display: flex;
            flex-direction: row;
            height: 200px;
            margin-top: 20px;
        }
        .small-box.small-box-5 {
            width: 10rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgb(2 2 2);
        }
        .small-box-5 .icon {
            font-size: 30px; 
        }
        .small-box-5 h3{
            font-size: 24px;
            margin-left: 40px;
        }
        .inner {
            margin: auto;
        }
        .small-box.small-box-2,  .small-box.small-box-3,  
        .small-box.small-box-1,  .small-box.small-box-4  {
            width: 22rem;
            box-shadow: 0px 0px 10px rgb(2 2 2);
        }
        .col-lg-3.col-xs-6 {
            width: 25%;
            padding: 10px;
        }
        .small-box {
            border-radius: 5px;
            padding: 15px;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .small-box:hover {
            transform: scale(1.05); 
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        }
        .small-box-2 .inner,  .small-box-3 .inner,
        .small-box-1 .inner, .small-box-4 .inner{
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .small-box-2 .icon, .small-box-3 .icon,
        .small-box-1 .icon, .small-box-4 .icon {
            font-size: 30px; 
            margin-right: 10px;
        }
        .small-box-2 p,  .small-box-3 p,
        .small-box-1 p,  .small-box-4 p   {
            font-size: 16px; 
            margin: 0 10px;
        }
        .small-box-2 h3, .small-box-3 h3,
        .small-box-1 h3, .small-box-4 h3 {
            font-size: 20px;
            margin: 0 10px;
        }
        .small-box-footer {
            color: #007bff;
            display: inline-block;
            margin-left: auto;
            text-decoration: none;
            font-size: 12px;
        }

        .small-box-footer i {
            margin-left: 5px;
        }
        .row-sale {
            flex: 0 0 25%; 
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .right-container {
            flex: 0 0 70%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .row1,
        .row2 {
            flex: 0 0 50%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 4rem;
        }
        .row1 {
            height: 100px;
        }
        .row2 {
            height: 100px;
        }
        .graph {
            display: flex;
            margin-top: 50px;
            justify-content: center; 
            gap: 20px;
            flex-wrap: wrap;
        }
        .row-bar,
        .row-pie {
            flex: 1 0 48%;
            display: flex;
            justify-content: center; 
            align-items: center;
        }
        .col-lg-6 {
            width: 50%;
        }
        
        @media (max-width: 767px) {
            .container {
                flex-direction: column;
            }
            .row-bar, .row-pie {
        f       lex: 1 0 100%;
            }
            .row-sale,
            .right-container,
            .row1,
            .row2,
            .row-bar,
            .row-pie {
                flex: 1 0 100%;
            }
        }
    </style>
</head>
<body>
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
            </a>
        <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>
<!-- end -->
<div class="smallbox-con">
    <div class= row-sale>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box small-box-5">
                <div class="inner">
                    <p>Weekly Sales</p>
                    <h3><?php echo $weeklySales; ?></h3>
                </div>
                <div class="icon" style="color: blue;">
                    <i class="fa fa-shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>
   
    <div class="right-container">
        <div class="row1">
            <!-- Total Products -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box small-box-2">
                    <div class="inner">
                        <div class="icon">
                            <a href="http://localhost/E-commerce/admin/products.php"><i class="fa fa-barcode" style="color: green;"></i></a>
                        </div>
                        <p>Total Products</p>
                        <?php
                            $stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM products");
                            $stmt->execute();
                            $prow = $stmt->fetch();
                            echo "<h3>".$prow['numrows']."</h3>";
                        ?>
                          <a href="http://localhost/E-commerce/admin/products.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Total Categories -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box small-box-3">
                    <div class="inner">
                        <div class="icon">
                            <a href="http://localhost/E-commerce/admin/category.php"><i class="fa fa-list-alt" style="color: violet;"></i></a>
                        </div>
                        <p>Total Categories</p>
                        <?php
                            $stmt = $pdo->prepare("SELECT COUNT(*) AS numrows FROM category");
                            $stmt->execute();
                            $crow = $stmt->fetch();
                            echo "<h3>".$crow['numrows']."</h3>";
                        ?>
                        <a href="http://localhost/E-commerce/admin/category.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row2">
            <!-- Total Orders -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box small-box-1">
                    <div class="inner">
                        <div class="icon">
                            <a href="http://localhost/E-commerce/admin/manage_order.php"> <i class="fa fa-shopping-cart" style="color: orange;"></i></a>
                        </div>
                        <p>Total Orders <br>(30 days)</p>
                        <?php
                            $currentMonth = date('m');
                            $currentYear = date('Y');

                            $sql = "SELECT COUNT(*) AS numrows FROM orders WHERE YEAR(date_received) = :year AND MONTH(date_received) = :month";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['year' => $currentYear, 'month' => $currentMonth]);
                            $orderCount = $stmt->fetchColumn();

                            echo "<h3>$orderCount</h3>";
                        ?>
                        <a href="http://localhost/E-commerce/admin/manage_order.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Total Expiring Products -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box small-box-4">
                    <div class="inner">
                        <div class="icon">
                            <a href="expiring_products.php"><i class="fa fa-exclamation-triangle" style="color: red;"></i></a>
                        </div>
                        <p>Products Expiring <br> Within 2 Weeks</p>
                        <h3><?php echo $expiringProductCount; ?></h3>
                        <a href="expiring_products.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <a href="generate_sales_report.php?order_id=<?php echo $order_id; ?>" class="btn">Generate Reports</a> -->
<div class="graph">
    <div class="row-bar">
        <div class="col-lg-6">
            <canvas id="salesLineGraph" width="800" height="400"></canvas>
        </div>
    </div>
    <div class="row-pie">
        <div class="col-lg-6">
            <canvas id="mostSellingCategoryPieChart"></canvas>
        </div>
    </div>
</div>

<!--footer-->
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
<!-- js for toggle menu -->

<script>

    var menuItems = document.getElementById("menuItems");
        function menutoggle() {
            menuItems.classList.toggle("show");
        }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    // Get sales and orders data from PHP
    var salesData = <?php echo json_encode(array_values($salesData)); ?>;
    var ordersData = <?php echo json_encode(array_values($ordersData)); ?>;
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    // Create line graph for sales and orders
    var ctx = document.getElementById('salesLineGraph').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Sales',
                data: salesData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Monthly Orders',
                data: ordersData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    // Get data for the top selling categories from PHP
    var topCategories = <?php echo json_encode($topSellingCategories); ?>;

    // Extract category names and total sales from the fetched data
    var categoryNames = [];
    var totalSales = [];
    topCategories.forEach(function(category) {
        categoryNames.push(category.category_name);
        totalSales.push(category.total_sales);
    });

    // Create pie chart
    var ctx = document.getElementById('mostSellingCategoryPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categoryNames,
            datasets: [{
                label: 'Sales by Category',
                data: totalSales,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 102, 0.6)',
                    'rgba(243, 15, 15, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 102, 1)',
                    'rgba(243, 15, 15, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>
</body>