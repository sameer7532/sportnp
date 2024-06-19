<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/loginregister.css">
    <script src="./js/validate.js" defer></script>
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
                <input type="text" id="fullname" name="fullname" >
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" >
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" >
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" >
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" >
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

</body>

</html>