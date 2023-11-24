<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <?php include('config/config.php'); ?>
    <?php include('config/db.php'); ?>

    <?php
    // Fetch the counts of male and female students from the database
    $sql = "SELECT gender, COUNT(*) as count FROM students GROUP BY gender";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $genderLabel = ($row["gender"] == 0) ? "Male" : "Female";
            $dataPoints[] = array("label" => $genderLabel, "y" => $row["count"]);
        }
    } else {
        echo "No data found";
    }

    // Close the database connection
    $conn->close();
    ?>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Gender Distribution of Students"
                },
                data: [{
                    type: "pie",
                    indexLabel: "{label} - {y}",
                    yValueFormatString: "#,##0.00\"%\"",
                    indexLabelPlacement: "inside",
                    indexLabelFontColor: "#36454F",
                    indexLabelFontSize: 18,
                    indexLabelFontWeight: "bolder",
                    startAngle: 90, // Change startAngle to make it horizontal
                    showInLegend: true,
                    legendText: "{label}",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>

<body>
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div style="text-align: center;">
    <div id="chartContainer" style="height: 550px; display: inline-block; margin-right: 220px;"></div>
</div>

    <?php include('../templates/footer.html'); ?>
</body>

</html>
