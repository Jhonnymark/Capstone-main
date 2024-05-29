<?php
require 'DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
     
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $pdo->prepare($sql);
        $exec = $stmt->execute(array($email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // var_dump($user);
            // var_dump($email, $password);

            if ($user['status'] === 'verified') {
            $ismatch = password_verify($password, $user['password']);

            if ($ismatch) {
                session_start();
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];

                switch ($user['role']) {
                    case 'Admin':
                        header("location: http://localhost/E-commerce/admin/admin_dash.php");
                        break;
                    case 'Retail_Customer':
                    case 'Wholesale_Customer': 
                        header("location: customer_dash.php");
                        break;
                    case 'Staff':
                        header("location: http://localhost/E-commerce/staff/staff_dash.php");  
                        break;
                    case 'Delivery_personnel':
                        header("location: http://localhost/E-commerce/delivery-staff/delivery_dash.php");  
                        break;
                    default:
                      
                        break;
                }
                exit();
            } else {
                header("location: login_form.php?error=IncorrectEmailorPassword");
                exit();
            }
        } else {
            header("location: login_form.php?error=UserNotFound");
            exit();
        }
    } else {
        header("location: login_form.php?error=PleaseProvideAValidEmailAndPassword");
        exit();
    }
} else {
    header("location: index.php");
    exit();
}
}
?>
