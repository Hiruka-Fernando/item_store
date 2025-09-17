<?php 
session_start();

// ---------- Initialize Cart ----------
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ---------- Handle Actions ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        // Add item to session cart
        $id    = $_POST['item_id'];
        $name  = $_POST['item_name'];
        $price = floatval($_POST['price']);
        $img   = $_POST['image'];

        // If item already in cart, increase quantity
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'name'  => $name,
                'price' => $price,
                'img'   => $img,
                'qty'   => 1
            ];
        }
        header("Location: cart.php");
        exit;
    }

    if ($action === 'update') {
        // Update quantities
        if (isset($_POST['qty'])) {
            foreach ($_POST['qty'] as $id => $qty) {
                $_SESSION['cart'][$id]['qty'] = max(1, (int)$qty);
            }
        }
        header("Location: cart.php");
        exit;
    }

    if ($action === 'remove') {
        $id = $_POST['remove_id'];
        unset($_SESSION['cart'][$id]);
        header("Location: cart.php");
        exit;
    }

    if ($action === 'checkout') {
        // Clear cart after checkout
        $_SESSION['cart'] = [];
        header("Location: thank-you.html");
        exit;
    }
}

// ----------Calculate Total----------
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
$shipping = $subtotal > 0 ? $subtotal * 0.05 : 0;
$total    = $subtotal + $shipping;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ShopVibe – Cart & Checkout</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="css/cart.css" rel="stylesheet">
</head>
<body>
<nav class="navbar" id="navbar">
  <div class="nav-container">
    <ul class="nav-left">
      <li><a href="index.html">Home</a></li>
      <li><a href="admin/products.php">Store</a></li>
      <li><a href="contact.html">Contact Us</a></li>
    </ul>
    <div class="logo">ShopVibe</div>
    <ul class="nav-right">
      <li><a href="about.html">About Us</a></li>
      <li><a href="cart.php" class="cart-icon">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count"><?php echo array_sum(array_column($_SESSION['cart'],'qty')); ?></span>
      </a></li>
      <li><a href="signin.html">Log Out</a></li>
    </ul>
  </div>
</nav>

<section class="section visible" style="margin-top:6rem">
  <div class="container cart-page">
    <h2 class="section-title">Your Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST" action="cart.php">
      <input type="hidden" name="action" value="update">

      <div class="cart-items">
        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
          <div class="cart-item">
            <img src="<?php echo htmlspecialchars($item['img']); ?>" 
                 alt="<?php echo htmlspecialchars($item['name']); ?>" 
                 style="width:80px;height:auto;">
            <div class="cart-details">
              <h3><?php echo htmlspecialchars($item['name']); ?></h3>
              <p>Rs.<?php echo number_format($item['price'],2); ?></p>
            </div>
            <input type="number" name="qty[<?php echo $id; ?>]" 
                   value="<?php echo $item['qty']; ?>" min="1">
            <div class="cart-price">Rs.<?php echo number_format($item['price'] * $item['qty'],2); ?></div>

            <!-- Remove button -->
            <button type="submit" name="action" value="remove" 
                    formaction="cart.php" formmethod="POST"
                    class="remove-btn"
                    onclick="this.form.remove_id.value='<?php echo $id; ?>'">
              Remove
            </button>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Hidden input for remove -->
      <input type="hidden" name="remove_id" value="">

      <button type="submit" class="cta-button" style="margin:1rem 0;">Update Quantities</button>
    </form>
    <?php else: ?>
      <p>Your cart is empty.</p>
    <?php endif; ?>

    <!-- Checkout Summary -->
    <?php if (!empty($_SESSION['cart'])): ?>
      <div class="checkout-box">
        <h3>Order Summary</h3>
        <p>Subtotal: <span>Rs.<?php echo number_format($subtotal,2); ?></span></p>
        <p>Shipping: <span>Rs.<?php echo number_format($shipping,2); ?></span></p>
        <p class="total">Total: <span>Rs.<?php echo number_format($total,2); ?></span></p>

        <!-- Checkout form -->
        <form method="POST" action="cart.php">
          <input type="hidden" name="action" value="checkout">
          <button type="submit" class="cta-button" style="margin-top:1rem;">Proceed to Checkout</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</section>

<footer class="footer">
  <div class="container">
    <div class="footer-bottom">
      <p>&copy; 2025 ShopVibe. All rights reserved.</p>
    </div>
  </div>
</footer>
</body>
</html>
