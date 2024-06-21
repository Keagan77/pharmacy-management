<?php
ob_start();
session_start();
include("dbcon.php");

// Check if a month parameter is set in the URL, default to all months if not set
if (isset($_GET['month']) && $_GET['month'] >= 1 && $_GET['month'] <= 12) {
    $selectedMonth = $_GET['month'];
} else {
    $selectedMonth = "all";
}

// Check if custom date range is provided
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];
} else {
    $startDate = null;
    $endDate = null;
}

// SQL query to fetch sales data based on selected month, all months, or custom date range
if ($selectedMonth == "all") {
    $sql = "SELECT * FROM purchase";
} elseif ($selectedMonth == "custom" && ($startDate && $endDate)) { // Check if custom option is selected and dates are provided
    $sql = "SELECT * FROM purchase WHERE purchase_date BETWEEN '$startDate' AND '$endDate'";
} else {
    $sql = "SELECT * FROM purchase WHERE MONTH(purchase_date) = $selectedMonth";
}

// Execute query
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <link rel="stylesheet" href="/pharmacy-management-system/css/reports.css">
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("myDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
    </script>
    <style>
        #ed {
            margin-left: 2%;
        }

        .ar-btn {
            background-color: #007bff;
        }

        .ar-btn:hover {
            background-color: #0065d1;
        }
    </style>
</head>

<body>
    <?php
    include "../../../sidenav/sidenav.html";
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Purchase Report</h1>
                    <nobr><i class="fa fa-book">&nbsp; Purchase Report</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/report/PReport/custompurchase.php"><i class="fa fa-book"></i>&nbsp; Filter Report</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <div class="navbar">
                <a href="?month=all">All Year</a>
                <?php
                // Display clickable links for each month with abbreviated names
                for ($i = 1; $i <= 12; $i++) {
                    $monthName = date('M', mktime(0, 0, 0, $i, 1));
                    echo "<a href='?month=$i'>$monthName</a>";
                }
                ?>
            </div>
            <hr>

            <table id="purchaseTable">
                <tbody>
                    <tr>
                        <th>Invoice No</th>
                        <th>Medicine Name</th>
                        <th>Batch ID</th>
                        <th>Purchase Date</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                    <?php

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $invoice = $row["invoice_no"];
                            $medname = $row["med_name"];
                            $batch = $row["batch_id"];
                            $date = $row["purchase_date"];
                            $quantity = $row["quantity"];
                            $total = $row["net_purchase"];
                            echo "
                            <tr>
                                <td>$invoice</td>
                                <td>$medname</td>
                                <td>$batch</td>
                                <td>$date</td>
                                <td>$quantity</td>
                                <td>$total</td>
                            </tr>
                        ";
                        }

                        // Calculate total amount for the selected month(s)
                        $totalQuery = "SELECT ROUND(SUM(net_purchase), 2) AS total FROM purchase";
                        if ($selectedMonth != "all") {
                            $totalQuery .= " WHERE MONTH(purchase_date) = $selectedMonth";
                        }
                        $totalResult = $conn->query($totalQuery);
                        $totalRow = $totalResult->fetch_assoc();
                        $totalAmount = $totalRow['total'];

                        // Display total row
                        echo "
                        <tr>
                            <td colspan='5'><h3>Total:</h3></td>
                            <td><h2 style='color: green;'>$totalAmount</h2></td>
                        </tr>
                    ";
                    } else {
                        echo "<tr><td colspan='6'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <hr>

            <div>
                <button class="btn" style='text-align:center;' onclick="printTable()">Print</button>
                <button class="btn ar-btn" onclick="window.location.href='/pharmacy-management-system/php/report/PReport/custompurchase.php'">Filter</button>
            </div><br>
            <?php
            include("purchase_graph.php");
            ?><br><br>
        </div>

        <script>
            function printTable() {
                let monthName = <?php echo $selectedMonth == "all" ? "'All Year'" : "'" . date('F', mktime(0, 0, 0, $selectedMonth, 1)) . "'"; ?>;
                let printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<link rel="stylesheet" type="text/css" href="table.css">'); // Include external CSS file
                printWindow.document.write('<style>');
                printWindow.document.write('@media print { .navbar { display: none; } }'); // Hide navbar when printing
                printWindow.document.write('#purchaseTable { border-collapse: collapse; width: 100%; }');
                printWindow.document.write('#purchaseTable th, #purchaseTable td { border: 1px solid #dddddd; text-align: left; padding: 8px; }');
                printWindow.document.write('#purchaseTable th { background-color: #f2f2f2; }');
                printWindow.document.write('.address { text-align: center; margin: 0; padding: 0; }'); // CSS for the address part without bold
                printWindow.document.write('h1 { margin-bottom: 0; }'); // CSS to remove space between h1 and address
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h1 style = "text-align:center;">Maharashtra Medical</h1>');
                // Apply address class to address paragraphs
                printWindow.document.write('<p class="address">Shop 6, Chandresh Society, Station Road,</p>');
                printWindow.document.write("<p class='address'>Nallasopara(W), Palghar, Maharashtra</p>");
                printWindow.document.write("<p class='address'>Tel:02223466672 / 02276346532</p>");
                printWindow.document.write("<p class='address'>(Mob):996757323 / 9978745705</p><br>");
                printWindow.document.write("<hr style = 'font-weight:bold;'>");
                printWindow.document.write("<h2 style = 'text-align:center;text-decoration:underline;'>Purchase Report</h2>");
                printWindow.document.write('<h2 style="text-align:center;">' + monthName + ' Report</h2>');
                printWindow.document.write(document.getElementById('purchaseTable').outerHTML);
                printWindow.document.write("<br><br><hr>");
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }
        </script>




    </div>
</body>

</html>

<?php
ob_end_flush();
?>