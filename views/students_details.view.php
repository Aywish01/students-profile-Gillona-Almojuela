<?php
include_once("../db.php");
include_once("../student_details.php");

$db = new Database();
$connection = $db->getConnection();
$students = new StudentDetails($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Students Details</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Contact Number</th>
                    <th>Street</th>
                    <th>Town City</th>
                    <th>Province</th>
                    <th>Zip code</th>
                    <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
       
            
            
            <?php
            $results = $students->getAll(); 
            foreach ($results as $result) {
            ?>
            <tr>
                           <td><?php echo $result['id']; ?></td>
                        <td><?php echo $result['student_id']; ?></td>
                        <td><?php echo $result['contact_number']; ?></td>
                        <td><?php echo $result['street']; ?></td>
                        <td><?php echo $result['town_city']; ?></td>
                        <td><?php echo $result['province']; ?></td>
                        <td><?php echo $result['zip_code']; ?></td>
                <td>
                    <a href="students_details_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    |
                    <a href="students_details_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="students_details_add.php">Add New Record</a>

        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>