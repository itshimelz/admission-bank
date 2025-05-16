<?php
// Prevent any output before headers
ob_start();

// Set error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Set headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

try {
    // Clear any previous output
    ob_clean();
    
    include_once 'config/database.php';
    require_once 'helpers/Response.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("Database connection failed");
    }

    // Test query
    $query = "SELECT COUNT(*) as count FROM universities";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    sendJsonResponse([
        "status" => "success",
        "message" => "Database connection successful",
        "data" => [
            "total_universities" => $result['count'],
            "server_info" => [
                "php_version" => PHP_VERSION,
                "mysql_version" => $db->getAttribute(PDO::ATTR_SERVER_VERSION),
                "database_name" => "admission_bank"
            ]
        ]
    ]);

    Response::success([
        "total_universities" => $result['count'],
        "server_info" => [
            "php_version" => PHP_VERSION,
            "mysql_version" => $db->getAttribute(PDO::ATTR_SERVER_VERSION),
            "database_name" => "admission_bank"
        ]
    ], 'Database connection successful');

} catch (Exception $e) {
    sendJsonResponse([
        "status" => "error",
        "message" => "Database connection failed: " . $e->getMessage()
    ], 500);

    Response::error('Database connection failed: ' . $e->getMessage(), 500);
} catch (Error $e) {
    sendJsonResponse([
        "status" => "error",
        "message" => "System error: " . $e->getMessage()
    ], 500);

    Response::error('System error: ' . $e->getMessage(), 500);
} finally {
    ob_end_flush();
}
?> 