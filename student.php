<?php
include_once("db.php");

class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            $sql = "INSERT INTO students(student_number, first_name, middle_name, last_name, gender, birthday) 
                    VALUES(:student_number, :first_name, :middle_name, :last_name, :gender, :birthday);";
            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->bindParam(':student_number', $data['student_number']);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':middle_name', $data['middle_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':gender', $data['gender']); 
            $stmt->bindParam(':birthday', $data['birthday']);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $this->db->getConnection()->lastInsertId();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }

    public function displayAll(){
        try {
            $sql = "SELECT * FROM students LIMIT 10";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as &$row) {
                $row['gender'] = ($row['gender'] == '1') ? 'M' : 'F';
                $row['birthday'] = date('M d Y', strtotime($row['birthday']));
            }

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM students WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE students SET
                    student_number = :student_number,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    gender = :gender,
                    birthday = :birthday
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->bindValue(':id', $data['id']);
            $stmt->bindValue(':student_number', $data['student_number']);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':middle_name', $data['middle_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':birthday', $data['birthday']);

            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM students WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e;
        }
    }

    public function testCreateStudent() {
        $data = [
            'student_number' => 'S12345',
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'gender' => '1',
            'birthday' => '1990-01-15',
        ];

        $student_id = $this->create($data);

        if ($student_id !== null) {
            echo "Test passed. Student created with ID: " . $student_id . PHP_EOL;
            return $student_id;
        } else {
            echo "Test failed. Student creation unsuccessful." . PHP_EOL;
        }
    }

    public function testReadStudent($id) {
        $studentData = $this->read($id);

        if ($studentData !== false) {
            echo "Test passed. Student data read successfully: " . PHP_EOL;
            print_r($studentData);
        } else {
            echo "Test failed. Unable to read student data." . PHP_EOL;
        }
    }

    public function testUpdateStudent($id, $data) {
        $success = $this->update($id, $data);

        if ($success) {
            echo "Test passed. Student data updated successfully." . PHP_EOL;
        } else {
            echo "Test failed. Unable to update student data." . PHP_EOL;
        }
    }

    public function testDeleteStudent($id) {
        $deleted = $this->delete($id);

        if ($deleted) {
            echo "Test passed. Student data deleted successfully." . PHP_EOL;
        } else {
            echo "Test failed. Unable to delete student data." . PHP_EOL;
        }
    }

    public function getGenderCount($gender) {
        $query = "SELECT COUNT(*) as count FROM students WHERE gender = :gender";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':gender', $gender);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }
}



// Uncomment the code below to test the modifications
// $student = new Student(new Database());

// $student_id = $student->testCreateStudent();
// $student->testReadStudent($student_id);
// $update_data = [
//     'id' => $student_id,
//     'student_number' => 'S67890',
//     'first_name' => 'Alice',
//     'middle_name' => 'Jane',
//     'last_name' => 'Doe',
//     'gender' => '0',
//     'birthday' => '1995-05-20',
// ];
// $student->testUpdateStudent($student_id, $update_data);
// $student->testDeleteStudent($student_id);
?>
