<?php
include_once("../db.php");
include_once("../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$students = new StudentDetails($db);

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Perform the deletion of the student record
    $deleted = $students->delete($student_id);

    // Check if the deletion was successful
    if ($deleted) {
        // Redirect to the page showing the remaining records
        header("Location: students_details.view.php");
        exit();
    } else {
        // Handle the case where deletion fails (you may want to show an error message)
        echo "Failed to delete the student record.";
    }
} else {
    // Redirect to the page showing the list of students if 'id' is not set
    header("Location: students_details.view.php");
    exit();
}
?>
