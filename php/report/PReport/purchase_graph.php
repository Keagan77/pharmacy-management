<?php
include("dbcon.php");

// Initialize an empty array to store data points
$dataPoints = array();

// Generate an array with labels for all months from January to December
$months = array(
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
);

// Query MySQL database to get total purchases for each month in 2024
$query = "SELECT MONTH(purchase_date) AS month, SUM(net_purchase) AS np 
          FROM purchase 
          WHERE YEAR(purchase_date) = 2024 
          GROUP BY MONTH(purchase_date)";

$result = mysqli_query($conn, $query);

// Initialize an associative array to store total purchases for each month
$purchaseByMonth = array();
while ($row = mysqli_fetch_assoc($result)) {
    $month = intval($row['month']) - 1; // Adjust month to array index
    $purchaseByMonth[$month] = $row['np'];
}

// Fill in missing months with zero purchases
foreach ($months as $index => $month) {
    $purchases = isset($purchaseByMonth[$index]) ? $purchaseByMonth[$index] : 0;
    $roundedPurchases = round($purchases); // Round the purchases figure
    $dataPoints[] = array("label" => $month, "y" => $roundedPurchases);
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("purchaseContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Purchase Report 2024"
                },
                axisY: {
                    title: "Net Purchase"
                },
                axisX: {
                    title: "Months"
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
        /* */
    </style>
</head>

<body>
    <div id="purchaseContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

</html>