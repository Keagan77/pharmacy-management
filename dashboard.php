<?php
include("database.php");
session_start();

// Queries
$customer_sql = "SELECT COUNT(*) AS total_customers from CINFO";
$supplier_sql = "SELECT COUNT(*) AS total_sup from SUPINFO";
$med_sql = "SELECT COUNT(*) AS total_med from MEDINFO";
$sale_sql = "SELECT COUNT(*) AS sale from SALES";
$purchase_sql = "SELECT COUNT(*) AS purchase FROM PURCHASE";
$get_sales = "SELECT ROUND(SUM(total_sales), 2) AS total_sales FROM sales WHERE DATE(sales_date) = CURDATE()";
$get_purchase = "SELECT ROUND(SUM(net_purchase), 2) AS total_purchase FROM purchase WHERE DATE(purchase_date) = CURDATE()";
$get_exp = "SELECT count(*) as exp_date FROM MEDINFO WHERE DATE(exp_date) <= CURDATE()";

// Executing Queries
$csql = mysqli_query($conn, $customer_sql);
$spsql = mysqli_query($conn, $supplier_sql);
$msql = mysqli_query($conn, $med_sql);
$slsql = mysqli_query($conn, $sale_sql);
$psql = mysqli_query($conn, $purchase_sql);
$gsale = mysqli_query($conn, $get_sales);
$gpurch = mysqli_query($conn, $get_purchase);
$gexp = mysqli_query($conn, $get_exp);

// Fetching data
$row1 = mysqli_fetch_assoc($csql);
$row2 = mysqli_fetch_assoc($spsql);
$row3 = mysqli_fetch_assoc($msql);
$row4 = mysqli_fetch_assoc($slsql);
$row5 = mysqli_fetch_assoc($psql);
$row6 = mysqli_fetch_assoc($gsale);
$row7 = mysqli_fetch_assoc($gpurch);
$row8 = mysqli_fetch_assoc($gexp);

// Assigning Data to variables
$total_customers = $row1["total_customers"];
$total_supplier = $row2["total_sup"];
$total_meds = $row3["total_med"];
$sale_count = $row4["sale"];
$purchase_count = $row5["purchase"];
$total_sales = $row6["total_sales"];
$total_purchases = $row7["total_purchase"];
$exp_date = $row8["exp_date"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="./images/hands.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/sidenav.css">
    <link rel="stylesheet" href="CSS/dashboard.css">

    <style>
        .dbh {
            margin-bottom: 0;
        }

        #val {
            margin-top: 5%;
            text-align: center;
            color: green;
        }

        .in-chart {
            text-align: center;
        }

        #gear:hover {
            color: rgba(0, 0, 255, 0.5);
        }

        #gear:active {
            color: rgba(0, 0, 255, 0.5);
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
    include("sidenav/sidenav.html");
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Dashboard</h1>
                    <nobr><i class="fas fa-home">&nbsp; Home</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <div>
                <div class="widgets">
                    <div class="widget">
                        <h2 class="dbh">Total Customers</h2>
                        <h2 id="val"><?php echo $total_customers; ?></h2>
                    </div>
                    <div class="widget">
                        <h2 class="dbh">Total Suppliers </h2>
                        <h2 id="val"><?php echo $total_supplier; ?></h2>
                    </div>
                    <div class="widget">
                        <h2 class="dbh">Total Medicines</h2>
                        <h2 id="val"><?php echo $total_meds; ?></h2>
                    </div>
                    <div class="widget">
                        <h2 class="dbh">Expired Medicines</h2>
                        <h2 id="val"><?php echo $exp_date; ?></h2>
                    </div>
                    <div class="widget">
                        <h2 class="dbh">Total Sales</h2>
                        <h2 style="text-align:center; color: green;"> <?php echo $sale_count; ?></h2>
                    </div>
                    <div class="widget">
                        <h2 class="dbh">Total Purchases</h2>
                        <h2 id="val"> <?php echo $purchase_count; ?></h2>

                    </div>
                </div>
                <hr>

                <div class="quick-actions">
                    <h2>Quick Actions</h2><br>
                    <a href="/pharmacy-management-system/php/customer/addc.php">Add New Customer</a>
                    <a href="/pharmacy-management-system/php/sales/addsales.php">Add New Sales</a>
                    <a href="/pharmacy-management-system/php/supplier/addsup.php">Add New Supplier</a>
                    <a href="/pharmacy-management-system/php/purchase/addp.php">Add New Purchase</a>
                    <a href="/pharmacy-management-system/php/medicine/addm.php">Add New Medicine</a>
                    <a href="/pharmacy-management-system/php/invoicing/tax/invoice.php">View Tax Invoice</a>
                </div><br><br><br>
                <hr>


                <div class="reports">
                    <div class="chart">
                        <h2 style="text-align:center;">Sales Report</h2>
                        <div class="in-chart">
                            <h2 style="font-weight:bold;">Today's Sales : </h2>
                            <h2 style="color: green; font-weight: bold;">&#8377;
                                <?php //echo $total_sales;
                                if ($total_sales > 0) {
                                    echo $total_sales;
                                } else {
                                    echo '0.00';
                                }
                                ?>
                            </h2>
                        </div>
                    </div>

                    <div class="chart">
                        <h2 style="text-align:center;">Purchase Report</h2>
                        <div class="in-chart">
                            <h2 style="font-weight:bold;">Today's Purchase : </h2>
                            <h2 style="color: red; font-weight: bold;">&#8377;
                                <?php //echo $total_purchases; 
                                if ($total_purchases > 0) {
                                    echo $total_purchases;
                                } else {
                                    echo '0.00';
                                }
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>