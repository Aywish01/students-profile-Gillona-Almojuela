<?php
include_once("../db.php");
include_once("../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$students = new StudentDetails($db);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST["id"];
    $studentId = $_POST["student_id"];
    $contactNumber = $_POST["contact_number"];
    $street = $_POST["street"];
    $townCity = $_POST["town_city"];
    $province = $_POST["province"];
    $zipCode = $_POST["zip_code"];

    // Update the student details
    $students->update($id, $studentId, $contactNumber, $street, $townCity, $province, $zipCode);

    // Redirect to the student details page
    header("Location: students_details.php");
    exit();
}

// Get the student ID from the URL
$id = isset($_GET["id"]) ? $_GET["id"] : die("Error: Missing ID.");

// Get the student details
$student = $students->getById($id);

// Check if the student exists
if (!$student) {
    die("Error: Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Details</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
        <h2>Update Student Details</h2>
        <form method="post" action="update.php">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <label for="student_id">Student ID:</label>
            <input type="text" name="student_id" value="<?php echo $student['student_id']; ?>" required>
            
            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" value="<?php echo $student['contact_number']; ?>" required>
            
            <label for="street">Street:</label>
            <input type="text" name="street" value="<?php echo $student['street']; ?>" required>
            
            <label for="town_city">Town/City:</label>
            <input type="text" name="town_city" value="<?php echo $student['town_city']; ?>" required>
            
            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo $student['province']; ?>" required>
            
            <label for="zip_code">Zip Code:</label>
            <input type="text" name="zip_code" value="<?php echo $student['zip_code']; ?>" required>

            <input type="submit" value="Update">
        </form>
    </div>

    <!-- Include the footer -->
    <?php include('../templates/footer.html'); ?>
</body>
</html>
