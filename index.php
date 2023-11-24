<?php
include_once("db.php");
include_once("student.php");





$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Include the header -->
    <?php include('templates/header.html'); ?>
    <?php include('includes/navbar.php'); ?>

    <div class="content">
        <!-- Add a canvas element for the chart -->
        <canvas id="myChart" width="400" height="200"></canvas>

        <script>
            // Fetch data from the server and create a chart
            // Replace the following lines with actual data retrieval and processing
            var data = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'],
                datasets: [{
                    label: 'Number of Students',
                    data: [10, 20, 15, 25, 30, 22],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>

    <!-- Include the footer -->
    <?php include('templates/footer.html'); ?>
</body>
</html>
