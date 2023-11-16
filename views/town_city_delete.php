<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieve the 'id' from the URL

    
    $db = new Database();
    $town_city = new TownCity($db);

    // Call the delete method to delete the town city record
    if ($town_city->delete($id)) {
    //javascript from stackoverflow for pop up message
    echo '<script>
                alert("Record deleted successfully.");
                window.location.href = "town.city.view.php?msg=Record deleted successfully.";
              </script>';
    } else {
        echo "Failed to delete the record.";
    }
}
?>
