<?php
require '../DB/db_con.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    try {
        // Fetch the current role of the user
        $sql_user = "SELECT * FROM users WHERE user_id = :user_id";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

        // Determine the new role
        $new_role = ($user['role'] == 'Retail_Customer') ? 'Wholesale_Customer' : 'Retail_Customer';

        // Update the user's role
        $sql = "UPDATE users SET role = :new_role WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':new_role', $new_role, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Send notification email to the user
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '4m.minimart.2024@gmail.com';
        $mail->Password = 'cpqgvpidtzocvpsi';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('4m.minimart.2024@gmail.com', '4M Minimart');
        $mail->addAddress($user['email'], $user['first_name']);
        $mail->Subject = 'Account Role Change Notification';
        $mail->Body = 'Hello ' . $user['first_name'] . ', your account role has been changed to ' . $new_role . '. Thank you and enjoy shopping!';

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
