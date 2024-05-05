<?php session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
  header('Location: ../login.php');
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../css/style.css">
  <title>Online Food Order</title>

</head>

<body>
  <nav>
    <div class="logo">
      <p>FoodHub</p>
    </div>
    <ul>
      <li><a href="../admin/addProduct.php">Product</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="./actions/logout_action.php">Logout</a></li>
      <?php else: ?>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>

</body>

</html>