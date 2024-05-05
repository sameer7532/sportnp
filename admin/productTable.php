<?php
session_start();

include_once '../utils/db.php';

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
 
  <link rel="stylesheet" href="../css/style.css">
 

  <title>Sports Wears</title>

  <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
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
          <li><a href="./admin/addProduct.php">Add Product</a></li>
          <?php if (isset($_SESSION['email'])): ?>
        <li><a href="./actions/logout_action.php">Logout</a></li>
      <?php else: ?>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <table>
  <thead>
<br></br> <br></br>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if the cart exists in the session and is not empty
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                // Loop through each product in the cart
                foreach ($_SESSION['cart'] as $p) {
                  $imgPath = substr($p['img_path'], 1);
                    // Output the p details in a table row
                    echo "<tr>";
                    echo "<td>{$p['title']}</td>";
                    echo "<td>{$p['price']}</td>";
                    echo "<td><img src='{$imgPath}' alt='{$p['title']}' width='200px'></td>";
                    echo "<td>";
                    echo "<form action='./actions/remove_from_cart.php' method='post'>";
                    echo "<input type='hidden' name='p_id' value='{$p['id']}' >";
                    echo "<button type='submit'>Remove</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                // If the cart is empty, display a message
                echo "<tr><td colspan='4'>Cart is empty</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>