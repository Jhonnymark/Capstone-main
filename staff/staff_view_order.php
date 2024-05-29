<?php
require '../DB/db_con.php';
session_start();

if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    try {
        $sql = "SELECT *
        FROM orders
        INNER JOIN orders_details ON orders.order_id = orders_details.order_id
        INNER JOIN products ON orders_details.product_id = products.product_id
        INNER JOIN users ON orders.user_id = users.user_id
        WHERE orders.order_id = :order_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../scss/style.scss">
</head>
<style>
 
.status {
    flex: 1;
    text-align: center;
    font-size: 20px;
}
.status a {
    text-decoration: none;
    color: black; 
}
.status a:hover {
    color: red; 
}
table {
    width: 90%;
    border-collapse: collapse;
    margin: auto;
    display: flex;
    justify-content: center;
    margin-top: 20px;
    margin-bottom: 30px;
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
.btn {
    display: inline-block;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-left: 40%;
}
.btn:hover {
    background-color: #45a049;
}
.order-container {
    min-height: calc(100% - 256px);
}
.order-container{
    .container{
      max-width: 100%;
      height: max-content;
      position: relative;
      display: flex;
      justify-content: center;
      top: 10%;
      right: 0%;
      width: 100%;
      height: 100%;
      margin: 0 auto;
      .ebadge-wrapper{
        margin-top: 100px;
        .row1{
          flex-grow: 1;
          display: flex;
          align-items: center;
          gap: 5rem;
          
          .small-box-1 {
            background: #81d381;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
            &:nth-child(1) {
              background-color: rgb(76, 245, 61);
            }
            &:nth-child(2) {
              background-color: rgb(20, 122, 239);
            }
            &:nth-child(3) {
              background-color: rgb(233, 236, 31);
            }
            .badge{
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 20px;
              margin-bottom: 20px;
              .inner{
                text-align: center;
                h3{
                  font-size: 36px;
                  margin: 0;
                  color: #333;
                }
                p{
                  margin: 0px;
                  color: black;
                }
              }
              .icon {
                font-size: 48px;
                color: black;
              }
            }
          }
        }
      }
    }
  }

</style>
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
                    <!-- <li><a href="staff_view_order.php">Manage Orders</a></li> -->
                </ul>
            </nav>
            <div class="setting-sec">
                <a href="http://localhost/E-commerce/Account.php">
                <i class="fa-solid fa-user"></i>
                </a>
                <img src="../images/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
        </div>
    </div>


<div class="order-container">
<?php if (!empty($orders)) : ?>
        <h2 style="text-align: center;">Order ID: <?php echo $orders[0]['order_id']; ?> - Customer: <?php echo $orders[0]['first_name'] . ' ' . $orders[0]['last_name']; ?></h2>
    <?php endif; ?>

    <!-- <div class="status">
        <?php if (isset($_GET['order_id'])) : ?>
            <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=Pending" <?php echo ($_GET['status'] ?? '') === 'Pending' ? 'class="selected"' : ''; ?>>Pending</a> |
            <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=ToShip" <?php echo ($_GET['status'] ?? '') === 'ToShip' ? 'class="selected"' : ''; ?>>To Ship</a> |
            <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=ToReceive" <?php echo ($_GET['status'] ?? '') === 'ToReceive' ? 'class="selected"' : ''; ?>>To Receive</a> |
            <a href="staff_view_order.php?order_id=<?php echo $order_id; ?>&status=Completed" <?php echo ($_GET['status'] ?? '') === 'Completed' ? 'class="selected"' : ''; ?>>Completed</a>
        
        <?php else : ?>
            <a href="staff_view_order.php?status=Pending">Pending</a> |
            <a href="staff_view_order.php?status=ToShip">To Ship</a> |
            <a href="staff_view_order.php?status=ToReceive">To Receive</a> |
            <a href="staff_view_order.php?status=Completed">Completed</a>
        <?php endif; ?>
    </div> -->

    
    <?php if (empty($orders)) : ?>
        <p style="text-align: center; margin-top: 20px;">No orders found for the selected status.</p>
        <div style="text-align: center; margin-bottom: 20px;">
    <?php else : ?>
              
    <table>
        <tr>
            <th>Product Name</th>
            <th>Name</th>
            <th>Date Ordered</th>
            <th>Total Price</th>
            <!-- <th>Status</th>
            <th>Date Receive</th> -->
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?php echo $order['prod_name']; ?></td>
                <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                <!-- <td><?php echo $order['date_ordered']; ?></td> -->
                <td>
                    <?php 
                        $dateOrdered = new DateTime($order['date_ordered']);
                        echo $dateOrdered->format('F j, Y g:i a');
                    ?>
                </td>
                <td><?php echo $order['total_price']; ?></td>
                <!-- <td><?php echo $order['order_status']; ?></td> -->
                <!-- <td><?php echo $order['order_status'] == 'Completed' ? ($order['date_received'] ?? 'Not received yet') : ''; ?></td> -->
                <!-- <td><?php echo $order['order_status'] == 'Completed' ? ($order['date_received'] ?? 'Not received yet') : 'Not received yet'; ?></td> -->

        <td>
            <form action="update_order.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                <select name="status">
                    <?php if ($order['order_status'] == 'Pending') : ?>
                        <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="ToShip">To Ship</option>
                        <option value="ToReceive">To Receive</option>
                    <?php elseif ($order['order_status'] == 'ToShip') : ?>
                        <option value="ToReceive">To Receive</option>
                        <!-- <option value="Completed">Completed</option> -->
                    <?php elseif ($order['order_status'] == 'ToReceive') : ?>
                        <!-- <option value="Completed">Completed</option> -->
                    <?php endif; ?>
                </select>
                <button type="submit" name="update_order">
                <i class="fa-solid fa-save"></i>
                    <!-- <i class="fa-solid fa-sync-alt"></i>  -->
                </button>
            </form>

            </td>
        </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="generate_receipt.php?order_id=<?php echo $order_id; ?>" class="btn">Generate Receipt</a>
    <?php endif; ?>
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
</html>
</body>
