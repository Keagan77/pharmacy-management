<?php
ob_start();
session_start();

include("dbcon.php");

$sql = "SELECT * FROM SALES";

$sql1 = "SELECT ROUND(SUM(total_sales), 2) AS ts FROM SALES";

$res1 = mysqli_query($conn, $sql1);

if ($res1) {
    $row = mysqli_fetch_assoc($res1);
    $total = $row['ts'];
} else {
    $total = 0; // Default value if query fails
}

// Execute query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Sales</title>
    <!-- <link rel="stylesheet" href="css/table.css"> -->
    <link rel="stylesheet" href="css/salesreport.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/reports.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <link rel="stylesheet" href="/pharmacy-management-system/CSS/filter.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .content {
            margin-left: 17%;
        }

        #ed1 {
            margin-left: 3%;
        }

        .fbtn,
        .rbtn {
            width: 5%;
            background-color: #49be4d;
            color: white;
            padding: 8px 8px;
            margin: 7px 7px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .rbtn,
        .ar-btn {
            background-color: #007bff;
        }

        .fbtn:hover {
            background-color: #329935;
        }

        .rbtn:hover,
        .ar-btn:hover {
            background-color: #0065d1;
        }
    </style>
    <script src="print.js"></script>
</head>

<body>
    <?php include "../../../sidenav/sidenav.html"; ?>
    <div class="container-fluid">
        <div class="container">
            <?php include "header.html"; ?>

            <label for="start">Start Date:</label>
            <input class="date" type="date" id="start" name="start">

            <label id="ed1" for="end">End Date:</label>
            <input class="date" type="date" id="end" name="end">

            <button class="fbtn" id="filterBtn">Filter</button>
            <button class="rbtn" id="resetBtn" onclick="resetPage()">Reset</button>

            <br><br>

            <table id="salesTable">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Medicine Name</th>
                        <th>Sales Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="salesBody">
                    <?php
                    if ($result->num_rows > 0) {
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
                    } else {
                        echo "<tr><td colspan='4'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='3'>
                            <h3>Total:</h3>
                        </td>
                        <td>
                            <h2 id="totalAmount" style='color: green;'><?php echo $total; ?></h2>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div>
                <button class="btn" onclick="printTable()">Print</button>
                <button class="btn ar-btn" onclick="window.location.href='/pharmacy-management-system/php/report/SReport/salesreport.php'">All Reports</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("filterBtn").addEventListener("click", function() {
            let startDate = document.getElementById("start").value;
            let endDate = document.getElementById("end").value;
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "filter_sales.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = xhr.responseText;
                    // Check if response contains records
                    if (response.trim() !== "") {
                        document.getElementById("salesBody").innerHTML = response;
                        // Calculate and display total amount based on filtered records
                        let totalAmount = 0;
                        document.querySelectorAll("#salesBody tr").forEach(function(row) {
                            totalAmount += parseFloat(row.querySelector("td:last-child").innerText);
                        });
                        document.getElementById("totalAmount").innerText = totalAmount.toFixed(2);
                    } else {
                        // No records found, display total sum of all sales
                        let totalAmount = document.getElementById("totalAmount").innerText;
                        alert("No records found between the selected dates. Total sales amount: " + totalAmount);
                    }
                }
            };
            xhr.send("start_date=" + startDate + "&end_date=" + endDate);
        });

        function resetPage() {
            // Redirect to the default page
            window.location.href = "customsales.php";
        }
    </script>

</body>

</html>