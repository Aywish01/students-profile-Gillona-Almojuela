<?php
include_once("db.php");
include_once("student_details.php");

$db = new Database(); 
$students = new StudentDetails($db);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST["id"];
    $student_id = $_POST["student_id"];
    $contact_number = $_POST["contact_number"];
    $street = $_POST["street"];
    $town_city = $_POST["town_city"];
    $province = $_POST["province"];
    $zip_code = $_POST["zip_code"];
    

    // Create an associative array with the data
    $data = array(
        "id" => $id,
        "student_id" => $student_id,
        "contact_number" => $contact_number,
        "street" => $street,
        "town_city" => $town_city,
        "province" => $province,
        "zip_code" => $zip_code,
        
    );


    // Update the province
    $result = $students->update($id, $data);

    if ($result) {
        echo "Students Details updated successfully.";
    } else {
        echo "Failed to update Students Deatials.";
    }
}

// Get the province data
$id = $_GET["id"];
$students = $student->read($id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Students Details</title>
</head>
<body>
    <h1>Update Students Deatils</h1>
    <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $students['id']; ?>">

<label for="student_id">Student ID:</label>
<input type="text" name="student_id" value="<?php echo $students['student_id']; ?>">

<label for="contactnumber">Contact Number:</label>
<input type="text" name="contact_number" value="<?php echo $students['contactnumber']; ?>">

<label for="street">Street:</label>
<input type="text" name="street" value="<?php echo $students['street']; ?>">

<label for="towncity">Town/City:</label>
<input type="text" name="town_city" value="<?php echo $students['towncity']; ?>">

<label for="province">Province:</label>
<input type="text" name="province" value="<?php echo $students['province']; ?>">

<label for="zipcode">ZIP Code:</label>
<input type="text" name="zip_code" value="<?php echo $students['zipcode']; ?>">


        <br>
        <input type="submit" value="Update">

    </form>
</body>
</html>