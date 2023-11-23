<?php
include_once("../db.php"); // Include the Database class file
include_once("../student.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL

    $db = new Database();
    $student = new Student($db);

    // Call the delete method to delete the student record
    if ($student->delete($id)) {
        // JavaScript for pop-up message
        echo '<script>
                alert("Record deleted successfully.");
                window.location.href = "students.view.php?msg=Record deleted successfully.";
              </script>';
    } else {
        echo "Failed to delete the record.";
    }
}
?>
