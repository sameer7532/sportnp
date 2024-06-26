<?php
session_start();
include_once './utils/db.php';


if (!isset($_SESSION['email'])) {

  header("Location: ./login.php");
  exit();
}

$user_email = $_SESSION['email'];


$query = "SELECT orders.*, products.title, products.price, products.img_path FROM orders INNER JOIN products ON orders.product_id = products.id WHERE customer_email = '$user_email' ORDER BY order_date DESC";
$result = $conn->query($query);

?>

<!doctype html>
<html lang="en">

<head>

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
        <th>phone number</th>
        <th>Time / Date</th>
        <th>Image</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      
      if ($result->num_rows > 0) {
       
        $productQuantity = array();

       
        while ($row = $result->fetch_assoc()) {
        
          if (!isset($productQuantity[$row['product_id']])) {
            $productQuantity[$row['product_id']] = array(
              'product' => $row,
              'quantity' => 1
            );
          } else {
         
            $productQuantity[$row['product_id']]['quantity']++;
          }
        }

       
        foreach ($productQuantity as $item) {
          $o = $item['product'];
          $imgPath = substr($o['img_path'], 1);
          echo "<td>{$o['title']}</td>";
          echo "<td>Rs {$o['price']} /- pcs</td>";
          echo "<td>{$item['quantity']}</td>"; 
          echo "<td>{$o['location']}</td>";
          echo "<td>{$o['phone_number']}</td>";
          
          echo "<td>" . date('jS M Y h:i A', strtotime($o['order_date'])) . "</td>";
          echo "<td><img src='{$imgPath}' alt='{$o['title']}' width='200px'></td>"; 
          echo "<td>{$o['status']}</td>";
          echo "<td>";
          if ($o['status'] == 'processing') {
            echo "<form action='./actions/cancel_order.php' method='post'>";
            echo "<input type='hidden' name='order_id' value='{$o['id']}' >";
            echo '<button type="submit"  style="background-color:red; color:white; border:none; padding:0.5rem; border-radius:5px;" onclick="return confirm(\'Are you sure you want to delete this product?\');">Cancel Order</button>';
            echo "</form>";
          }
          echo "</td>";
          echo "</tr>";
        }
      } else {
       
        echo "<tr><td colspan='5'>No orders found</td></tr>";
      }
      ?>
    </tbody>
  </table>


</body>

</html>