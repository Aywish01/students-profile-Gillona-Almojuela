<?php
require('config/config.php');
require('config/db.php');

$query_top3 = "SELECT ProductName FROM northwind.order_details,
                northwind.products
                WHERE products.ProductID=order_details.ProductID
                GROUP BY products.ProductID order by count(*) desc, products.ProductName
                limit 3";
$result_top3 = mysqli_query($conn, $query_top3);
$products_top3 = array();
while ($row = mysqli_fetch_array($result_top3)) {
    $products_top3[] = $row['ProductName'];
}
// Free result
mysqli_free_result($result_top3);
$Top1_Count = array_fill(0, 12, 0);
$Top2_Count = array_fill(0, 12, 0);
$Top3_Count = array_fill(0, 12, 0);
for ($counter = 0; $counter < 3; $counter++) {
    $query02 = "SELECT EXTRACT(MONTH FROM o.orderdate) as Month_1997,
                p.ProductName, COUNT(*) as num_order
                FROM northwind.order_details od, northwind.orders o,
                northwind.products p
                WHERE o.orderid = od.orderid and p.productid = od.ProductID and
                o.orderdate LIKE '1997%' and
                p.ProductName = '" . $products_top3[$counter] . "'
                GROUP BY p.ProductName, Month_1997
                ORDER BY Month_1997, p.ProductName;";
    $result02 = mysqli_query($conn, $query02);
    if (mysqli_num_rows($result02) > 0) {
        while ($row = mysqli_fetch_array($result02)) {
            if ($counter == 0) {
                $Top1_Count[$row['Month_1997']] = $row['num_order'];
            } elseif ($counter == 1) {
                $Top2_Count[$row['Month_1997']] = $row['num_order'];
            } else {
                $Top3_Count[$row['Month_1997']] = $row['num_order'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Products</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="content">
        <!-- Add a canvas element for the line chart -->
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Top 3 Products</h4>
                    <p class="category">Number of Orders Monthly</p>
                </div>
                <div class="content">
                    <canvas id="chartTop3"></canvas>
                </div>
            </div>
        </div>

        <!-- Script for the line chart -->
        <script>
            // <!-- setup block -->
            const Top1_Count = <?php echo json_encode($Top1_Count); ?>;
            const Top2_Count = <?php echo json_encode($Top2_Count); ?>;
            const Top3_Count = <?php echo json_encode($Top3_Count); ?>;
            const label_1 = <?php echo json_encode($products_top3[0]); ?>;
            const label_2 = <?php echo json_encode($products_top3[1]); ?>;
            const label_3 = <?php echo json_encode($products_top3[2]); ?>;
            const data2 = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: label_1,
                        data: Top1_Count,
                        fill: false,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    },
                    {
                        label: label_2,
                        data: Top2_Count,
                        fill: false,
                        backgroundColor: 'rgb(54, 162, 235)',
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    },
                    {
                        label: label_3,
                        data: Top3_Count,
                        fill: false,
                        backgroundColor: 'rgb(255,165,0)',
                        borderColor: 'rgb(255,165,0)',
                        tension: 0.1
                    }
                ]
            };
            // <!-- config block -->
            const config2 = {
                type: 'line',
                data: data2,
            };
            // <!-- render block -->
            const chartTop3 = new Chart(
                document.getElementById('chartTop3'),
                config2
            );
        </script>
    </div>
</body>

</html>
