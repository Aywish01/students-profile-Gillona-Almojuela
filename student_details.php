<?php

include_once("db.php");

class StudentDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            $sql = "INSERT INTO student_details (student_id, contact_number, street, zip_code, town_city, province) VALUES (:student_id, :contact_number, :street, :zip_code, :town_city, :province);";
            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip_code']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM student_details ORDER BY id DESC LIMIT 20";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM student_details WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($studentDetailId) {
        try {
            $sql = "DELETE FROM student_details WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->bindParam(':id', $studentDetailId);

            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function update($id, $studentId, $contactNumber, $street, $townCity, $province, $zipCode) {
        try {
            $query = "UPDATE student_details SET student_id = :studentId, contact_number = :contactNumber, street = :street, town_city = :townCity, province = :province, zip_code = :zipCode WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($query);

            $stmt->bindParam(':studentId', $studentId);
            $stmt->bindParam(':contactNumber', $contactNumber);
            $stmt->bindParam(':street', $street);
            $stmt->bindParam(':townCity', $townCity);
            $stmt->bindParam(':province', $province);
            $stmt->bindParam(':zipCode', $zipCode);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }
    public function addOrUpdate($data) {
        try {
            $existingDetail = $this->getDetailByStudentId($data['student_id']);

            if ($existingDetail) {
                return $this->update($existingDetail['id'], $data['student_id'], $data['contact_number'], $data['street'], $data['town_city'], $data['province'], $data['zip_code']);
            } else {
                return $this->create($data);
            }

        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function edit($studentDetailId, $data) {
        try {
            $existingDetail = $this->getDetailByStudentId($studentDetailId);
    
            if ($existingDetail) {
                return $this->update(
                    $existingDetail['id'],
                    $data['student_id'],
                    $data['contact_number'],
                    $data['street'],
                    $data['town_city'],
                    $data['province'],
                    $data['zip_code']
                );
            } else {
                return false;
            }
    
        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }
    

    public function getDetailByStudentId($studentId) {
        try {
            $sql = "SELECT * FROM student_details WHERE student_id = :student_id";
            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->bindParam(':student_id', $studentId);

            $stmt->execute();

            // Use fetch instead of fetchAll
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->logError($e);
            throw $e;
        }
    }

    public function logError($e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
