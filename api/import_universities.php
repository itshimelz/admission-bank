<?php
require_once 'config/database.php';
require_once 'helpers/Response.php';

// Initialize database connection
$database = new Database();
$conn = $database->getConnection();

try {
    // Start transaction
    $conn->beginTransaction();

    // Read JSON files
    $public_universities = json_decode(file_get_contents(__DIR__ . '/../data/public_universities.json'), true);
    $private_universities = json_decode(file_get_contents(__DIR__ . '/../data/private_universities.json'), true);

    // Prepare SQL statement
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

    // Function to insert university
    function insertUniversity($conn, $stmt, $university, $type) {
        // Check if university already exists
        $check_sql = "SELECT id FROM universities WHERE name = :name";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':name', $university['name']);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            echo "University {$university['name']} already exists. Skipping...\n";
            return;
        }

        // Set default values
        $established_year = rand(1960, 2020); // Random year between 1960 and 2020
        $location = "Bangladesh"; // Default location
        $description = "A {$type} university in Bangladesh.";
        $admission_requirements = "HSC/A-Level with minimum GPA 3.0";
        $application_deadline = date('Y-m-d', strtotime('+3 months'));
        $tuition_fee = $type === 'Public' ? rand(5000, 10000) : rand(100000, 200000);
        $contact_info = "Contact information not available";
        $programs_offered = "Various undergraduate and graduate programs";
        $campus_facilities = "Library, Computer Lab, Sports Complex";
        $ranking = null;
        $image_url = null;

        // Bind parameters
        $stmt->bindParam(':name', $university['name']);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':website', $university['website']);
        $stmt->bindParam(':established_year', $established_year);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':admission_requirements', $admission_requirements);
        $stmt->bindParam(':application_deadline', $application_deadline);
        $stmt->bindParam(':tuition_fee', $tuition_fee);
        $stmt->bindParam(':contact_info', $contact_info);
        $stmt->bindParam(':programs_offered', $programs_offered);
        $stmt->bindParam(':campus_facilities', $campus_facilities);
        $stmt->bindParam(':ranking', $ranking);
        $stmt->bindParam(':image_url', $image_url);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Successfully added {$university['name']}\n";
        } else {
            echo "Error adding {$university['name']}: " . implode(", ", $stmt->errorInfo()) . "\n";
        }
    }

    // Insert public universities
    echo "\nImporting public universities...\n";
    foreach ($public_universities as $university) {
        insertUniversity($conn, $stmt, $university, 'Public');
    }

    // Insert private universities
    echo "\nImporting private universities...\n";
    foreach ($private_universities as $university) {
        insertUniversity($conn, $stmt, $university, 'Private');
    }

    // Commit transaction
    $conn->commit();
    echo "\nImport completed successfully!\n";

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
} catch (Error $e) {
    // Rollback transaction on error
    $conn->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
?> 