<?php
include_once("../db.php");
include_once("../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$students = new StudentDetails($db);

// Check if the ID parameter is set in the URL
if(isset($_GET['id'])) {
    $studentId = $_GET['id'];

    // Fetch student details based on the provided ID
    $student = $students->getById($studentId);

    // Check if the student with the given ID exists
    if(!$student) {
        // Redirect to the main page if the student is not found
        header("Location: students_details.view.php");
        exit();
    }
} else {
    // Redirect to the main page if the ID parameter is not set
    header("Location: students_details.view.php");
    exit();
}

// Handle form submission for updating student details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and update the student details in the database

    $isValid = true;

    if ($isValid) {
        $students->update($studentId, $_POST['student_id'], $_POST['contact_number'], $_POST['street'], $_POST['town_city'], $_POST['province'], $_POST['zip_code']);

        // Add a success message
        $successMessage = "Record updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
        <h2>Edit Student Details</h2>

        <!-- Display success message if available -->
        <?php if(isset($successMessage)) { ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php } ?>

        <form method="post" action="">
            <!-- Display existing student details in the form for editing -->
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" value="<?php echo $student['student_id']; ?>" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo $student['contact_number']; ?>" required>

            <label for="street">Street:</label>
            <input type="text" id="street" name="street" value="<?php echo $student['street']; ?>" required>

            <label for="town_city">Town/City:</label>
            <input type="text" id="town_city" name="town_city" value="<?php echo $student['town_city']; ?>" required>

            <label for="province">Province:</label>
            <input type="text" id="province" name="province" value="<?php echo $student['province']; ?>" required>

            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" value="<?php echo $student['zip_code']; ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>

    <!-- Include the footer -->
    <?php include('../templates/footer.html'); ?>
</body>
</html>
