<?php
ob_start();
session_start();
include "dbcon.php";

if (isset($_GET['updateid'])) {
    $id1 = $_GET['updateid'];
    $sql = "SELECT * FROM SALES WHERE sl_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id1);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (isset($_POST["submit"])) {
        $invoice = $_POST["invoice"];
        $medname = $_POST["med_name"];
        $customer = $_POST["customer"];
        $supplier = ""; // No longer used
        $pay = $_POST["payment"];
        $quantity = $_POST["squantity"];
        $sprice = $_POST["sprice"];
        $disc = $_POST["disc"];
        $gst = $_POST["gst"];
        $date = $_POST["sdate"];

        // Basic data validation
        if (empty($invoice) || empty($medname) || empty($customer) || empty($pay) || empty($quantity) || empty($sprice) || empty($disc) || empty($gst) || empty($date)) {
            echo "All fields are required.";
            exit;
        }

        // Fetch MRP from MEDINFO table based on selected medicine name
        $sql_mrp = "SELECT mrp FROM MEDINFO WHERE med_name = ?";
        $stmt_mrp = $conn->prepare($sql_mrp);
        $stmt_mrp->bind_param("s", $medname);
        $stmt_mrp->execute();
        $result_mrp = $stmt_mrp->get_result();
        $row_mrp = $result_mrp->fetch_assoc();
        $mrp = $row_mrp['mrp'];

        $actual_price = $mrp * $quantity;

        // Calculate the discount amount
        $disc_price = $actual_price * ($disc / 100);

        // Calculate the total price after discount
        $total_price = $actual_price - $disc_price;

        // Calculate the total sales before GST
        $total_sales_before_gst = $total_price;

        // Calculate the GST amount
        $gst_value = $total_sales_before_gst * ($gst / 100);

        // Calculate the final total sales including GST
        $total_sales = $total_sales_before_gst + $gst_value;

        try {
            $sql_update = "UPDATE SALES SET invoice_no = ?, customer_name = ?, med_name = ?, pay_opt = ?, quantity = ?, selling_price = ?, discount = ?, GST = ?, total_sales = ?, sales_date = ? WHERE sl_no = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("isssiddddsi", $invoice, $customer, $medname, $pay, $quantity, $sprice, $disc, $gst, $total_sales, $date, $id1);
            $stmt_update->execute();
            $stmt_update->close();

            echo "<script>alert('Sales Updated Successfully!');</script>";
            echo "<script>window.location.href = 'manages.php';</script>";
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    $invoice1 = $row["invoice_no"];
    $cust1 = $row["customer_name"];
    $medname1 = $row["med_name"];
    $pay1 = $row["pay_opt"];
    $batch1 = $row["batch_id"];
    $quantity1 = $row["quantity"];
    $sp1 = $row["selling_price"];
    $disc1 = $row["discount"];
    $tot1 = $row["total_sales"];
    $gst1 = $row["GST"];
    $date1 = $row["sales_date"];
} else {
    echo "Update ID is not provided!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Sales</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/sale.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    <h1>Update Sales</h1>
                    <nobr><i class="fas fa-chart-bar">&nbsp; Update Exisating Sales</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/sales/manages.php"><i class="fas fa-chart-bar"></i>&nbsp; Manage</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <p style="text-decoration:underline; color:green;">Note: Re-Enter MRP for Accurate Calculation</p>
            <form action="update.php?updateid=<?php echo $id1; ?>" method="post">

                <label for="invoice">Invoice Number :</label><br>
                <input type="text" name="invoice" placeholder="Invoice Number" value="<?php echo $invoice1; ?>"><br><br>

                <label for="customer">Customer Name: [If Applicable]</label> <br>
                <input type="text" name="customer" placeholder="Customer Name" list="customers" value="<?php echo $cust1; ?>"> <br><br>

                <datalist id="customers">
                    <?php
                    $csql = "SELECT C_NAME FROM CINFO";
                    $cexe = mysqli_query($conn, $csql);
                    if ($cexe && mysqli_num_rows($cexe) > 0) {
                        while ($row1 = mysqli_fetch_assoc($cexe)) {
                            // Output each customer name as an option in the datalist
                            echo '<option value="' . $row1['C_NAME'] . '"></option>';
                        }
                    }
                    ?>
                </datalist>

                <label for="med_name">Medicine Name :</label> <br>
                <input type="text" name="med_name" list="medicines" id="meds" placeholder="Select Medicine Name" value="<?php echo $medname1; ?>">
                <!-- Display available quantity next to the medicine name field -->
                <datalist id="medicines">
                    <?php
                    $sql = "SELECT med_name,mrp FROM MEDINFO";
                    $med_result = mysqli_query($conn, $sql);
                    if ($med_result && mysqli_num_rows($med_result) > 0) {
                        while ($row = mysqli_fetch_assoc($med_result)) {
                            // Output each medicine name as an option in the datalist
                            echo '<option value="' . $row['med_name'] . '" data-mrp="' . $row['mrp'] . '">';
                        }
                    }
                    ?>
                </datalist><br><br>

                <label for="mrp">MRP :</label><br>
                <input type="text" name="mrp" id="mrp" placeholder="00"><br><br>

                <label for="batch_id">Batch_ID :</label> <br>
                <input type="text" name="batch_id" id="batch_id" value="<?php echo $batch1; ?>"><br><br>

                <label for="sprice">Selling Price: </label><br>
                <input type="text" name="sprice" id="sprice" placeholder="00" value='<?php echo $sp1; ?>' required> <br><br>

                <label for="squantity">Sales Quantity: </label><br>
                <input type="text" name="squantity" id="squantity" placeholder="00" value='<?php echo $quantity1; ?>' required> <br> <br>

                <label for="disc">Discount(%): </label><br>
                <input type="text" name="disc" id="disc" placeholder="0%" value='<?php echo $disc1; ?>' required> <br> <br>

                <label for="disc">GST(%): </label><br>
                <input type="text" name="gst" id="gst" placeholder="0%" value='<?php echo $gst1; ?>' required> <br> <br>

                <label for="total">Total Sales: </label> <br>
                <input type="text" name="total" id="total" placeholder="00" disabled><br><br>


                <label for="payment">Payment Method: </label><br>
                <select name="payment" required>
                    <option disabled selected>-Select Payment Method-</option>
                    <option value="Cash" <?php if ($pay1 == "Cash") echo "selected"; ?>>Cash</option>
                    <option value="UPI" <?php if ($pay1 == "UPI") echo "selected"; ?>>UPI</option>
                    <option value="Net Banking" <?php if ($pay1 == "Net Banking") echo "selected"; ?>>Net Banking</option>
                </select><br><br>

                <label for="sdate">Sales Date: </label><br>
                <input type="date" name="sdate" value=<?php echo $date1; ?> required><br><br>
                <hr>

                <input type="submit" value="Update" name="submit">
                <input type="reset" value="Reset">
                <script>
                    $(document).ready(function() {
                        // Function to update MRP based on selected medicine name
                        $("#meds").on("change", function() {
                            var selectedMedicine = $(this).val();
                            var selectedOption = $(this).find('option[value="' + selectedMedicine + '"]');
                            var mrpValue = selectedOption.data('mrp');
                            $("#mrp").val(mrpValue);
                        });
                    });
                    $(document).ready(function() {
                        // Function to calculate total sales
                        function calculateTotalSales() {
                            var sellingPrice = parseFloat($("#sprice").val());
                            var quantity = parseInt($("#squantity").val());
                            var discount = parseFloat($("#disc").val());
                            var gst = parseFloat($("#gst").val());

                            // Calculate total price before discount
                            var totalPriceBeforeDiscount = sellingPrice * quantity;

                            // Calculate discount amount
                            var discountAmount = totalPriceBeforeDiscount * (discount / 100);

                            // Calculate total price after discount
                            var totalPriceAfterDiscount = totalPriceBeforeDiscount - discountAmount;

                            // Calculate GST amount
                            var gstAmount = totalPriceAfterDiscount * (gst / 100);

                            // Calculate total sales including GST
                            var totalSales = totalPriceAfterDiscount + gstAmount;

                            // Update the total sales field
                            $("#total").val(totalSales.toFixed(2));
                        }

                        // Call the calculateTotalSales function whenever relevant input fields change
                        $("#sprice, #squantity, #disc, #gst").on("input", function() {
                            calculateTotalSales();
                        });
                    });
                </script>

            </form>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>