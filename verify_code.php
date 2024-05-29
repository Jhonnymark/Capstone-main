<?php
require 'DB/db_con.php';

if(isset($_POST['verification_code'])) {
    $verification_code = $_POST['verification_code'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_code = ?");
    $stmt->execute([$verification_code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        $stmt = $pdo->prepare("UPDATE users SET status = 'verified' WHERE verification_code = ?");
        $stmt->execute([$verification_code]);
        header("location: login_form.php");
        exit();
    } else {
        $error_message = "Incorrect verification code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification Code</title>
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
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .verify-form {
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
            text-align: center;
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
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Verification Code</h2>
    <div class="verify-form">
        <?php if(isset($error_message)) echo '<p class="error-message" style="color: red;">' . $error_message . '</p>'; ?>
        <form method="post" action="verify_code.php"> 
            <label for="verification_code">Enter verification code:</label>
            <input type="text" id="verification_code" name="verification_code" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
