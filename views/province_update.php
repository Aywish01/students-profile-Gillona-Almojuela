<?php
include_once("db.php");
include_once("Province.php");

$db = new Database(); 
$province = new Province($db);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST["id"];
    $name = $_POST["name"];

    // Create an associative array with the data
    $data = array(
        "id" => $id,
        "name" => $name
    );


    // Update the province
    $result = $province->update($id, $data);

    if ($result) {
        echo "Province updated successfully.";
    } else {
        echo "Failed to update province.";
    }
}

// Get the province data
$id = $_GET["id"];
$provinceData = $province->read($id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Province</title>
</head>
<body>
    <h1>Update Province</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $provinceData['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $provinceData['name']; ?>">
        <br>
        <input type="submit" value="Update">

    </form>
</body>
</html>