<?php
session_start();
include_once '../utils/db.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect user to login page if not logged in
    header("Location: ./login.php");
    exit();
}

// Retrieve all orders from the database
$query = "SELECT orders.*, products.title, products.price, products.img_path FROM orders INNER JOIN products ON orders.product_id = products.id ORDER BY order_date DESC";
$result = $conn->query($query);

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <link rel="stylesheet" href="../css/style.css">

  <title>Admin Orders</title>

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
      <li><a href="./addProduct.php">Product</a></li>
      <li><a href="./allOrders.php">Orders</a></li>
      <?php if (isset($_SESSION['email'])): ?>
        <li><a href="../actions/logout_action.php">Logout</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <h2>All Orders</h2>

  <table>
    <thead>
      <tr>
        <th>User Email</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Total Quantity</th>
        <th>Location</th>
        <th>Phone Number</th>
        <th>Time / Date</th>
        <th>Image</th>
        <th>Action</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Check if the result contains rows
      if ($result->num_rows > 0) {
        // Initialize an associative array to keep track of product quantities
        $orderDetails = array();

        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
          // Form a unique key combining user email and product ID
          $key = $row['customer_email'] . '_' . $row['product_id'];

          // If the order details for the user and product are not already in the array, add them
          if (!isset($orderDetails[$key])) {
            $orderDetails[$key] = array(
              'order_id' => $row['id'], // Add the order ID to the array
              'user_email' => $row['customer_email'],
              'product_id' => $row['product_id'],
              'product_title' => $row['title'],
              'price' => $row['price'],
              'img_path' => $row['img_path'],
              'total_quantity' => 1,
              'location' => $row['location'],
              'phone_number' => $row['phone_number'],
              'order_date' => $row['order_date'],
              'status' => $row['status'] // Add the status to the array
            );
          } else {
            // If the order details for the user and product are already in the array, increment the total quantity
            $orderDetails[$key]['total_quantity']++;
          }
        }

        // Loop through the order details array to display each order
        foreach ($orderDetails as $order) {
          $imgPath = substr($order['img_path'], 1); // Retrieve the image path for the product
          echo "<tr>";
          echo "<td>{$order['user_email']}</td>";
          echo "<td>{$order['product_title']}</td>";
          echo "<td>Rs {$order['price']} /- pcs</td>";
          echo "<td>{$order['total_quantity']}</td>"; // Display the total quantity of the product
          echo "<td>{$order['location']}</td>";
          echo "<td>{$order['phone_number']}</td>";

          //in format like 1st Jan 2022 12:00 AM
          echo "<td>" . date('jS M Y h:i A', strtotime($order['order_date'])) . "</td>";
          echo "<td><img src='.{$imgPath}' alt='{$order['product_title']}' width='200px'></td>"; // Display the product image
          echo "<td>";
          echo "<form action='../actions/cancel_order.php' method='post'>";
          echo "<input type='hidden' name='order_id' value='{$order['order_id']}' >";
          echo '<button type="submit"  style="background-color:red; color:white; border:none; padding:0.5rem; border-radius:5px;" onclick="return confirm(\'Are you sure you want to delete this product?\');">Cancel Order</button>';
          echo "</form>";
          echo "</td>";
          echo "<td>";
          //status form
          echo '<form action="../actions/admin_change_status.php" method="post" style="display:inline;"> ';
          echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
          echo '<select name="status" id="status" style="padding:0.5rem; border-radius:5px;">';
          echo '<option value="processing" ' . ($order['status'] == 'processing' ? 'selected' : '') . '>Processing</option>';
          echo '<option value="shipped" ' . ($order['status'] == 'shipped' ? 'selected' : '') . '>Shipped</option>';
          echo '<option value="delivered" ' . ($order['status'] == 'delivered' ? 'selected' : '') . '>Delivered</option>';
          echo '</select>';
          echo '<button type="submit" style="background-color:green; color:white; border:none; padding:0.5rem; border-radius:5px;" onclick="return confirm(\'Are you sure you want to change the status?\');">Change Status</button>';

          echo "</form>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        // If the result set is empty, display a message
        echo "<tr><td colspan='6'>No orders found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</body>

</html>
