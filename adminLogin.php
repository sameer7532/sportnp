<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./css/loginregister.css">
</head>
<body>
  <div class="container">
    <h2>Admin Login</h2>
    <form id="loginForm" action="./actions/admin_login_action.php" method="POST">
        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo"<p style='color:red;'>$error</p>"; 
        }
?>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>

  <script src="script.js"></script>
</body>
</html>
