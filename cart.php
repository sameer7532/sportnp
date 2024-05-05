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

    #invoice-cart-wrapper {
      display: flex;
      gap: 1rem;
      width: 100%;
      height: fit-content;
      padding: 1rem;
    }

    .invoice-card {
      width: 500px;
      margin: 20px auto;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      height: fit-content;
    }

    .invoice-header {
      border-bottom: 1px solid #ccc;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .invoice-header h2 {
      margin: 0;
      font-size: 24px;
      color: #333;
    }

    .invoice-details {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .invoice-details p {
      margin: 5px 0;
      font-size: 14px;
      color: #666;
    }

    .invoice-table {
      width: 100%;
      border-collapse: collapse;
      height: fit-content;
    }

    .invoice-table th,
    .invoice-table td {
      padding: 8px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    .invoice-table th {
      background-color: #f2f2f2;
    }

    .total-row {
      font-weight: bold;
    }

    .total-row td {
      padding-top: 10px;
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
      <li><a href="/myOrders.php">My Orders</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="./cart.php">Cart</a></li>
        <li><a href="./actions/logout_action.php">Logout</a></li>
      <?php else: ?>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <div id="invoice-cart-wrapper">
    <div class="invoice-card">
      <div class="invoice-header">
        <h2>Invoice</h2>
        <div class="invoice-details">
          <p>Invoice Number: #<?php echo rand(1000, 9999); ?></p>
          <p>Date: <?php echo date('F j, Y'); ?></p>
        </div>
      </div>
      <table class="invoice-table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Check if the cart exists in the session and is not empty
          if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $totalPrice = 0; // Initialize total price variable
            $productQuantity = array(); // Initialize an associative array to keep track of product quantities
          
            // Loop through each product in the cart
            foreach ($_SESSION['cart'] as $p) {
              $imgPath = substr($p['img_path'], 1);

              // If the product is not already in the $productQuantity array, add it with quantity 1
              if (!isset($productQuantity[$p['title']])) {
                $productQuantity[$p['title']] = 1;
              } else {
                // If the product is already in the $productQuantity array, increment its quantity
                $productQuantity[$p['title']]++;
              }
            }

            // Output each product with its quantity and calculated price
            foreach ($productQuantity as $productName => $quantity) {
              $price = $quantity * $_SESSION['cart'][array_search($productName, array_column($_SESSION['cart'], 'title'))]['price'];
              echo "<tr>";
              echo "<td>{$productName}</td>";
              echo "<td>{$quantity}</td>";
              echo "<td>Rs " . $price . "</td>";
              echo "</tr>";
              $totalPrice += $price; // Add the product price to the total price
            }

            // Output the total price row
            echo "<tr>";
            echo "<td>Total</td>";
            echo "<td></td>"; // Leave the quantity column empty for the total row
            echo "<td>Rs {$totalPrice}</td>";
            echo "</tr>";
          } else {
            // If the invoice is empty, display a message
            echo "<tr><td colspan='3'>Add products to cart</td></tr>";
          }
          ?>
        </tbody>


      </table>

      <p>Thank you for shopping with us!</p>

      <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <form action="./actions/place_order.php" method="post">
          <button type="submit"
            style="margin-top:2rem; background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">Place
            Order</button>
        </form>
      <?php endif; ?>
    </div>



    <table>
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if the cart exists in the session and is not empty
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
          // Initialize an associative array to keep track of product quantities
          $productQuantity = array();

          // Loop through each product in the cart
          foreach ($_SESSION['cart'] as $p) {
            // If the product is not already in the $productQuantity array, add it with quantity 1
            if (!isset($productQuantity[$p['id']])) {
              $productQuantity[$p['id']] = array(
                'product' => $p,
                'quantity' => 1
              );
            } else {
              // If the product is already in the $productQuantity array, increment its quantity
              $productQuantity[$p['id']]['quantity']++;
            }
          }

          // Loop through the $productQuantity array to display each product with its quantity and price
          foreach ($productQuantity as $item) {
            $p = $item['product'];
            $imgPath = substr($p['img_path'], 1); // Retrieve the image path for the product
            echo "<tr>";
            echo "<td>{$p['title']}</td>";
            echo "<td>Rs {$p['price']} /- pcs</td>";
            echo "<td>{$item['quantity']}</td>"; // Display the quantity of the product
            echo "<td><img src='{$imgPath}' alt='{$p['title']}' width='200px'></td>"; // Display the product image
            echo "<td>";
            echo "<form action='./actions/remove_from_cart.php' method='post'>";
            echo "<input type='hidden' name='p_id' value='{$p['id']}' >";
            echo '<button type="submit"  style="background-color:red; color:white; border:none; padding:0.5rem; border-radius:5px;" onclick="return confirm(\'Are you sure you want to delete this product?\');">Remove From Cart</button>';
            echo "</form>";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          // If the cart is empty, display a message
          echo "<tr><td colspan='5'>Cart is empty</td></tr>";
        }
        ?>
      </tbody>
    </table>

  </div>
</body>

</html>