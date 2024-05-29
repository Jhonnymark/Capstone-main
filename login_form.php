<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
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
            background-image: url('images/grocery.jpg');
            background-size: cover;
            background-position: center;
        }
        .container {
            display: flex;
            /* width: 100%; */
            width: 80%;
            padding: 30px;
            margin: 30px;
        }
        .logo {
            flex: 1;
            padding: 20px;
            margin-top: 10%;
        }
        .logo img {
            max-width: 100%;
            height: auto;
        }
        h2, p {
            color: #333;
            text-align: center;
        }
        .login-form{
            flex: 1;
            padding: 20px;
            background-color: #ddc8c5;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 10%;
            border: solid;
            border-color: crimson;
            max-width: 400px;
            max-height: 400px;
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
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .links {
            margin-top: 10px; 
            display: flex;
            flex-direction: column; 
            align-items: center;
            color: #555; 
        }
        .links a {
            text-decoration: none;
            color: crimson;
            margin-bottom: 10px; 
        }
        .links a:hover {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="logo">
        <a href="login_form.php">
            <img src="images/Logo.png" alt="Logo">
        </a>
    </div>
    <div class="login-form" id="loginForm">
        <h2>Login</h2>
        <p>Welcome Back! Fill in your login details.</p>
        
        <div id="errorMessage" style="color: red; margin-bottom: 10px; font-weight:bold;">
            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === "IncorrectEmailorPassword") {
                    echo "Incorrect Email or Password. Please try again.";
                } elseif ($error === "UserNotFound") {
                    echo "User not found. Please check your email.";
                } elseif ($error === "PleaseProvideAValidEmailAndPassword") {
                    echo "Please provide A Valid Email and Password.";
                }
            }
            ?>
        </div>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="user_email">Email:</label>
                <input type="email" name="email" required placeholder="Enter Your Email">
            </div>
            <div class="form-group">
                <label for="user_password">Password:</label>
                <input type="password" name="password" required placeholder="Enter Your Password">
            </div>
            <button type="submit">Login</button>

            <div class="links">
                <a href="forgot_pass.php">Forgot Password?</a>
                <a href="register_form.php">Register</a>
                <a href="index.php">Home</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
