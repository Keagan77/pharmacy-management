<?php
ob_start();
session_start();

include("dbcon.php");


$sql = "SELECT * FROM PURCHASE";

$sql1 = "SELECT ROUND(SUM(net_purchase), 2) AS np FROM PURCHASE";

$res1 = mysqli_query($conn, $sql1);

if ($res1) {
    $row = mysqli_fetch_assoc($res1);
    $total = $row['np'];
} else {
    $total = 0;
}

// Execute query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Purchase</title>
    <!-- <link rel="stylesheet" href="css/table.css"> -->
    <link rel="stylesheet" href="css/purchasereport.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/reports.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <link rel="stylesheet" href="/pharmacy-management-system/CSS/filter.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="print.js"></script>
    <style>
        .content {
            margin-left: 17%;
        }

        #ed1 {
            margin-left: 3%;
        }

        .btn {
            cursor: pointer;
            justify-content: center;
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
</head>

<body>
    <?php include "../../../sidenav/sidenav.html"; ?>
    <div class="container-fluid">
        <div class="container">
            <?php include "header.html"; ?>

            <label for="start">Start Date:</label>
            <input type="date" class="date" id="start" name="start">

            <label id="ed1" for="end">End Date:</label>
            <input type="date" id="end" name="end" class="date">

            <button class="fbtn" id="filterBtn">Filter</button>
            <button class="rbtn" id="resetBtn" onclick="resetPage()">Reset</button>

            <br><br>

            <table id="purchaseTable">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Medicine Name</th>
                        <th>Sales Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="purchaseBody">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $invoice = $row["invoice_no"];
                            $medname = $row["med_name"];
                            $date = $row["purchase_date"];
                            $amount = $row["net_purchase"];
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
                <button class="btn" style='text-align:center;' onclick="printTable()">Print</button>
                <button class="btn ar-btn" onclick="window.location.href='/pharmacy-management-system/php/report/PReport/preport.php'">All Reports</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("filterBtn").addEventListener("click", function() {
            var startDate = document.getElementById("start").value;
            var endDate = document.getElementById("end").value;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "filter_purchase.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    // Check if response contains records
                    if (response.trim() !== "") {
                        document.getElementById("purchaseBody").innerHTML = response;
                        // Calculate and display total amount based on filtered records
                        var totalAmount = 0;
                        document.querySelectorAll("#purchaseBody tr").forEach(function(row) {
                            totalAmount += parseFloat(row.querySelector("td:last-child").innerText);
                        });
                        document.getElementById("totalAmount").innerText = totalAmount.toFixed(2);
                    } else {
                        // No records found, display total sum of all purchases
                        var totalAmount = document.getElementById("totalAmount").innerText;
                        alert("No records found between the selected dates. Total purchase amount: " + totalAmount);
                    }
                }
            };
            xhr.send("start_date=" + startDate + "&end_date=" + endDate);
        });

        function resetPage() {
            // Redirect to the default page
            window.location.href = "custompurchase.php";
        }
    </script>

</body>

</html>