<?php
header('Content-Type: application/json');
require_once 'config/database.php';
require_once 'helpers/Response.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();

    // Get news and updates with university names
    $query = "SELECT n.*, u.name as university_name 
              FROM news_updates n 
              LEFT JOIN universities u ON n.university_id = u.id 
              WHERE n.is_active = TRUE 
              ORDER BY n.publish_date DESC 
              LIMIT 10";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Response::success($news, 'News and updates fetched successfully');
} catch (Exception $e) {
    error_log("Error fetching news: " . $e->getMessage());
    Response::error('Failed to fetch news and updates');
} 