<?php
session_start();

include_once './utils/db.php';

// Query to select all records from the products table
$query = "SELECT * FROM products";

// Execute the query
$results = $conn->query($query);

// Check if the query executed successfully
if ($results) {
  // Fetch all rows as an associative array
  $products = $results->fetch_all(MYSQLI_ASSOC);

  // Free the result set
  $results->free();
} else {
  // If there was an error with the query, display the error message
  echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <link rel="stylesheet" href="./css/style.css">


  <title>Sports Wears</title>

</head>

<body>
<nav>
    <div class="logo">
      <p>SportsNp</p>
    </div>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php#about">About us</a></li>
      <li><a href="index.php#our-products">Products</a></li>
      <li><a href="./myOrders.php">My Orders</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="./cart.php">Cart</a></li>
        <li><a href="./actions/logout_action.php">Logout</a></li>
      <?php else: ?>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <!--banner section-->
  <div class="banner">
    <div class="container">
      <div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">
          <div class="banner-text">
            <h1>Our Quality Product</h1>
            <p>Sportswear or activewear is clothing, including footwear, worn for sport or physical exercise.</p>
            <div class="banner-order-btn"><a href="#">Shop now</a></div>

          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- End banner section-->
  <!-- About section-->
  <div id="about">


    <div class="img">
      <div class="about_main">
        <img src="img/Football aboutus.png">
      </div>
    </div>

    <div class="about-text">
      <h1>About us</h1>
      <h3> Why you choose us?</h3>
      <p>
        All choose us. We offer a complete service to help you create your sportswear clothes and also offer
        variety of products fort different sports and activities, such as football, running, basketball and more.
      </p>
    </div>

  </div>

  <!--Ending about us section-->
  <!--Menu Section-->

  <h2>Our Products</h2>
      <div id="our-products">
          <?php foreach ($products as $p) {
            $imgPath = substr($p['img_path'], 1);
            ?>
            <div class="col-md-4">
              <div class="menu-items">
                <img src="<?php echo $imgPath; ?>" alt="<?php echo $p['title']; ?>">
                <h3>
                  <?php echo $p['title']; ?>
                </h3>
                <p></p>
                <ul>
                  <li>Rs.
                    <?php echo $p['price']; ?>
                  </li>
                    <form action="./actions/add_to_cart.php" method="post">
                      <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                      <input type="hidden" name="title" value="<?php echo $p['title']; ?>">
                      <input type="hidden" name="price" value="<?php echo $p['price']; ?>">
                      <input type="hidden" name="img_path" value="<?php echo $p['img_path']; ?>">
                      <button type="submit" class="order-btn">Add to Cart</button>
                    </form>
              </div>
            </div>
          <?php } ?>
      </div>


  </div>
  <!--Most selling items-->


  <!-- End Most selling items-->
  <!--Register form-->


  <!--End Register form-->
  <!--Fotter-->

  <div class="footer-buttom">
    <p></p>
  </div>




  <!--Fotter-->






</body>

</html>