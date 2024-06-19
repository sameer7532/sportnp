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
  <title>Sports Wears</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/validate.js" defer></script>

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

    .add-product-form-container button {
      width: 100%;
      padding: 10px;
      background-color: green;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .add-product-form-container button:hover {
      opacity: 0.8;
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
      <li><a href="./addProduct.php">Product</a></li>
      <li><a href="./allOrders.php">Orders</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="../actions/logout_action.php">Logout</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <div id="form-table-wrapper">
    <div class="add-product-form-container">
    <form id="product-form" action="../actions/admin_add_product.php" method="post" enctype="multipart/form-data">
        <h2 id="form-heading">Add Product</h2>
        <?php
        if (isset($_GET['msg'])) {
          $msg = $_GET['msg'];
          echo "<p style='color:red;'>$msg</p>";
        }
        ?>
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" name="title">
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input type="text" id="price" name="price" min="0">
        </div>
        <div class="form-group">
          <label for="image">Image:</label>
          <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg, image/wpeg" onchange="previewImage(event)">
          <img id="image-preview" src="#" alt="Image Preview" 
           style="display: none; max-width: 200px; margin-top: 10px;">
        </div>
        <button type="submit" id="submit-btn">Add</button>
        <button type="button" id="edit-btn" style="display: none; background-color:blue;">Edit</button>
        <input type="hidden" id="product-id" name="product_id">
      </form>
    </div>

    <table>
      <thead>
        <tr>
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Check if the products exist and are not empty
        if (isset($products) && !empty($products)) {
          // Loop through each product
          foreach ($products as $p) {
            // Output the product details in a table row
            echo "<tr>";
            echo "<td><img src='{$p['img_path']}'/></td>";
            echo "<td>{$p['title']}</td>";
            echo "<td>Rs {$p['price']}</td>";
            echo "<td>";
            echo "<button style='background-color:blue; color:white; border:none; padding:0.5rem; border-radius:5px;' class='edit-product-btn' data-id='{$p["id"]}' data-title='{$p["title"]}' data-price='{$p["price"]}' data-image='{$p["img_path"]}'>Edit</button>";
            echo '<form action="../actions/admin_delete_product.php" method="post" style="display:inline;"> ';
            echo '<input type="hidden" name="product_id" value="' . $p["id"] . '" > ';
            echo '<button type="submit" style="background-color:red; color:white; border:none; padding:0.5rem; border-radius:5px;" onclick="return confirm(\'Are you sure you want to delete this product?\');">Delete</button> ';
            echo "</form>";
            echo "</td>";
            echo "</tr>";
          }
        } else {
          // If no products found, display a message
          echo "<tr><td colspan='4'>No products added</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <script>
// JavaScript code for handling product editing
const editButtons = document.querySelectorAll('.edit-product-btn');

editButtons.forEach(button => {
  button.addEventListener('click', () => {
    const productId = button.getAttribute('data-id');
    const productTitle = button.getAttribute('data-title');
    const productPrice = button.getAttribute('data-price');
    const productImage = button.getAttribute('data-image');

    // Set form fields with product details
    document.getElementById('product-id').value = productId;
    document.getElementById('title').value = productTitle;
    document.getElementById('price').value = productPrice;

    // Display image preview if product has image
    const imagePreview = document.getElementById('image-preview');
    if (productImage) {
      imagePreview.src = productImage;
      imagePreview.style.display = 'block';
    } else {
      imagePreview.style.display = 'none';
    }

    document.getElementById('form-heading').innerText = 'Edit Product';
    document.getElementById('submit-btn').style.display = 'none';
    document.getElementById('edit-btn').style.display = 'block';
    document.getElementById('edit-btn').addEventListener('click', () => {
      // Submit the form for editing
      document.getElementById('product-form').setAttribute('action', `../actions/admin_edit_product.php?id=${productId}`);
      document.getElementById('product-form').submit();
    });
  });
});

// Function to preview image when selected
function previewImage(event) {
  const imagePreview = document.getElementById('image-preview');
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = function() {
    imagePreview.src = reader.result;
    imagePreview.style.display = 'block';
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    imagePreview.src = '#';
    imagePreview.style.display = 'none';
  }
}
</script>
</body>

</html>
