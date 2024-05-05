<?php
session_start();
include_once './utils/db.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
  // Redirect user to login page if not logged in
  header("Location: ./login.php");
  exit();
}

// Retrieve user's email from session
$user_email = $_SESSION['email'];

// Retrieve orders for the current user from the database
$query = "SELECT orders.*, products.title, products.price, products.img_path FROM orders INNER JOIN products ON orders.product_id = products.id WHERE customer_email = '$user_email'";
$result = $conn->query($query);

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

  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      height: fit-content;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>

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

  <h2>My Orders</h2>

  <table>
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Total Quantity</th>
        <th>location</th>
        <th>Time / Date</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Check if the result contains rows
      if ($result->num_rows > 0) {
        // Initialize an associative array to keep track of product quantities
        $productQuantity = array();

        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
          // If the product is not already in the $productQuantity array, add it with quantity 1
          if (!isset($productQuantity[$row['product_id']])) {
            $productQuantity[$row['product_id']] = array(
              'product' => $row,
              'quantity' => 1
            );
          } else {
            // If the product is already in the $productQuantity array, increment its quantity
            $productQuantity[$row['product_id']]['quantity']++;
          }
        }

        // Loop through the $productQuantity array to display each product with its total quantity
        foreach ($productQuantity as $item) {
          $o = $item['product'];
          $imgPath = substr($o['img_path'], 1); // Retrieve the image path for the product
          echo "<tr>";
          echo "<td>{$o['title']}</td>";
          echo "<td>Rs {$o['price']} /- pcs</td>";
          echo "<td>{$item['quantity']}</td>"; // Display the total quantity of the product
          echo "<td>{$o['location']}</td>";
          //in format like 1st Jan 2022 12:00 AM
          echo "<td>" . date('jS M Y h:i A', strtotime($o['created_at'])) . "</td>";
          echo "<td><img src='{$imgPath}' alt='{$o['title']}' width='200px'></td>"; // Display the product image
          echo "<td>";
          echo "<form action='./actions/cancel_order.php' method='post'>";
          echo "<input type='hidden' name='order_id' value='{$o['id']}' >";
          echo '<button type="submit"  style="background-color:red; color:white; border:none; padding:0.5rem; border-radius:5px;" onclick="return confirm(\'Are you sure you want to delete this product?\');">Cancel Order</button>';
          echo "</form>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        // If the result set is empty, display a message
        echo "<tr><td colspan='5'>No orders found</td></tr>";
      }
      ?>
    </tbody>
  </table>


</body>

</html>