<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/loginregister.css">

</head>

<body>
    <div class="container">
        <h2>Register</h2>

        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo"<p style='color:red;'>$error</p>"; 
        }
        ?>
        <form id="registerForm" action="./actions/register_action.php" method="POST">
            <div class="form-group">
                <label for="fullname">Full name:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script src="script.js"></script>
</body>

</html>