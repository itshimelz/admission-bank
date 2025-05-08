<?php
class University {
    private $conn;
    private $table_name = "universities";

    public $id;
    public $name;
    public $type;
    public $website;
    public $established_year;
    public $location;
    public $description;
    public $admission_requirements;
    public $application_deadline;
    public $tuition_fee;
    public $contact_info;
    public $programs_offered;
    public $campus_facilities;
    public $ranking;
    public $image_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE name = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->type = $row['type'];
            $this->website = $row['website'];
            $this->established_year = $row['established_year'];
            $this->location = $row['location'];
            $this->description = $row['description'];
            $this->admission_requirements = $row['admission_requirements'];
            $this->application_deadline = $row['application_deadline'];
            $this->tuition_fee = $row['tuition_fee'];
            $this->contact_info = $row['contact_info'];
            $this->programs_offered = $row['programs_offered'];
            $this->campus_facilities = $row['campus_facilities'];
            $this->ranking = $row['ranking'];
            $this->image_url = $row['image_url'];
            return true;
        }
        return false;
    }

    public function search($keywords) {
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE name LIKE ? OR description LIKE ? OR location LIKE ?
                ORDER BY name";

        $stmt = $this->conn->prepare($query);

        $keywords = "%{$keywords}%";
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        $stmt->execute();
        return $stmt;
    }

    public function getTimelineEvents() {
        $query = "SELECT * FROM application_timeline WHERE university_id = ? ORDER BY event_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }
}
?> 