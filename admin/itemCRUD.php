<?php
session_start();
require 'dbcon.php';   // $conn = mysqli connection

// ---------- DELETE ----------
if (isset($_POST['delete_item'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['delete_item']);

    // Optional: delete old image file from server
    $res = mysqli_query($conn, "SELECT Image_URL FROM products WHERE Item_ID='$item_id'");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $oldPath = $row['Image_URL'];
        if (!empty($oldPath) && file_exists($oldPath)) unlink($oldPath);
    }

    $query_run = mysqli_query($conn, "DELETE FROM products WHERE Item_ID='$item_id'");
    $_SESSION['message'] = $query_run ? "Item Deleted Successfully" : "Item Not Deleted";
    header("Location: item.php");
    exit();
}

// ---------- UPDATE ----------
if (isset($_POST['update_item'])) {
    $item_id    = mysqli_real_escape_string($conn, $_POST['item_id']);
    $item_name  = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price      = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity   = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description= mysqli_real_escape_string($conn, $_POST['description']);

    // Handle optional new image upload
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $filename   = time() . "_" . basename($_FILES["image"]["name"]);
        $target     = $upload_dir . $filename;
        $ext        = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        $allowed    = ["jpg","jpeg","png","gif"];

        if (in_array($ext, $allowed) && move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
            $image_path = $target;

            // delete old image if exists
            $res = mysqli_query($conn, "SELECT Image_URL FROM products WHERE Item_ID='$item_id'");
            if ($res && $row = mysqli_fetch_assoc($res)) {
                $oldPath = $row['Image_URL'];
                if (!empty($oldPath) && file_exists($oldPath)) unlink($oldPath);
            }
        }
    }

    // Build update query dynamically
    $sql = "UPDATE products SET Item_ID='$item_id', Item_Name='$item_name', Price='$price', Quantity='$quantity', Description='$description'";
    if ($image_path) {
        $sql .= ", Image_URL='$image_path'";
    }
    $sql .= " WHERE Item_ID='$item_id'";

    $query_run = mysqli_query($conn, $sql);
    $_SESSION['message'] = $query_run ? "Item Updated Successfully" : "Item Not Updated";
    header("Location: item.php");
    exit();
}

// ---------- ADD ----------
if (isset($_POST['add_item'])) {
    $item_id    = mysqli_real_escape_string($conn, $_POST['item_id']);
    $item_name  = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price      = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity   = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description= mysqli_real_escape_string($conn, $_POST['description']);

    // Image upload
    $image_path = "";
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $filename   = time() . "_" . basename($_FILES["image"]["name"]);
        $target     = $upload_dir . $filename;
        $ext        = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        $allowed    = ["jpg","jpeg","png","gif"];

        if (in_array($ext, $allowed) && move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
            $image_path = $target;
        }
    }

    $query = "INSERT INTO products (Item_ID, Item_Name, Price, Quantity, Description, Image_URL)
              VALUES ('$item_id','$item_name','$price','$quantity','$description','$image_path')";
    $query_run = mysqli_query($conn, $query);

    $_SESSION['message'] = $query_run ? "Item Added Successfully" : "Item Not Added";
    header("Location: additem.php");
    exit();
}
?>
