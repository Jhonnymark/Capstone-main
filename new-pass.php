<?php
require 'DB/db_con.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password === $confirmPassword) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, confirm_password = ?, reset_code = NULL WHERE email = ?");
        $stmt->execute([$hashedPassword, $hashedPassword, $email]);

        //echo "Password updated successfully. You can now <a href='login_form.php'>login</a> with your new password.";
       //echo "<script>alert('Password updated successfully. You can now login with your new password.'); window.location='login_form.php';</script>";
       
       $success_message = "Password updated successfully. You can now <a href='login_form.php'>login</a> with your new password.";
    } else {
        echo "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter New Password</title>
    <script src="https://kit.fontawesome.com/a1e3091ba9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./scss/style.scss">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f2f2f2;
            height: 100vh;
        }
        .newPasscontainer {
            display: flex;
            width: 80%;
            padding: 30px;
            margin: 30px;
        }
        h2, p {
            color: #333;
            text-align: center;
        }
        form {
            text-align: center;
        }
        .reset-form {
            width: 400px;
            padding: 20px;
            background-color: #ddc8c5;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: solid;
            border-color: crimson;
        }
        label {
            display: inline-block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
            width: 100%;
        }
        input {
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: crimson;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            width: 100px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 auto;
            display: block;
            width: 50%;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    
<div class="newPass-container">
    <div class="reset-form">
        <h2>Enter New Password</h2>
        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        } elseif (isset($success_message)) {
            echo '<p class="success-message">' . $success_message . '</p>';
        }

        ?>
        <form action="" method="post">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" name="password" required placeholder="Enter Your New Password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required placeholder="Confirm Your New Password">
            </div>
            <button type="submit">Update Password</button>
        </form>
    </div>
</div>

</body>
</html>

