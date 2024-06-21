<?php
ob_start();
session_start();
include "dbcon.php";

$id1 = $_GET['updateid'];
$sql = "SELECT * FROM purchase WHERE sl_no = $id1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$invoice1 = $row["invoice_no"];
$medname1 = $row["med_name"];
$pay1 = $row["pay_opt"];
$quantity1 = $row["quantity"];
$batch1 = $row["batch_id"];
$sup1 = $row["supplier"];
$mrp1 = $row["mrp"];
$disc1 = $row["discount"];
$date1 = $row["purchase_date"];
$gst1 = $row["GST"];
$pack1 = $row["med_pack"];
$exp1 = $row["exp_date"];
$mfg1 = $row["mfg_date"];

if (isset($_POST["submit"])) {
    $invoice = filter_input(INPUT_POST, "invoice", FILTER_SANITIZE_SPECIAL_CHARS);
    $medname = filter_input(INPUT_POST, "med_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $sup = filter_input(INPUT_POST, "supplier", FILTER_SANITIZE_SPECIAL_CHARS);
    $pay = filter_input(INPUT_POST, "payment", FILTER_SANITIZE_SPECIAL_CHARS);
    $quantity = filter_input(INPUT_POST, "rquantity", FILTER_VALIDATE_INT);
    $mrp = filter_input(INPUT_POST, "mrp", FILTER_VALIDATE_INT);
    $batch = filter_input(INPUT_POST, "batch_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $disc = $_POST["discount"];
    $date = $_POST["date"];
    $gst = filter_input(INPUT_POST, "gst", FILTER_SANITIZE_SPECIAL_CHARS);
    $exp = $_POST["exp"];
    $pack = filter_input(INPUT_POST, "pack", FILTER_SANITIZE_SPECIAL_CHARS);
    $mfg = $_POST["mfg"];

    // Price Calculation
    $total = $quantity * $mrp;
    $disc_rate = $total * ($disc / 100);
    $actual_rate = $total - $disc_rate;
    $tot_purchase = $actual_rate + ($actual_rate * $gst / 100);

    try {
        $sql_update = "UPDATE purchase SET invoice_no = $invoice, med_name = '$medname', med_pack = '$pack',supplier = '$sup', pay_opt = '$pay', mfg_date = '$mfg',exp_date = '$exp',quantity = $quantity, batch_id = '$batch',mrp = $mrp, discount = $disc, GST = $gst, net_purchase = $tot_purchase, purchase_date = '$date' WHERE sl_no = $id1";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo "<script>alert('Purchase Updated!');</script>";
            echo "<script>window.location.href = 'managep.php';</script>";
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Purchase | Maharashtra Medical</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/purchase.css">
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
                    <h1>Update Purchase</h1>
                    <nobr><i class="fas fa-chart-bar">&nbsp; Update Existing Purchase</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/purchase/managep.php"><i class="fas fa-chart-bar"></i>&nbsp; Manage</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <form method="POST" action="update.php?updateid=<?php echo $id1; ?>">

                <label for="invoice">Invoice No</label><br>
                <input type="text" name="invoice" value="<?php echo $invoice1; ?>"><br><br>

                <label for="med_name">Medicine Name</label><br>
                <input type="text" name="med_name" value="<?php echo $medname1; ?>"><br><br>

                <label for="med_sup">Supplier:</label><br>
                <select id="supplier" name="supplier"> <!-- Updated the name attribute to "supplier" -->
                    <option value="" disabled>-Select Supplier-</option>
                    <?php
                    $sql_supplier = "SELECT sup_name FROM supinfo";
                    $result_supplier = mysqli_query($conn, $sql_supplier);
                    $current_supplier = $sup1;

                    if ($result_supplier->num_rows > 0) {
                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                            $selected_supplier = ($row_supplier['sup_name'] == $current_supplier) ? "selected" : ""; // Check if the option should be selected
                            echo "<option value='" . $row_supplier['sup_name'] . "' $selected_supplier>" . $row_supplier['sup_name'] . "</option>";
                        }
                    }
                    ?>
                </select><br><br>

                <label for="payment">Payment Option:</label><br>
                <select name="payment" required>
                    <option value="Cash" <?php if ($pay1 == "Cash") echo "selected"; ?>>Cash</option>
                    <option value="Net Banking" <?php if ($pay1 == "Net Banking") echo "selected"; ?>>Net Banking</option>
                    <option value="UPI" <?php if ($pay1 == "UPI") echo "selected"; ?>>UPI</option>
                </select><br><br>

                <label for="batch_id">Batch ID</label><br>
                <input type="text" name="batch_id" value="<?php echo $batch1; ?>" required> <br><br>

                <label for="pack">Medicine Pack</label> <br>
                <input type="text" name="pack" value="<?php echo $pack1; ?>"><br><br>

                <label for="mfg">Manufacturing Date</label><br>
                <input type="date" name='mfg' value='<?php echo $mfg1; ?>' required> <br><br>

                <label for="exp">Expiry Date</label><br>
                <input type="date" name="exp" value="<?php echo $exp1; ?>"><br><br>

                <label for="rquantity">Purchase/Required Quantity</label><br>
                <input type="text" name="rquantity" value="<?php echo $quantity1; ?>"><br><br>

                <label for="mrp">MRP</label><br>
                <input type="text" name="mrp" value="<?php echo $mrp1; ?>"><br><br>

                <label for="discount">Discount</label><br>
                <input type="text" name="discount" value="<?php echo $disc1; ?>"><br><br>

                <label for="gst">GST</label><br>
                <input type="text" name="gst" value="<?php echo $gst1; ?>"><br><br>

                <label for="">Total Purchase</label> <br>
                <input type="text" name="totpurchase" disabled> <br><br>

                <script>
                    $(document).ready(function() {
                        // Function to calculate total purchase
                        function calculateTotalPurchase() {
                            var quantity = parseFloat($("input[name='rquantity']").val());
                            var mrp = parseFloat($("input[name='mrp']").val());
                            var discount = parseFloat($("input[name='discount']").val());
                            var gst = parseFloat($("input[name='gst']").val());

                            // Perform calculation
                            var total = quantity * mrp;
                            var discAmount = total * (discount / 100);
                            var actualAmount = total - discAmount;
                            var totPurchase = actualAmount + (actualAmount * gst / 100);

                            // Update the "Total Purchase" input field
                            $("input[name='totpurchase']").val(totPurchase.toFixed(2));
                        }

                        // Call the function initially to set the initial value
                        calculateTotalPurchase();

                        // Bind the calculateTotalPurchase function to the input fields' input event
                        $("input[name='rquantity'], input[name='mrp'], input[name='discount'], input[name='gst']").on('input', function() {
                            calculateTotalPurchase();
                        });
                    });
                </script>

                <label for="date">Date of Purchase</label><br>
                <input type="date" name="date" value="<?php echo $date1; ?>"><br><br>
                <hr>

                <input type="submit" name="submit" value="Update">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>