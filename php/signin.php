<?php
session_start();

$servername = "localhost";
$username   = "root";
$password   = "#Whcf@2003";
$dbname     = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}

$name = $_POST['name'];
$pass = $_POST['password'];

$sql = "SELECT * FROM user WHERE name=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($pass, $row['password'])) {
        $_SESSION['username'] = $row['name'];
        header("Location: ../index.html"); // location go up by one
        exit();
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>
