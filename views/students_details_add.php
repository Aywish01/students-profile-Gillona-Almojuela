<?php
include_once("../db.php"); // Include the Database class file
include_once("../student_details.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    
    'id' => $_POST['id'],
    'student_id' => $_POST['student_id'],
    'contact_number' => $_POST['contact_number'],
    'street' => $_POST['street'],
    'town_city' => $_POST['town_city'],
    'province' => $_POST['province'],
    'zip_code' => $_POST['zip_code'],

    ];

    // Instantiate the Database and Town City classes
    $database = new Database();
    $students = new StudentDetails($database);
    $students = $students->create($data);
    //javascript from stackoverflow for pop up message
    echo '<script>
                alert("Record added successfully.");
                window.location.href = "students_details.view.php?msg=Record added successfully.";
              </script>';
   
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

    <title>Add Student Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add students details</h1>
    <form action="" method="post" class="centered-form">
        <!-- <label for="id">students ID:</label>
        <input type="text" name="id" id="id" required> -->

        <label for="id">ID:</label>
    <input type="text" name="id" id="id" required><br>

    <label for="student_id">Student ID:</label>
    <input type="text" name="student_id" id="student_id" required><br>

    <label for="contactnumber">Contact Number:</label>
    <input type="text" name="contact_number" id="contact_number" required><br>

    <label for="street">Street:</label>
    <input type="text" name="street" id="street" required><br>

    <label for="towncity">Town/City:</label>
    <input type="text" name="town_city" id="town_city" required><br>

    <label for="province">Province:</label>
    <input type="text" name="province" id="province" required><br>

    <label for="zipcode">ZIP Code:</label>
    <input type="text" name="zip_code" id="zip_code" required><br>

        <input type="submit" value="Add students">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>



