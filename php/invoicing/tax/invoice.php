<?php
ob_start();
session_start();

// Include database connection file
include("dbcon.php");

// Function to sanitize output
function sanitizeOutput($value)
{
    return htmlspecialchars($value);
}

// Initialize variable for serial number
$serialNo = 1;

// Check if form is submitted for filtering
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve start and end dates from POST data
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    // Query to select records within the specified date range
    $sql = "SELECT * FROM sales";
    if (!empty($startDate) && !empty($endDate)) {
        $sql .= " WHERE sales_date BETWEEN '$startDate' AND '$endDate'";
    }

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Prepare HTML for filtered records
    $output = '';
    $serialNo = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        // Sanitize output
        $invoice = sanitizeOutput($row["invoice_no"]);
        $medname = sanitizeOutput($row["med_name"]);
        $date = sanitizeOutput($row["sales_date"]);
        $batchId = sanitizeOutput($row["batch_id"]);
        $quantity = sanitizeOutput($row["quantity"]);
        $sp = sanitizeOutput($row["selling_price"]);
        $discount = sanitizeOutput($row["discount"]);
        $gst = sanitizeOutput($row["GST"]);
        $totalSales = sanitizeOutput($row["total_sales"]);
        $pay = htmlspecialchars($row["pay_opt"]);
        $cname = htmlspecialchars($row["customer_name"]);

        // Append HTML to $output
        $output .= "<tr>
                            <td>$serialNo</td>
                            <td>$invoice</td>
                            <td>$cname</td>
                            <td>$medname</td>
                            <td>$date</td>
                            <td><button id='prt-btn' onclick='printInvoice(\"$invoice\", \"$medname\", \"$date\", \"$batchId\", \"$quantity\", \"$sp\" ,\"$discount\", \"$gst\", \"$totalSales\",\"$pay\",\"$cname\")'>Print Invoice</button></td>
                        </tr>";

        // Increment serial number for next row
        $serialNo++;
    }

    // Send the HTML back to the AJAX request
    echo $output;

    // End PHP processing
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tax Invoice</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/CSS/invoice.css">
    <link rel="stylesheet" href="/pharmacy-management-system/CSS/filter.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='print.js'></script>
    <style>
        #ed {
            margin-left: 2%;
        }
    </style>
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
</head>

<body>
    <?php
    include "../../../sidenav/sidenav.html";
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Manage Tax Invoice</h1>
                    <nobr><i class="fas fa-balance-scale">&nbsp; Manage Existing Tax Invoice</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <label for="sdate">Start Date</label>
            <input type="date" id="start_date" class="date" name="sdate">

            <label for="edate" id="ed">End Date</label>
            <input type="date" id="end_date" class="date" name="edate">

            <button onclick="filterRecords()" id="fbtn">Filter</button>
            <button onclick="resetFilters()" id="rbtn">Reset</button><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Invoice No</th>
                        <th>Customer Name</th>
                        <th>Medicine Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="filtered_records">
                    <?php
                    // Include database connection file again
                    include("dbcon.php");

                    // Query to select all records from the 'sales' table
                    $sql = "SELECT * FROM sales";

                    // Execute query
                    $result = mysqli_query($conn, $sql);

                    // Check for errors
                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    // Counter variable to keep track of the serial number
                    $serialNo = 1;

                    // Fetching and displaying data
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Sanitize output
                            $invoice = sanitizeOutput($row["invoice_no"]);
                            $medname = sanitizeOutput($row["med_name"]);
                            $date = sanitizeOutput($row["sales_date"]);
                            $batchId = sanitizeOutput($row["batch_id"]);
                            $quantity = sanitizeOutput($row["quantity"]);
                            $sp = sanitizeOutput($row["selling_price"]);
                            $discount = sanitizeOutput($row["discount"]);
                            $gst = sanitizeOutput($row["GST"]);
                            $totalSales = sanitizeOutput($row["total_sales"]);
                            $pay = sanitizeOutput($row["pay_opt"]);
                            $cname = sanitizeOutput($row["customer_name"]);

                            // Output the data
                            echo "<tr>
                                        <td>$serialNo</td>
                                        <td>$invoice</td>
                                        <td>$cname</td>
                                        <td>$medname</td>
                                        <td>$date</td>
                                        <td><button id='prt-btn' onclick='printInvoice(\"$invoice\", \"$medname\", \"$date\", \"$batchId\", \"$quantity\", \"$sp\" ,\"$discount\", \"$gst\", \"$totalSales\",\"$pay\",\"$cname\")'>Print Invoice</button></td>
                                    </tr>";

                            // Increment serial number for next row
                            $serialNo++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
    <script>
        function filterRecords() {
            var startDate = document.getElementById("start_date").value;
            var endDate = document.getElementById("end_date").value;

            // AJAX call to filter records
            $.ajax({
                type: "POST",
                url: "invoice.php", // Sending data to the same PHP file
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    document.getElementById("filtered_records").innerHTML = response;
                }
            });
        }

        function resetFilters() {
            // Clear the input fields
            document.getElementById("start_date").value = "";
            document.getElementById("end_date").value = "";

            // Reload the page to reset filters
            location.reload();
        }
    </script>
</body>

</html>

<?php
ob_end_flush();
?>