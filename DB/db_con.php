<?php
$driver = "mysql";
$host = "localhost";
$dbname = "minimart";
$charset = "utf8mb4";
$username = "root";
$password = '';
$option = [];


$dsn = "$driver:host=$host;dbname=$dbname;charset=$charset";

 try{
    $pdo = new PDO ($dsn, $username, $password, $option);
    
    if ($pdo)
        echo "";
 }
    catch(PDOException $e){
        echo $e;
    }
 
?>
