<?php
include_once("db.php");
include_once("town_city.php");

$db = new Database(); 
$town_city = new TownCity($db);

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

    // Update the town_city
    $result = $town_city->update($id, $data);

    if ($result) {
        echo "town_city updated successfully.";
    } else {
        echo "Failed to update town_city.";
    }
}

// Get the town_city data
$id = $_GET["id"];
$town_cityData = $town_city->read($id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update town_city</title>
</head>
<body>
    <h1>Update town_city</h1>
    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $town_cityData['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $town_cityData['name']; ?>">
        <br>
        <input type="submit" value="Update">
    </form>
</body>
</html>