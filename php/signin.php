<?php
declare(strict_types=1);
session_start([
    'cookie_httponly' => true,
    'cookie_secure'   => isset($_SERVER['HTTPS']),
    'cookie_samesite' => 'Strict'
]);

/* ---------- Load configuration safely ---------- */
$servername = getenv('DB_HOST')     ?: 'localhost';
$dbusername = getenv('DB_USER')     ?: 'root';
$dbpassword = getenv('DB_PASSWORD') ?: '#Whcf@2003';
$dbname     = getenv('DB_NAME')     ?: 'admin';

/* ---------- Database connection ---------- */
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    error_log("DB connection failed: " . $conn->connect_error);
    http_response_code(500);
    exit('Internal Server Error');
}

/* ---------- Validate input ---------- */
if (
    empty($_POST['name']) ||
    empty($_POST['password']) ||
    !is_string($_POST['name']) ||
    !is_string($_POST['password'])
) {
    http_response_code(400);
    exit('Invalid request');
}

$name = trim($_POST['name']);
$pass = $_POST['password'];


/* ---------- Admin login check ---------- */
$adminSql = "SELECT Admin_Name, Admin_key FROM logAdmin WHERE Admin_Name = ?";
if ($stmt = $conn->prepare($adminSql)) {
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $adminRes = $stmt->get_result();
    if ($adminRow = $adminRes->fetch_assoc()) {
        // Use password_hash in DB for Admin_key
        if (password_verify($pass, $adminRow['Admin_key'])) {
            session_regenerate_id(true);
            $_SESSION['role'] = 'admin';
            $_SESSION['username'] = $adminRow['Admin_Name'];
            header('Location: ../admin/item.php', true, 302);
            exit();
        }
    }
    $stmt->close();
}

/* ---------- Normal user login check ---------- */
$userSql = "SELECT name, password FROM user WHERE name = ?";
if ($stmt = $conn->prepare($userSql)) {
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($pass, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['role'] = 'user';
            $_SESSION['username'] = $row['name'];
            header('Location: ../index.html', true, 302);
            exit();
        }
    }
    $stmt->close();
}

/* ---------- Error message---------- */
http_response_code(401);
echo 'Invalid username or password.';
$conn->close();
