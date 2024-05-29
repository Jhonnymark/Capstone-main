<?php
   require 'DB/db_con.php';

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   
   require 'phpmailer/src/Exception.php';
   require 'phpmailer/src/PHPMailer.php';
   require 'phpmailer/src/SMTP.php';
   
   function generateVerificationCode() {
       // Generate a random 6-digit verification code
       return rand(100000, 999999);
   }

   function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = '4m.minimart.2024@gmail.com';
    $mail->Password = 'cpqgvpidtzocvpsi';
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587;

    try {
        $mail->isSMTP();
        $mail->setFrom('4m.minimart.2024@gmail.com', '4M Minimart');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your verification code is: ' . $verificationCode;

        $mail->send();
        return true; 
    } catch (Exception $e) {
        return false;
    }
}

if(isset($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name']; 
  //  $last_name = $_POST['last_name']; 
    $last = $_POST['last_name']; 
    $phone_number = $_POST['phone_number']; 
    $username = $_POST['username']; 
    $role = $_POST['role'];
   
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $municipality = $_POST['municipality'];
    
    $pdo->beginTransaction();

    try {
        // Address table
        $sqlAddress = "INSERT INTO address (street, barangay, municipality) VALUES (?, ?, ?)";
        $stmtAddress = $pdo->prepare($sqlAddress);
        $stmtAddress->execute([$street, $barangay, $municipality]);

        $address_id = $pdo->lastInsertId();

    // Users table
    if ($password === $confirm_password) {
        //$hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $verification_code = generateVerificationCode();

        $sql = "INSERT INTO users (email, password, confirm_password, first_name, last_name, phone_number, username, role, address_id, verification_code, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'not_verified')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $hashedPassword, $confirm_password, $first_name, $last, $phone_number, $username, $role, $address_id, $verification_code]);

        if(sendVerificationEmail($email, $verification_code)) {
            $pdo->commit();
            header("location: verify_code.php");
            exit();
    } else {
        $pdo->rollBack();
        echo "Failed to send verification email.";
    }
    } else {
        $pdo->rollBack();
        echo "Passwords do not match.";
    }
    } catch (PDOException $e) {
    $pdo->rollBack();
    die("PDOException: " . $e->getMessage());
    } catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
    }
}
?>