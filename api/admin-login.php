<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json');

// Include database configuration
require_once 'config/database.php';
require_once 'helpers/Response.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username']) || !isset($data['password'])) {
    Response::error('Missing credentials', 400);
}

try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Get admin credentials from database
    $stmt = $pdo->prepare("SELECT id, username, password, email FROM admins WHERE username = ?");
    $stmt->execute([$data['username']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $data['password'] === $admin['password']) {
        // Set session variables
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['last_activity'] = time();

        // Update last login time
        $updateStmt = $pdo->prepare("UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
        $updateStmt->execute([$admin['id']]);

        Response::success(null, 'Login successful');
    } else {
        Response::error('Invalid username or password', 401);
    }
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    Response::error('An error occurred during login: ' . $e->getMessage());
} 