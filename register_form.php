<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Registration</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        /* background-color: white; */
        background-image: url('images/grocery.jpg');
        background-size: cover;
        background-position: center;
    }
    .container {
        display: flex;
        width: 100%;
    }
    .logo {
        flex: 1;
        padding: 20px;
        margin-top: 30%;
    }
    .logo img {
        max-width: 100%;
        height: auto;
    }
    .form {
        flex: 1;
        padding: 20px;
        background-color: #ddc8c5;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20%;
        border: solid;
        border-color: crimson;
    }
    label, input, select {
        width: 300px;
        height: 25px;
        margin-bottom: 16px;
        box-sizing: border-box;
    }
    .form-group {
        display: flex;
        /* justify-content: space-between; */
        margin-bottom: 10px;
    }
    h2, p {
        text-align: center;
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
    button:hover {
        background-color: #45a049;
    }
    p {
        text-align: center;
        margin-top: 20px;
    }

    /* Media queries for adjusting layout on small screens */
    @media only screen and (max-width: 1023px) {
        
        .container {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-items: center;
        }
        .form {
            width: 80%;
        }
    }

    </style>
</head>

<body>
<div class="container">
    <div class="logo">
        <a href="register_form.php">
            <img src="images/Logo.png" alt="Logo">
        </a>
    </div>
    <div class="form">
        <h2>Registration Form</h2>
        <p class="text-center">Fill in your personal details.</p>

        <div id="error-message" style="color: crimson; margin-bottom: 10px; font-weight:bold;"></div>

        <form method="post" action="register.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" pattern="[A-Za-z\s]+" required placeholder="Enter Your First Name">
            </div> 

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" pattern="[A-Za-z\s]+" required placeholder="Enter Your Last Name">
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" pattern="[0-9]{10}" required placeholder="Enter Your valid 10-digit phone number">
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" pattern="[A-Za-z\s]+" required placeholder="Enter Your Username">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Enter Your Email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" required placeholder="Password (at least 1 letter, 1 number, 1 special character)">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
            </div>

            <div class="form-group" style="display: none;>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Retail_Customer">Customer</option>
                    <option style="display: none;" value="Wholesale_Customer">Wholesale Customer</option>
                    <option style="display: none;" value="Admin">Admin</option>
                    <option style="display: none;"  value="Staff">Staff</option>
                    <option style="display: none;" value="Delivery_personnel">Delivery_personnel</option>
                </select>
            </div>

            <div class="form-group">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required placeholder="Enter Your Street">
            </div>

            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <select id="barangay" name="barangay" required>
                    <option value="Sta Maria">Sta Maria</option>
                    <option value="Apitong">Apitong</option>
                    <option value="Sto Nino">Sto Nino</option>
                    <option value="Barcenaga">Barcenaga</option>
                    <option value="Buhangin">Buhangin</option>
                    <option value="Bacungan">Bacungan</option>
                    <option value="Bayani">Bayani</option>
                    <option value="Mabini">Mabini</option>
                    <option value="Inarawan">Inarawan</option>
                    <option value="Laguna">Laguna</option>
                    <option value="Piñahan">Piñahan</option>
                    <option value="Tigkan">Tigkan</option>
                </select>
            </div>

            <input type="hidden" id="municipality" name="municipality" value="Naujan">

            <button type="submit">Register</button>
            <p>Already have an account? <a href="login_form.php">Login here</a></p>
        </form>

<script>
    function validateForm() {
        var firstName = document.getElementById('first_name').value.trim();
        var lastName = document.getElementById('last_name').value.trim();
        var phoneNumber = document.getElementById('phone_number').value.trim();
        var username = document.getElementById('username').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        var errorMessage = '';
        if (firstName === '' || lastName === '' || phoneNumber === '' || username === '' || email === '' || password === '' || confirmPassword === '') {
            // alert('All fields are required.');
            // return false;
            errorMessage += 'All fields are required. ';
        }
        if (!emailPattern.test(email)) {
            // alert('Please enter a valid email address.');
            // return false;
            errorMessage += 'Please enter a valid email address. ';
        }
        if (password !== confirmPassword) {
            // alert('Passwords do not match.');
            // return false;
            errorMessage += 'Passwords do not match. ';
        }
        var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        if (!passwordPattern.test(password)) {
            // alert('Password must contain at least 1 letter, 1 number, 1 special character, and be at least 8 characters long.');
            // return false;
            errorMessage += 'Password must contain at least 1 letter, 1 number, 1 special character, and be at least 8 characters long. ';
        }
        if (!phoneNumber.match(/^\d{10}$/)) {
            // alert('Please enter a valid 10-digit phone number.');
            // return false;
            errorMessage += 'Please enter a valid 10-digit phone number. ';
        }

        document.getElementById('error-message').innerText = errorMessage;
        if (errorMessage !== '') {
            return false;
        }

        return true;
    }
</script>

    </body>

</html>
