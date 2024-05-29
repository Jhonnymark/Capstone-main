<?php
require __DIR__ . '/DB/db_con.php';

$page 	 = isset( $_GET['page'] ) ? (int) $_GET['page'] : 1;
$perPage = isset( $_GET['per-page'] ) && $_GET['per-page'] <= 50 ? (int) $_GET['per-page'] : 8;
$start = ( $page > 1 ) ? ( $page * $perPage ) - $perPage : 0;

$query = $pdo->prepare("SELECT  SQL_CALC_FOUND_ROWS * FROM products LIMIT {$start}, {$perPage}");
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

$total = $pdo->query( "SELECT FOUND_ROWS() as total" )->fetch()['total'];
$pages = ceil( $total / $perPage );

if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $sql = "SELECT * FROM `products` WHERE `prod_name` LIKE ? OR `prod_price` LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$keyword%", "%$keyword%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}
.navbar{
    display: flex;
    align-items: center;
    padding: 5px;
    /* border: 2px solid black */
}
nav{
    flex: 1;
    text-align: center;
    font-size: 20px;
}
nav ul{
    display: inline-block;
    list-style-type: none;
    
}
nav ul li{
    display: inline-block;
    margin-right: 20px;
    font-size: bold;
}
a{
    text-decoration: none;
    color: #000000;
    font-weight: bold;
}
header {
    text-align: left;
    padding: 20px 0;
    height: 50vh;
    width: 100%; 
    background-image: url('images/grocery.jpg');
    background-size: cover;
    background-position: center;
    border: 4px solid red;
}
div {
    margin: 15px;
}
label.search {
    margin-left: 630px;
}
img.icon {
    margin: 0 20px;
}
.col-2{
    flex-basis: 50%;
    min-width: 300px;
}
.col-2 h1{
    font-size: 50px;
    line-height: 60px;
    margin: 25px 0;
    margin-left: 30px;
    color: red;
    -webkit-text-stroke: 2px yellow;
}
.content {
    max-width: 1200px;
    margin: 0 auto;
}
.product-list {
    display: flex;  
    flex-wrap: wrap;
    justify-content: space-between;
}
.product-item {
    width: 22%;
    margin: 5px;
    margin-bottom: 20px;
    box-sizing: border-box;
    border: 1px solid #cf9292;
    padding: 10px;
    border-radius: 5px;
}
img.prod-img {
    max-width: 100%;
    max-height: 100%;
}
button {
    background-color: #cf9292;
    color: #080808;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    margin-left: 10px;
}
.details {
    background: #cf9292;
    color: #080808;
    padding: 0 6px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
}
a.btn-shop{
    display: inline-block;
    background: #f05d5d;
    color: #fff;
    padding: 8px 30px;
    margin-left: 30px;
    border-radius: 30px;
    transition: background 0.5s;
} 
.categories{
    margin: 70px 0;
}
.col-3{
    flex-basis: 30%;
    min-width: 250px;
    margin-bottom: 30px;
}
.col-3 img{
    width: 100%;
}
.small-container{
    max-width: 1080px;
    margin: auto;
    padding-left: 25px;
    padding-right: 25px;
}
.col-4{
    flex-basis: 25%;
    padding: 10px;
    min-width: 200px;
    margin-bottom: 50px;
    transition: transform 0.5s;
}
.col-4 img{
    width: 100%;
}
.title{
    text-align: center;
    margin: 0 auto 80px;
    position: relative;
    line-height: 60px;
    color: #555;
}
.title::after{
    content: '';
    background: #ff523b;
    width: 80px;
    height: 5px;
    border-radius: 5px;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
}
.h4{
    color: #555;
    font-weight: normal;
}
.col-4 p{
    font-size: 14px;
}
.col-4:hover{
    transform: translateY(-5px);
}
footer {
    /* border: 5px solid #000000; */
    width: 100%;
}   
.footer-col-1 img {
    width: 180px;
    bottom: 20px;
}
.footer-col-2{
    text-align: center;
    font-weight: bold;
}
.row {
    display: flex; 
    justify-content: space-evenly;
}
.menu-icon{
    width: 30px;
    margin-left: 20px;
    display: none;
}

.pagination {
  display: inline-block;
}
.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  border: 3px solid #dddded;
}
.col-md-12{
    padding-right: 500px;
}
.pagination a:hover{
  background-color: #ddc8c5;
  border-radius: 5px;
}

/*--media qyuery for menu---*/

@media only screen and (max-width: 800px){
    nav ul{
        position: absolute;
        top: 70px;
        left: 0;
        background: #e4b8b8;
        width: 100%;
        overflow: hidden;
        transition: max-height 0.5s;
    }
    nav ul li{
        display: block;
        margin-right: 50px;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    nav ul li a{
        color: #000000;
        font-weight: bold;
    }
    .menu-icon{
        display: block;
        cursor: pointer;
    }
}

/* media query for less than 600 screen size */
@media only screen and (max-width: 600px){
    .row{
        text-align: center;
    }
    .col-2, .col-3, .col-4{
        flex-basis: 100%;
    }
}
</style>
<div class="navbar">
            <div class="logo">
                <img src="images/Logo.png" width="125">
            </div>
            <nav>
            <ul id="MenuItems">
                <li><a href="customer_dash.php">Home</a></li>
                <li><a href="">Products</a></li>
                <li><a href="">My Orders</a></li>
                <li><a href="http://localhost/E-commerce/admin/about.php">About</a></li>
                <!-- <li><a href="">Account</a></li> -->
                <form method="post" action="search.php">
                    <li>
                        <input type="search" class="form-control" name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" placeholder="Search here..." required=""/>
                        <button type="submit" class="btn btn-success" name="search">Search</button>
                    </li>
                </form>

            </ul>
            </nav>
            <!-- <a href="http://localhost/E-commerce/Account.php">
            <img src="images/profile-icon.png" width="30px" height="30px" class="icon">
            </a> -->
            <a href="">
            <img src="images/cart.png" width="30px" height="30px">
            </a>
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    <header>
    <div class="col-2">
        <h1>Welcome! <br> to 4M Minimart <br>Online Store</h1>
        <a href="register_form.php" class="btn-shop">Shop Now &#8594;</a>
    </header>

</div>

<div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img src="images/upload/<?php echo $product['photo']; ?>" alt="Product Photo" class="prod-img">
            <!-- <h3 style="text-align: center;"><?php echo $product['prod_name']; ?></h3> -->
                <h3 style="text-align: center;">
                <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                    <?php echo $product['prod_name']; ?>
                </a>
                </h3>
                <p>Price: ₱ <?php echo number_format($product['prod_price'], 2); ?></p>
                <p>Stock: <?php echo number_format($product['stock']); ?></p>
                <!-- 
                <a href="login_form.php?product_id=<?php echo $product['product_id']; ?>" class="details">
                    <i class="fa fa-eye"></i> 
                </a> -->
            </div>
        <?php endforeach; ?>
        <div class="search-results">
        </div>
    <div class="col-md-12">
        <div class="well well-sm">
            <div class="paginate">
                <?php for ( $x=1; $x <= $pages; $x++ ): ?>
                <div class="pagination">
                    <a href="?page=<?php echo $x; ?>&per-page=<?php echo $perPage; ?>">
                        <?php echo $x; ?>
                    </a>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    </div>
<?php
} else {
    $sql = "SELECT * FROM `products`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
?>
    <table class="table table-bordered">
        <thead class="alert-info">
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><img src="images/upload/<?php echo $row['photo']; ?>" alt="Product Photo" class="prod-img"></td>
                <td><?php echo $row['prod_name']; ?></td>
                <td><?php echo $row['prod_price']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php
}
$pdo = null; 
?>
