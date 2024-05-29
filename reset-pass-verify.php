<?php
require 'DB/db_con.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resetCode = $_POST['reset_code'];

    $stmt = $pdo->prepare("SELECT email FROM users WHERE reset_code = ?");
    $stmt->execute([$resetCode]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        header("Location: new-pass.php?email=" . urlencode($user['email']));
        exit();
    } else {
        $error_message = "Invalid reset code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
    <h2>Reset Password</h2>
    <div class="reset-form">
        <?php if(isset($error_message)) echo '<p class="error-message">' . $error_message . '</p>'; ?>
        <form method="post" action="reset-pass-verify.php"> 
            <label for="reset_code">Enter reset code:</label>
            <input type="text" id="reset_code" name="reset_code" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
