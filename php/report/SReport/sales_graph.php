<?php
include("dbcon.php");

// Initialize an empty array to store data points
$dataPoints = array();

// Generate an array with labels for all months from January to December
$months = array(
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
);

// Query MySQL database to get total sales for each month in 2024
$query = "SELECT MONTH(sales_date) AS month, SUM(total_sales) AS ts 
          FROM sales 
          WHERE YEAR(sales_date) = 2024 
          GROUP BY MONTH(sales_date)";

$result = mysqli_query($conn, $query);

// Initialize an associative array to store total sales for each month
$salesByMonth = array();
while ($row = mysqli_fetch_assoc($result)) {
    $month = intval($row['month']) - 1; // Adjust month to array index
    $salesByMonth[$month] = $row['ts'];
}

// Fill in missing months with zero sales
foreach ($months as $index => $month) {
    $sales = isset($salesByMonth[$index]) ? $salesByMonth[$index] : 0;
    $roundedSales = round($sales); // Round the sales figure
    $dataPoints[] = array("label" => $month, "y" => $roundedSales);
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Sales Report 2024"
                },
                axisY: {
                    title: "Total Sales"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
    <style>
        /*#chartContainer {
        margin-left: 220px;
    }*/
    </style>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>