<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$name     = $_POST['name'];
$email    = $_POST['email'];
$pass     = $_POST['password'];
$confirm  = $_POST['confirm'];

if ($pass !== $confirm) {
    echo "Passwords do not match.";
    exit;
}

$hashed = password_hash($pass, PASSWORD_DEFAULT);

// Check if user exists
$check = $conn->prepare("SELECT id FROM user WHERE name=?");
$check->bind_param("s", $name);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "User already exists. Please sign in.";
    exit;
}

// Insert
$stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed);
if ($stmt->execute()) {
    echo "Account created successfully. You can sign in now.";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
