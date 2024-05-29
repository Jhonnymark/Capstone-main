<?php
require 'DB/db_con.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $resetCode = generateResetCode(); 

        $stmt = $pdo->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
        $stmt->execute([$resetCode, $email]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = '4m.minimart.2024@gmail.com';
            $mail->Password = 'cpqgvpidtzocvpsi';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('4m.minimart.2024@gmail.com', '4M Minimart');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body = 'Your verification code is: ' . $resetCode;

            $mail->send();
            header("Location: reset-pass-verify.php?email=" . $email);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found.";
    }
}

function generateResetCode() {
    return rand(100000, 999999);
}
?>
