<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config/database.php';
include_once 'models/University.php';
require_once 'helpers/Response.php';

$database = new Database();
$db = $database->getConnection();

$university = new University($db);

$stmt = $university->read();
$num = $stmt->rowCount();

if($num > 0) {
    $universities_arr = array();
    $universities_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $university_item = array(
            "id" => $id,
            "name" => $name,
            "type" => $type,
            "website" => $website,
            "established_year" => $established_year,
            "location" => $location,
            "description" => $description,
            "admission_requirements" => $admission_requirements,
            "application_deadline" => $application_deadline,
            "tuition_fee" => $tuition_fee,
            "contact_info" => $contact_info,
            "programs_offered" => $programs_offered,
            "campus_facilities" => $campus_facilities,
            "ranking" => $ranking,
            "image_url" => $image_url
        );

        array_push($universities_arr["records"], $university_item);
    }

    Response::success($universities_arr["records"], 'Universities fetched successfully');
} else {
    Response::error('No universities found.', 404);
}
?> 