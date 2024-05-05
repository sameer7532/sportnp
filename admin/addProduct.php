<?php
session_start();

include_once '../utils/db.php';

// Query to select all records from the products table
$query = "SELECT * FROM products ORDER BY created_at DESC";


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

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    table img {
      width: 100px;
    }

    .add-product-form-container {
      margin-top: 1rem;
      width: 600px;
      height: fit-content;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .add-product-form-container h2 {
      text-align: center;
    }

    .add-product-form-container .form-group {
      margin-bottom: 15px;
    }

    .add-product-form-container label {
      display: block;
      font-weight: bold;
    }

    .add-product-form-container input[type="text"],
    .add-product-form-container input[type="number"],
    .add-product-form-container input[type="file"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
      /* Ensure padding and border are included in the width */
    }

    .add-product-form-container button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add-product-form-container button[type="submit"]:hover {
      background-color: #0056b3;
    }

    #form-table-wrapper {
      display: flex;
      gap: 1rem;
      width: 100%;
      height: 100vh;
      padding: 1rem;
    }
  </style>

</head>

<body>
  <nav>
    <div class="logo">
      <p>SportsNp</p>
    </div>
    <ul>
      
      <li><a href="../admin/addProduct.php">Product</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="../actions/logout_action.php">Logout</a></li>
      <?php else: ?>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <div id="form-table-wrapper">

    <div class="add-product-form-container">
      <form action="../actions/admin_add_product.php" method="post" enctype="multipart/form-data">
        <h2>ADD Product</h2>
        <?php
        if (isset($_GET['msg'])) {
          $msg = $_GET['msg'];
          echo "<p style='color:red;'>$msg</p>";
        }
        ?>
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="number" id="price" name="price" required min="0">
                </div>
        <div class="form-group">
          <label for="image">Image:</label>
          <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit">add</button>
      </form>

    </div>

    <table>
      <thead>
        <br></br> <br></br>
        <tr>
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if the cart exists in the session and is not empty
        if (isset($products) && !empty($products)) {
          // Loop through each product in the cart
          foreach ($products as $p) {
            $imgPath = substr($p['img_path'], 1);
            // Output the p details in a table row
            echo "<tr>";
            echo "<td><img src='{$p['img_path']}'/></td>";
            echo "<td>{$p['title']}</td>";
            echo "<td>Rs {$p['price']}</td>";
            echo "<td><img src='{$imgPath}' alt='{$p['title']}' width='200px'></td>";
            echo "<td>";
            echo '<form action="../actions/admin_delete_product.php" method="post"> ';
            echo '<input type="hidden" name="product_id" value="' . $p["id"] . '" > ';
            echo '<button type="submit" style="background-color:red; color:white; border:none; padding:1rem;"
                      onclick="return confirm("Are you sure you want to delete this product?");">Delete</button> ';
            echo "</form>";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          // If the cart is empty, display a message
          echo "<tr><td colspan='4'>No products added</td></tr>";
        }
        ?>
      </tbody>
    </table>

  </div>




  <!--Fotter-->
</body>

</html>