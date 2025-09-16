<?php
// --- Database Connection ---
$servername = "localhost";
$username   = "root";
$password   = "";          // your DB password
$dbname     = "admin";     // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Fetch Products ---
$sql    = "SELECT Item_ID, Item_Name, Price, Quantity, Description, Image_URL FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="products.css">
</head>
<body>

<!-- ===== NAVBAR (unchanged) ===== -->
<nav class="navbar" id="navbar">
  <div class="nav-container">
    <ul class="nav-left">
      <li><a href="index.html">Home</a></li>
      <li><a href="#">Store</a></li>
      <li><a href="contact.html">Contact Us</a></li>
    </ul>
    <div class="logo">ShopVibe</div>
    <div class="search-bar">
      <input type="text" placeholder="Search products...">
      <i class="fas fa-search icon"></i>
    </div>
    <ul class="nav-right">
      <li><a href="about.html">About Us</a></li>
      <li><a href="cart.html" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">0</span>
      </a></li>
      <li><a href="#signin">Sign In</a></li>
    </ul>
  </div>
</nav>

<main>
  <div class="product-grid">
    <?php
      if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $img = !empty($row['Image_URL']) ? $row['Image_URL'] : "images/default.jpg";
              echo '<div class="card">';
              echo '  <img src="'.htmlspecialchars($img).'" alt="'.htmlspecialchars($row['Item_Name']).'">';
              echo '  <h3>'.htmlspecialchars($row['Item_Name']).'</h3>';
              echo '  <p>'.htmlspecialchars($row['Description']).'</p>';
              echo '  <p><strong>Price: $'.htmlspecialchars($row['Price']).'</strong></p>';
              echo '  <button class="add-cart">Add to Cart</button>';
              echo '  <button class="buy-now">Buy Now</button>';
              echo '</div>';
          }
      } else {
          echo "<p>No products found.</p>";
      }
      $conn->close();
    ?>
  </div>
</main>

<!-- ===== FOOTER (unchanged) ===== -->
<footer class="footer">
  <div class="container">
    <div class="footer-content">
      <!-- … keep your existing footer sections … -->
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 ShopVibe. All rights reserved. | Privacy Policy | Terms of Service</p>
    </div>
  </div>
</footer>
</body>
</html>
