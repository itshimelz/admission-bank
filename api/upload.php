<?php
header('Content-Type: application/json');
require_once 'config/database.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get the database connection
    $conn = getConnection();

    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    $required_fields = ['name', 'type', 'website', 'established_year', 'location', 'description'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Prepare the SQL statement
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

    // Bind parameters
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':type', $data['type']);
    $stmt->bindParam(':website', $data['website']);
    $stmt->bindParam(':established_year', $data['established_year']);
    $stmt->bindParam(':location', $data['location']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':admission_requirements', $data['admission_requirements'] ?? null);
    $stmt->bindParam(':application_deadline', $data['application_deadline'] ?? null);
    $stmt->bindParam(':tuition_fee', $data['tuition_fee'] ?? null);
    $stmt->bindParam(':contact_info', $data['contact_info'] ?? null);
    $stmt->bindParam(':programs_offered', $data['programs_offered'] ?? null);
    $stmt->bindParam(':campus_facilities', $data['campus_facilities'] ?? null);
    $stmt->bindParam(':ranking', $data['ranking'] ?? null);
    $stmt->bindParam(':image_url', $data['image_url'] ?? null);

    // Execute the statement
    if ($stmt->execute()) {
        $university_id = $conn->lastInsertId();

        // If timeline events are provided, insert them
        if (isset($data['timeline_events']) && is_array($data['timeline_events'])) {
            $timeline_sql = "INSERT INTO application_timeline (
                university_id, event_title, event_date, event_description, event_type
            ) VALUES (
                :university_id, :event_title, :event_date, :event_description, :event_type
            )";

            $timeline_stmt = $conn->prepare($timeline_sql);

            foreach ($data['timeline_events'] as $event) {
                $timeline_stmt->bindParam(':university_id', $university_id);
                $timeline_stmt->bindParam(':event_title', $event['event_title']);
                $timeline_stmt->bindParam(':event_date', $event['event_date']);
                $timeline_stmt->bindParam(':event_description', $event['event_description']);
                $timeline_stmt->bindParam(':event_type', $event['event_type']);
                $timeline_stmt->execute();
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'University details uploaded successfully',
            'university_id' => $university_id
        ]);
    } else {
        throw new Exception("Failed to upload university details");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
} 