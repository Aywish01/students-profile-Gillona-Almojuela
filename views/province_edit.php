<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php"); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $db = new Database();
    $province = new Province($db);
    $province = $province->read($id); 

   
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],  
        'name' => $_POST['name'],
    ];

    $db = new Database();
    $province = new Province($db);

    // Call the edit method to update the town city data
    if ($province->update($id, $data)) {
    //javascript from stackoverflow for pop up message
    echo '<script>
                alert("Record updated.");
                window.location.href = "province_view.php?msg=Record updated.";
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
    <title>Edit Province</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Province Name</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $province['id']; ?>">
        
        
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" value="<?php echo $province['name']; ?>">
        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
