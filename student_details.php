<?php
include_once("db.php"); // Include the file with the Database class

class StudentDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a student detail entry and link it to a student
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO student_details(student_id, contact_number, street, zip_code, town_city, province) VALUES(:student_id, :contact_number, :street, :zip_code, :town_city, :province);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip_code']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Get all student details
    public function getAll() {
        try {
            // Prepare the SQL SELECT statement
            $sql = "SELECT * FROM student_details";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Execute the SELECT query
            $stmt->execute();

            // Fetch all rows as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Delete a student detail entry
    public function delete($studentDetailId) {
        try {
            // Prepare the SQL DELETE statement
            $sql = "DELETE FROM student_details WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind the value to the placeholder
            $stmt->bindParam(':id', $studentDetailId);

            // Execute the DELETE query
            $stmt->execute();

            // Check if the delete was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Update a student detail entry
    public function update($studentDetailId, $data) {
        try {
            // Prepare the SQL UPDATE statement
            $sql = "UPDATE student_details SET contact_number = :contact_number, street = :street, zip_code = :zip_code, town_city = :town_city, province = :province WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':id', $studentDetailId);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip_code']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            // Execute the UPDATE query
            $stmt->execute();

            // Check if the update was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Add a new student detail entry or update if it already exists
    public function addOrUpdate($data) {
        try {
            // Check if the student detail entry already exists
            $existingDetail = $this->getDetailByStudentId($data['student_id']);

            if ($existingDetail) {
                // If exists, update the entry
                return $this->update($existingDetail['id'], $data);
            } else {
                // If not, create a new entry
                return $this->create($data);
            }

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Get student detail by student ID
    public function getDetailByStudentId($studentId) {
        try {
            // Prepare the SQL SELECT statement
            $sql = "SELECT * FROM student_details WHERE student_id = :student_id";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind the value to the placeholder
            $stmt->bindParam(':student_id', $studentId);

            // Execute the SELECT query
            $stmt->execute();

            // Fetch the first row as an associative array
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}
?>
