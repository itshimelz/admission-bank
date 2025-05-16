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
    include_once 'models/University.php';
    require_once 'helpers/Response.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("Database connection failed");
    }

    $university = new University($db);

    if (!isset($_GET['name'])) {
        throw new Exception("University name is required");
    }

    $university->name = $_GET['name'];

    if($university->readOne()) {
        // Get timeline events
        $timeline_stmt = $university->getTimelineEvents();
        $timeline_events = array();
        while ($event = $timeline_stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($timeline_events, array(
                "id" => $event['id'],
                "event_name" => $event['event_name'],
                "event_date" => $event['event_date'],
                "event_description" => $event['event_description'],
                "event_type" => $event['event_type']
            ));
        }

        $university_arr = array(
            "id" => $university->id,
            "name" => $university->name,
            "type" => $university->type,
            "website" => $university->website,
            "established_year" => $university->established_year,
            "location" => $university->location,
            "description" => $university->description,
            "admission_requirements" => $university->admission_requirements,
            "application_deadline" => $university->application_deadline,
            "tuition_fee" => $university->tuition_fee,
            "contact_info" => $university->contact_info,
            "programs_offered" => $university->programs_offered,
            "campus_facilities" => $university->campus_facilities,
            "ranking" => $university->ranking,
            "image_url" => $university->image_url,
            "timeline_events" => $timeline_events
        );

        Response::success($university_arr, 'University details fetched successfully');
    } else {
        Response::error('University not found.', 404);
    }
} catch (Exception $e) {
    Response::error('Error: ' . $e->getMessage(), 500);
} catch (Error $e) {
    Response::error('Error: ' . $e->getMessage(), 500);
} finally {
    // Clean and end output buffer
    ob_end_flush();
}
?> 