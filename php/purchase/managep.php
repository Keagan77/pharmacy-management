<?php
ob_start();
session_start();
include("dbcon.php");

$sql = "SELECT * FROM purchase";

// Execute query
$result = mysqli_query($conn, $sql);

$slno = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Purchase | Maharashtra Medical</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/purchase.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src="sortp.js"></script>
    <style>
        h3 {
            margin-left: 77%;
            display: inline-block;
        }

        select {
            width: 15%;
            float: right;
        }

        #nope {
            text-align: center;
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
                    <h1>Manage Purchase</h1>
                    <nobr><i class="fas fa-chart-bar">&nbsp; Manage Existing Purchase</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/purchase/addp.php"><i class="fas fa-chart-bar"></i>&nbsp; Add New</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>
            <h3>Sort By:</h3>
            <select id="sort-select">
                <option id='nope' value="" selected disabled>--Choose--</option>
                <option value="1">Sl No(DESC)</option>
                <option value="2">Invoice No</option>
                <option value="3">Medicine Name</option>
                <option value="4">Medicine Pack</option>
                <option value="5">Medicine Supplier</option>
                <option value="6">Payment Mode</option>
                <option value="7">Manufacturing Date</option>
                <option value="8">Expiry Date</option>
                <option value="9">Quantity</option>
                <option value="10">MRP</option>
                <option value="11">Discount</option>
                <option value="12">GST</option>
                <option value="13">Net Purchase</option>
                <option value="14">Purchase Date</option>
            </select><br><br>

            <table id="purchase-table">
                <tbody>
                    <tr>
                        <th>Sl No</th>
                        <th>Invoice No</th>
                        <th>Medicine Name</th>
                        <th>Medicine Pack</th>
                        <th>Medicine Supplier</th>
                        <th>Payment Method</th>
                        <th>Batch ID</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Qty</th>
                        <th>MRP</th>
                        <th>Disc %</th>
                        <th>GST %</th>
                        <th>Net Purchase</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                    </tr>
                    <?php

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $invoice = $row["invoice_no"];
                            $medname = $row["med_name"];
                            $supplier = $row["supplier"];
                            $pay = $row["pay_opt"];
                            $mrp = $row["mrp"];
                            $quantity = $row["quantity"];
                            $disc = $row["discount"];
                            $gst = $row["GST"];
                            $np = $row["net_purchase"];
                            $batch = $row["batch_id"];
                            $date = $row["purchase_date"];
                            $exp = $row["exp_date"];
                            $pack = $row["med_pack"];
                            $mfg = $row["mfg_date"];

                            $updateid = $row["sl_no"];
                            $deleteid = $row["sl_no"];

                            echo "
                        <tr>
                        <td>$slno</td>
                        <td>$invoice</td>
                        <td>$medname</td>
                        <td>$pack</td>
                        <td>$supplier</td>
                        <td>$pay</td>
                        <td>$batch</td>
                        <td>$mfg</td>
                        <td>$exp</td>
                        <td>$quantity</td>
                        <td>$mrp</td>
                        <td>$disc</td>
                        <td>$gst</td>
                        <td>$np</td>
                        <td>$date</td>
                        <td>
                        <button id='udt-btn-back'><a id='udt-btn' href='update.php?updateid= $updateid;'>Update</a></button><br>
                        <button id='del-btn-back'><a id='del-btn' href='delete.php?deleteid= $deleteid;'>Delete</a></button>
                        </td>
                        </tr>
                        ";
                            $slno++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <p>Note: Resize the Browser if content going out of bounds.</p>
            <hr>
        </div>

    </div>
</body>

</html>