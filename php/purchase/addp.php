<?php
ob_start();
include("dbcon.php");
session_start();

// Function to generate a random invoice number
function generateInvoiceNumber()
{
    return rand(4000000, 8000000);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $medname = filter_input(INPUT_POST, "med_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $payment = $_POST["payment"];
    $quantity = filter_input(INPUT_POST, "rquantity", FILTER_VALIDATE_INT);
    $mrp = filter_input(INPUT_POST, "mrp", FILTER_VALIDATE_INT);
    $disc = filter_input(INPUT_POST, "discount", FILTER_VALIDATE_INT);
    $batch = filter_input(INPUT_POST, "batch_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $gst = filter_input(INPUT_POST, "gst", FILTER_SANITIZE_SPECIAL_CHARS);
    $date = $_POST["date"];
    $supplier = $_POST["supplier"];
    $pack = filter_input(INPUT_POST, "pack", FILTER_SANITIZE_SPECIAL_CHARS);
    $exp = $_POST["exp"];
    $mfg = $_POST["mfg"];

    // Generate invoice number
    $invoice = generateInvoiceNumber();

    // Check if all required fields are filled
    if ($medname && $payment && $quantity && $mrp && $disc && $batch && $date && $supplier && $pack) {
        // Price Calculation
        $total = $quantity * $mrp;
        $disc_rate = $total * ($disc / 100);
        $actual_rate = $total - $disc_rate;
        $tot_purchase = $actual_rate + ($actual_rate * $gst / 100); // Including GST

        // Prepare and execute SQL query to check if medicine exists
        $checkQuery = "SELECT COUNT(*) as count FROM MEDINFO WHERE med_name = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $medname);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $row = $checkResult->fetch_assoc();
        $medicine_exists = $row['count'];

        if ($medicine_exists) {
            // If medicine exists, update its quantity
            $sql_update = "UPDATE MEDINFO SET quantity = quantity + $quantity WHERE med_name = '$medname'";
            if ($conn->query($sql_update) === TRUE) {
                echo "<script>alert('Medicine Quantity Updated Successfully!');</script>";
                echo "<script>window.location.href = '/pharmacy-management-system/php/medicine/managem.php';</script>";
            } else {
                echo "Error updating medicine quantity: " . $conn->error;
            }
        } else {
            // If medicine does not exist, insert into both PURCHASE and MEDINFO tables
            $insertPurchaseQuery = "INSERT INTO PURCHASE(invoice_no,med_name,med_pack,supplier,pay_opt,batch_id,mfg_date,exp_date,quantity,mrp,discount,GST,net_purchase,purchase_date)
                        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $insertStmt = $conn->prepare($insertPurchaseQuery);
            $insertStmt->bind_param("isssssssiiddds", $invoice, $medname, $pack, $supplier, $payment, $batch, $mfg, $exp, $quantity, $mrp, $disc, $gst, $tot_purchase, $date);


            $insertPurchaseResult = $insertStmt->execute();

            $insertMedinfoQuery = "INSERT INTO MEDINFO(med_name,med_pack,batch_id,mfg_date,exp_date,quantity,mrp,med_sup)
                                   VALUES(?,?,?,?,?,?,?,?)";
            $insertMedinfoStmt = $conn->prepare($insertMedinfoQuery);
            $insertMedinfoStmt->bind_param("sssssids", $medname, $pack, $batch, $mfg, $exp, $quantity, $mrp, $supplier);
            $insertMedinfoResult = $insertMedinfoStmt->execute();

            if ($insertPurchaseResult && $insertMedinfoResult) {
                echo "<script>alert('Purchase Added Successfully!');</script>";
                echo "<script>window.location.href = 'managep.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error adding purchase or medicine info: " . $conn->error . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Please fill in all required fields');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Purchase | Maharashtra Medical</title>
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
                    <h1>Add Purchase</h1>
                    <nobr><i class="fas fa-chart-bar">&nbsp; Add New Purchase</i></nobr>
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

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="invoice">Invoice Number :</label><br>
                <input type="text" name="invoice" placeholder="Invoice Number" value="<?php echo generateInvoiceNumber(); ?>" disabled><br><br>

                <label for="med_name">Medicine Name :</label><br>
                <input type="text" placeholder="Medicine Name" name="med_name" required><br><br>

                <label for="supplier">Supplier :</label><br>
                <select class="input-20" name="supplier" required>
                    <option disabled selected>-Select Supplier-</option>
                    <?php
                    // Fetch suppliers from database and populate dropdown
                    $sql = "SELECT sup_name FROM supinfo";
                    $result = mysqli_query($conn, $sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['sup_name'] . "'>" . $row['sup_name'] . "</option>";
                        }
                    }
                    ?>
                </select><br><br>

                <label class="name-20" for="payment">Payment Option :</label><br>
                <select class="input-20" name="payment" required>
                    <option disabled selected>Select Payment Method</option>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Net Banking">Net Banking</option>
                </select><br><br>

                <label for="pack">Medicine Pack</label> <br>
                <input type="text" placeholder="Pack" name="pack" required> <br><br>

                <label for="mfg">Manufacturing Date</label> <br>
                <input type="date" name="mfg" required> <br><br>

                <label for="exp">Expiry Date</label> <br>
                <input type="date" name="exp" required> <br><br>

                <label for="batch_id">Batch ID:</label><br>
                <input type="text" placeholder="Batch ID" name="batch_id" required><br><br>

                <label for="quantity">Purchase Quantity :</label><br>
                <input type="text" placeholder="00" name="rquantity" required><br><br>

                <label for="mrp">MRP :</label><br>
                <input type="text" placeholder="00" name="mrp" required><br><br>

                <label for="discount">Discount(%) [Max - 15%] :</label><br>
                <input type="text" placeholder="0%" name="discount" required><br><br>

                <label for="gst">GST(%) [Max - 18%] :</label><br>
                <input type="text" placeholder="0%" name="gst"><br><br>

                <label for="totpurchase">Total Purchase :</label> <br>
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

                <label>Date of Purchase :</label><br>
                <input type="date" name="date"><br><br>
                <hr>

                <input type="submit" name="submit" value="Add">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>