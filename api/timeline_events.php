<?php
// Prevent PHP errors from being displayed
error_reporting(0);
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    include_once 'config/database.php';
    include_once 'models/TimelineEvent.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception("Database connection failed");
    }

    $timeline = new TimelineEvent($db);
    $method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
            if(isset($_GET['university_id'])) {
                $timeline->university_id = $_GET['university_id'];
                $stmt = $timeline->readByUniversity();
                $num = $stmt->rowCount();
                
                if($num > 0) {
                    $events_arr = array();
                    $events_arr["records"] = array();
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $event_item = array(
                            "id" => $id,
                            "university_id" => $university_id,
                            "event_name" => $event_name,
                            "event_description" => $event_description,
                            "event_date" => $event_date,
                            "event_type" => $event_type,
                            "status" => $status
                        );
                        array_push($events_arr["records"], $event_item);
                    }
                    http_response_code(200);
                    echo json_encode($events_arr);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "No timeline events found."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "University ID is required."));
            }
            break;
            
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            
            if(
                !empty($data->university_id) &&
                !empty($data->event_name) &&
                !empty($data->event_date) &&
                !empty($data->event_type)
            ) {
                $timeline->university_id = $data->university_id;
                $timeline->event_name = $data->event_name;
                $timeline->event_description = $data->event_description ?? '';
                $timeline->event_date = $data->event_date;
                $timeline->event_type = $data->event_type;
                $timeline->status = $data->status ?? 'active';
                
                if($timeline->create()) {
                    http_response_code(201);
                    echo json_encode(array("message" => "Timeline event created successfully."));
                } else {
                    throw new Exception("Unable to create timeline event.");
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to create timeline event. Data is incomplete."));
            }
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            
            if(
                !empty($data->id) &&
                !empty($data->event_name) &&
                !empty($data->event_date) &&
                !empty($data->event_type)
            ) {
                $timeline->id = $data->id;
                $timeline->event_name = $data->event_name;
                $timeline->event_description = $data->event_description ?? '';
                $timeline->event_date = $data->event_date;
                $timeline->event_type = $data->event_type;
                $timeline->status = $data->status ?? 'active';
                
                if($timeline->update()) {
                    http_response_code(200);
                    echo json_encode(array("message" => "Timeline event updated successfully."));
                } else {
                    throw new Exception("Unable to update timeline event.");
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to update timeline event. Data is incomplete."));
            }
            break;
            
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            
            if(!empty($data->id)) {
                $timeline->id = $data->id;
                
                if($timeline->delete()) {
                    http_response_code(200);
                    echo json_encode(array("message" => "Timeline event deleted successfully."));
                } else {
                    throw new Exception("Unable to delete timeline event.");
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to delete timeline event. ID is required."));
            }
            break;
            
        default:
            http_response_code(405);
            echo json_encode(array("message" => "Method not allowed."));
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array(
        "message" => "Error: " . $e->getMessage(),
        "error" => true
    ));
}
?> 