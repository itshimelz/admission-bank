<?php
class TimelineEvent {
    private $conn;
    private $table_name = "application_timeline";

    public $id;
    public $university_id;
    public $event_name;
    public $event_description;
    public $event_date;
    public $event_type;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readByUniversity() {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE university_id = :university_id 
                 ORDER BY event_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":university_id", $this->university_id);
        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    university_id = :university_id,
                    event_name = :event_name,
                    event_description = :event_description,
                    event_date = :event_date,
                    event_type = :event_type,
                    status = :status";

        $stmt = $this->conn->prepare($query);

        $this->university_id = htmlspecialchars(strip_tags($this->university_id));
        $this->event_name = htmlspecialchars(strip_tags($this->event_name));
        $this->event_description = htmlspecialchars(strip_tags($this->event_description));
        $this->event_date = htmlspecialchars(strip_tags($this->event_date));
        $this->event_type = htmlspecialchars(strip_tags($this->event_type));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":university_id", $this->university_id);
        $stmt->bindParam(":event_name", $this->event_name);
        $stmt->bindParam(":event_description", $this->event_description);
        $stmt->bindParam(":event_date", $this->event_date);
        $stmt->bindParam(":event_type", $this->event_type);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    event_name = :event_name,
                    event_description = :event_description,
                    event_date = :event_date,
                    event_type = :event_type,
                    status = :status
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        $this->event_name = htmlspecialchars(strip_tags($this->event_name));
        $this->event_description = htmlspecialchars(strip_tags($this->event_description));
        $this->event_date = htmlspecialchars(strip_tags($this->event_date));
        $this->event_type = htmlspecialchars(strip_tags($this->event_type));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":event_name", $this->event_name);
        $stmt->bindParam(":event_description", $this->event_description);
        $stmt->bindParam(":event_date", $this->event_date);
        $stmt->bindParam(":event_type", $this->event_type);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?> 