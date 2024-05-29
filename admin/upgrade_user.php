<?php
require '../DB/db_con.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    try {
        $sql = "UPDATE users SET role = 'Wholesale_Customer' WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $sql_user = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;              
        $mail->Username   = '4m.minimart.2024@gmail.com'; 
        $mail->Password   = 'cpqgvpidtzocvpsi';   
        $mail->SMTPSecure = 'tls';             
        $mail->Port       = 587;              

        $mail->setFrom('4m.minimart.2024@gmail.com', '4M Minimart');
        $mail->addAddress($user['email'], $user['first_name']);
        $mail->Subject = 'Account Upgrade Notification';
        $mail->Body    = 'Hello ' . $user['first_name'] . ', your account has been upgraded to Wholesale Customer. Thank you! and Enjoy Shopping';

        $mail->send();

        header("Location: user.php");
        exit();
    } catch (PDOException $e) {
        die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
