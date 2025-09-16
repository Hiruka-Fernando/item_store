<?php
session_start();
require 'dbcon.php';

// Check for id in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "No Item ID provided.";
    header("Location: item.php");
    exit();
}

$item_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch current product data
$result = mysqli_query($conn, "SELECT * FROM products WHERE Item_ID='$item_id'");
if (!$result || mysqli_num_rows($result) === 0) {
    $_SESSION['message'] = "Item not found.";
    header("Location: item.php");
    exit();
}
$item = mysqli_fetch_assoc($result);
?>

<?php include('includes/header.php'); ?>

<div class="container mt-5">
    <?php include('message.php'); ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Item
                        <a href="item.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="itemCRUD.php" method="post" enctype="multipart/form-data">

                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['Item_ID']); ?>">

                        <div class="mb-3">
                            <label>Item Name</label>
                            <input type="text" name="item_name" value="<?= htmlspecialchars($item['Item_Name']); ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" name="price" value="<?= htmlspecialchars($item['Price']); ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="text" name="quantity" value="<?= htmlspecialchars($item['Quantity']); ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($item['Description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Current Image</label><br>
                            <?php if (!empty($item['Image_URL']) && file_exists($item['Image_URL'])): ?>
                                <img src="<?= htmlspecialchars($item['Image_URL']); ?>" alt="Product Image" width="150">
                            <?php else: ?>
                                <p>No image uploaded.</p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label>Upload New Image (optional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>

                        <div class="mb-3">
                            <button type="submit" name="update_item" class="btn btn-primary">Update Item</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
