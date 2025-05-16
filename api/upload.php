<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get the database connection
    $conn->beginTransaction();

    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception("Invalid JSON data received");
    }

    // Validate required fields
    $required_fields = ['name', 'type', 'website', 'established_year', 'location', 'description'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Validate data types and formats
    if (!filter_var($data['website'], FILTER_VALIDATE_URL)) {
        throw new Exception("Invalid website URL format");
    }

    if (!in_array($data['type'], ['Public', 'Private', 'National'])) {
        throw new Exception("Invalid university type");
    }

    if (!is_numeric($data['established_year']) || 
        $data['established_year'] < 1800 || 
        $data['established_year'] > date('Y')) {
        throw new Exception("Invalid established year");
    }

    // Check if university already exists
    $check_sql = "SELECT id FROM universities WHERE name = :name";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':name', $data['name']);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        throw new Exception("A university with this name already exists");
    }

    // Prepare the SQL statement for university
    $sql = "INSERT INTO universities (
        name, type, website, established_year, location, description,
        admission_requirements, application_deadline, tuition_fee,
        contact_info, programs_offered, campus_facilities, ranking, image_url
    ) VALUES (
        :name, :type, :website, :established_year, :location, :description,
        :admission_requirements, :application_deadline, :tuition_fee,
        :contact_info, :programs_offered, :campus_facilities, :ranking, :image_url
    )";

    $stmt = $conn->prepare($sql);

    // Bind parameters with proper type checking
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':type', $data['type']);
    $stmt->bindParam(':website', $data['website']);
    $stmt->bindParam(':established_year', $data['established_year'], PDO::PARAM_INT);
    $stmt->bindParam(':location', $data['location']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':admission_requirements', $data['admission_requirements'] ?? null);
    $stmt->bindParam(':application_deadline', $data['application_deadline'] ?? null);
    $stmt->bindParam(':tuition_fee', $data['tuition_fee'] ?? null, PDO::PARAM_STR);
    $stmt->bindParam(':contact_info', $data['contact_info'] ?? null);
    $stmt->bindParam(':programs_offered', $data['programs_offered'] ?? null);
    $stmt->bindParam(':campus_facilities', $data['campus_facilities'] ?? null);
    $stmt->bindParam(':ranking', $data['ranking'] ?? null, PDO::PARAM_INT);
    $stmt->bindParam(':image_url', $data['image_url'] ?? null);

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Failed to insert university data: " . implode(", ", $stmt->errorInfo()));
    }

    $university_id = $conn->lastInsertId();

    // If timeline events are provided, insert them
    if (isset($data['timeline_events']) && is_array($data['timeline_events'])) {
        $timeline_sql = "INSERT INTO application_timeline (
            university_id, event_name, event_date, event_description, event_type
        ) VALUES (
            :university_id, :event_name, :event_date, :event_description, :event_type
        )";

        $timeline_stmt = $conn->prepare($timeline_sql);

        foreach ($data['timeline_events'] as $event) {
            // Validate timeline event data
            if (empty($event['event_name']) || empty($event['event_date']) || 
                empty($event['event_description']) || empty($event['event_type'])) {
                throw new Exception("All timeline event fields are required");
            }

            if (!in_array($event['event_type'], ['Application', 'Document', 'Test', 'Interview', 'Result', 'Other'])) {
                throw new Exception("Invalid timeline event type");
            }

            $timeline_stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);
            $timeline_stmt->bindParam(':event_name', $event['event_name']);
            $timeline_stmt->bindParam(':event_date', $event['event_date']);
            $timeline_stmt->bindParam(':event_description', $event['event_description']);
            $timeline_stmt->bindParam(':event_type', $event['event_type']);

            if (!$timeline_stmt->execute()) {
                throw new Exception("Failed to insert timeline event: " . implode(", ", $timeline_stmt->errorInfo()));
            }
        }
    }

    // Commit the transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'University details uploaded successfully',
        'university_id' => $university_id
    ]);

} catch (Exception $e) {
    // Rollback the transaction on error
    if (isset($conn)) {
        $conn->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} catch (Error $e) {
    // Rollback the transaction on error
    if (isset($conn)) {
        $conn->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Internal server error: ' . $e->getMessage()
    ]);
} 