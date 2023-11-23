<?php
require('config/config.php');
require('config/db.php');

$query03 = "SELECT EXTRACT(MONTH FROM o.orderdate) as Month_1997,
                cat.CategoryName as CategoryName, SUM(od.UnitPrice*od.Quantity*(1-od.Discount)) as sales
                FROM northwind.order_details od, northwind.orders o, northwind.products p, northwind.categories cat
                WHERE o.orderid = od.orderid and p.productid = od.ProductID AND
                p.CategoryID=cat.CategoryID and
                cat.CategoryName in('Meat/Poultry','Seafood') and o.orderdate LIKE '1997%'
                GROUP BY cat.CategoryName, Month_1997
                ORDER BY Month_1997, cat.CategoryName;";

$result03 = mysqli_query($conn, $query03);

if (mysqli_num_rows($result03) > 0) {
    $Sales_Meat = array();
    $Sales_Seafood = array();
    while ($row = mysqli_fetch_array($result03)) {
        if ($row['CategoryName'] == 'Seafood') {
            $Sales_Seafood[] = $row['sales'];
        } else {
            $Sales_Meat[] = $row['sales'];
        }
    }
    mysqli_free_result($result03);
    mysqli_close($conn);
} else {
    echo "No records matching your query were found.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2017 Sales Comparison</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="row">
        <div class="col-md-6">
            <div class="card ">
                <div class="header">
                    <h4 class="title">2017 Sales</h4>
                    <p class="category">All Meat/Poultry and Seafood Products</p>
                </div>
                <div class="content">
                    <!-- Prepare the canvas for the bar chart -->
                    <canvas id="chartMeatvsSeafood"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for the bar chart -->
    <script>
        // <!-- setup block -->
        const Sales_Meat = <?php echo json_encode($Sales_Meat); ?>;
        const Sales_Seafood = <?php echo json_encode($Sales_Seafood); ?>;
        const data3 = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'Meat/Poultry',
                    data: Sales_Meat,
                    backgroundColor: [
                        'rgb(255, 99, 132)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)'
                    ],
                    borderWidth: 1
                },
                {
                    label: 'SeaFood',
                    data: Sales_Seafood,
                    backgroundColor: [
                        'rgb(54, 162, 235)'
                    ],
                    borderColor: [
                        'rgb(54, 162, 235)'
                    ],
                    borderWidth: 1
                }
            ]
        };
        // <!-- config block -->
        const config3 = {
            type: 'bar',
            data: data3,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        // <!-- render block -->
        const chartMeatvsSeafood = new Chart(
            document.getElementById('chartMeatvsSeafood'),
            config3
        );
    </script>
</body>

</html>
