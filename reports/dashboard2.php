<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <?php include('config/config.php'); ?>
    <?php include('config/db.php'); ?>

    <?php
    // Fetch the counts of students from specific provinces
    $provinces = array("East Delaneychester", "Gonzaloton", "South Dameon", "East Moises");

    $dataPoints = array();

    // Define an array of colors for the bars
    $colors = array("blue", "green", "orange", "red");

    for ($i = 0; $i < count($provinces); $i++) {
        $province = $provinces[$i];
        $color = $colors[$i];

        $sql = "SELECT COUNT(*) as count FROM student_details WHERE province = '$province'";
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dataPoints[] = array("label" => $province, "y" => $row["count"]);
        } else {
            // If no data is found for a province, set count to 0
            $dataPoints[] = array("label" => $province, "y" => 0);
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <style>
        #chartContainer {
            width: 80%;
            margin: 0 auto;
        }
    </style>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Student Distribution by Province"
                },
                axisY: {
                    title: "Number of Students",
                    includeZero: true
                },
                data: [{
                    type: "bar",
                    indexLabel: "{y}",
                    indexLabelPlacement: "inside",
                    indexLabelFontWeight: "bolder",
                    indexLabelFontColor: "white",
                    color: <?php echo json_encode($colors); ?>,
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
        <div id="chartContainer" style="height: 370px; display: inline-block; margin-left: 240px;"></div>
    </div>

    <?php include('../templates/footer.html'); ?>
</body>

</html>
