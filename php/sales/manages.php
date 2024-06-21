<?php
ob_start();
session_start();
include("dbcon.php");

$sql = "SELECT * FROM sales";

// Execute query
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sale</title>
    <style>
        .content {
            margin-left: 210px;
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/sale.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src="sorts.js"></script>
    <style>
        select {
            width: 15%;
            float: right;
        }

        h3 {
            display: inline-block;
            margin-left: 77%;
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
    include "../../sidenav/sidenav.html";
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Manage Sale</h1>
                    <nobr><i class="fas fa-chart-bar">&nbsp; Manage Existing Sale</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/sales/addsales.php"><i class="fas fa-chart-bar"></i>&nbsp; Add New</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <h3>Sort By:</h3>
            <select id="sort-select">
                <option id='nope' value="" selected disabled>--Choose--</option>
                <!--<option value="0">Sl No</option>-->
                <option value="1">Invoice No</option>
                <option value="2">Customer</option>
                <option value="3">Medicine</option>
                <option value="4">Payment Method</option>
                <option value="5">Quantity</option>
                <option value="6">Selling Price</option>
                <option value="7">Discount</option>
                <option value="8">GST</option>
                <option value="9">Total Sales</option>
                <option value="10">Sales Date</option>
            </select><br><br>
            <table id="sales-table">
                <tbody>
                    <tr>
                        <th>Sl No</th>
                        <th>Invoice No</th>
                        <th>Customer Name</th>
                        <th>Medicine Name</th>
                        <th>Batch ID</th>
                        <th>Payment Method</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Discount(%)</th>
                        <th>GST(%)</th>
                        <th>Total Sales</th>
                        <th>Sales Date</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $slno = 1; // Initialize serial number
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $invoice = $row["invoice_no"];
                            $medname = $row["med_name"];
                            $batch = $row["batch_id"];
                            $customer = $row["customer_name"];
                            $pay = $row["pay_opt"];
                            $quantity = $row["quantity"];
                            $sp = $row["selling_price"];
                            $disc = $row["discount"];
                            $gst = $row["GST"];
                            $sales = $row["total_sales"];
                            $date = $row["sales_date"];

                            $updateid = $row["sl_no"];
                            $deleteid = $row["sl_no"];

                            echo "
                            <tr>
                                <td>$slno</td>
                                <td>$invoice</td>
                                <td>$customer</td>
                                <td>$medname</td>
                                <td>$batch</td>
                                <td>$pay</td>
                                <td>$quantity</td>
                                <td>$sp</td>
                                <td>$disc%</td>
                                <td>$gst%</td>
                                <td>$sales</td>
                                <td>$date</td>
                                <td>
                                    <button id='udt-btn-back'><a id='udt-btn' href='update.php?updateid=$updateid;'>Update</a></button><br>
                                    <button id='del-btn-back'><a id='del-btn' href='delete.php?deleteid=$deleteid;'>Delete</a></button>
                                </td>
                            </tr>
                            ";
                            $slno++; // Increment serial number for the next row
                        }
                    } else {
                        echo "<tr><td colspan='4'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>