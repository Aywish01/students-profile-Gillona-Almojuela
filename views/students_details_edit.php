<?php
include_once("../db.php"); // Include the Database class file
include_once("../student_details.php"); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $db = new Database();
    $students = new StudentDetails($db);
    $students = $student->read($id); 

   
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],  
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $students = new StudentDetails($db);

    // Call the edit method to update the town city data
    if ($students->update($id, $data)) {
    //javascript from stackoverflow for pop up message
    echo '<script>
                alert("Record updated.");
                window.location.href = "students_details.view.php?msg=Record updated.";
              </script>';
    } else {
        echo "Failed to update the record.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit students</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit students Details</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $students['id']; ?>">
        
        
        <label for="id">ID:</label>
<input type="text" name="id" id="id" value="<?php echo $students['id']; ?>">

<label for="student_id">Student ID:</label>
<input type="text" name="student_id" id="student_id" value="<?php echo $students['student_id']; ?>">

<label for="contactnumber">Contact Number:</label>
<input type="text" name="contact_number" id="contact_number" value="<?php echo $students['contactnumber']; ?>">

<label for="street">Street:</label>
<input type="text" name="street" id="street" value="<?php echo $students['street']; ?>">

<label for="towncity">Town/City:</label>
<input type="text" name="town_city" id="town_city" value="<?php echo $students['towncity']; ?>">

<label for="province">Province:</label>
<input type="text" name="province" id="province" value="<?php echo $students['province']; ?>">

<label for="zipcode">ZIP Code:</label>
<input type="text" name="zip_code" id="zip_code" value="<?php echo $students['zipcode']; ?>">



        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
