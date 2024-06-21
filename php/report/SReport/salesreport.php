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

// SQL query to fetch sales data based on selected month or all months
if ($selectedMonth == "all") {
    $sql = "SELECT * FROM sales";
} else {
    $sql = "SELECT * FROM sales WHERE MONTH(sales_date) = $selectedMonth";
}

// Execute query
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/reports.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
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
                    <h1>Sale Report</h1>
                    <nobr><i class="fa fa-book">&nbsp; Sale Report</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/report/SReport/customsales.php"><i class="fa fa-book"></i>&nbsp; Filter Report</a>
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

            <table id="salesTable">
                <tbody>
                    <tr>
                        <th>Invoice No</th>
                        <th>Medicine Name</th>
                        <th>Sales Date</th>
                        <th>Amount</th>
                    </tr>
                    <?php

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $invoice = $row["invoice_no"];
                            $medname = $row["med_name"];
                            $date = $row["sales_date"];
                            $amount = $row["total_sales"];
                            echo "
                            <tr>
                                <td>$invoice</td>
                                <td>$medname</td>
                                <td>$date</td>
                                <td>$amount</td>
                            </tr>
                        ";
                        }

                        // Calculate total amount for the selected month(s)
                        $totalQuery = "SELECT ROUND(SUM(total_sales), 2) AS total FROM sales";
                        if ($selectedMonth != "all") {
                            $totalQuery .= " WHERE MONTH(sales_date) = $selectedMonth";
                        }
                        $totalResult = $conn->query($totalQuery);
                        $totalRow = $totalResult->fetch_assoc();
                        $totalAmount = $totalRow['total'];

                        // Display total row
                        echo "
                        <tr>
                            <td colspan='3'><h3>Total:</h3></td>
                            <td><h2 style='color: green;'>$totalAmount</h2></td>
                        </tr>
                    ";
                    } else {
                        echo "<tr><td colspan='4'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <hr>

            <div>
                <button class="btn" onclick="printTable()">Print</button>
                <button class="btn ar-btn" onclick="window.location.href='/pharmacy-management-system/php/report/SReport/customsales.php'">Filter</button>
            </div><br>
            <?php
            include("sales_graph.php");
            ?><br><br>
        </div>

        <script>
            function printTable() {
                let monthName = <?php echo $selectedMonth == "all" ? "'All Year'" : "'" . date('F', mktime(0, 0, 0, $selectedMonth, 1)) . "'"; ?>;
                let printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<link rel="stylesheet" type="text/css" href="table.css">'); // Include external CSS file
                printWindow.document.write('<style>');
                printWindow.document.write('@media print { .navbar { display: none; } }'); // Hide navbar when printing
                printWindow.document.write('#salesTable { border-collapse: collapse; width: 100%; }');
                printWindow.document.write('#salesTable th, #salesTable td { border: 1px solid #dddddd; text-align: left; padding: 8px; }');
                printWindow.document.write('#salesTable th { background-color: #f2f2f2; }');
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h1 style = "text-align:center;margin-bottom:0;">Maharashtra Medical</h1>');
                printWindow.document.write('<p style = "text-align:center;margin:0;padding:0;">Shop 6, Chandresh Society, Station Road,</p>');
                printWindow.document.write("<p style = 'text-align:center;margin:0;padding:0;'>Nallasopara(W), Palghar, Maharashtra</p>");
                printWindow.document.write("<p style = 'text-align:center;margin:0;padding:0;'>Tel:02223466672 / 02276346532</p>");
                printWindow.document.write("<p style = 'text-align:center;margin:0;padding:0;'>(Mob):996757323 / 9978745705</p><br>"); // Address added here
                printWindow.document.write("<hr style = 'font-weight:bold'>");
                printWindow.document.write("<h2 style='text-align:center;text-decoration:underline'>Sales Report</h2>");
                printWindow.document.write('<h2 style="text-align:center;">' + monthName + ' Report</h2>'); // Add month name here
                printWindow.document.write(document.getElementById('salesTable').outerHTML);
                printWindow.document.write("<br><br><hr style = 'font-weight:bold'>");
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