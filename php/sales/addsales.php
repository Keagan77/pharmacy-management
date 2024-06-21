<?php
ob_start();
session_start();
include("dbcon.php");

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $med_name = isset($_POST['med_name']) ? $_POST['med_name'] : '';

    $sql = "SELECT batch_id, mrp, mfg_date, exp_date,quantity FROM MEDINFO WHERE med_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $med_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $batch_id = $row['batch_id'];
        $mrp = $row['mrp'];
        $quantity = $row['quantity'];
        $mfg = $row["mfg_date"];
        $exp = $row['exp_date'];
    } else {
        $batch_id = "";
        $mrp = "";
        $quantity = "";
        $mfg = "";
        $exp = "";
        $error_message = "Medicine not in stock.";
    }

    // Output JSON response
    echo json_encode(array("batch_id" => $batch_id, "mrp" => $mrp, "quantity" => $quantity, "mfg_date" => $mfg, "exp_date" => $exp, "error_message" => $error_message));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sales</title>
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
    include("../../sidenav/sidenav.html");
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Add Sale</h1>
                    <nobr><i class="fas fa-chart-bar">&nbsp; Add New Sale</i></nobr>
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

            <form action="process.php" method="post">

                <label for="invoice">Invoice Number :</label><br>
                <input type="text" name="invoice" placeholder="Invoice Number" value="<?php echo rand(500000, 3999999); ?>" disabled><br><br>

                <label for="customer">Customer Name: [If Applicable]</label> <br>
                <input type="text" name="customer" placeholder="Customer Name" list="customers"> <br><br>

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
                <input type="text" name="med_name" list="medicines" id="meds" placeholder="Select Medicine Name">
                <!-- Display available quantity next to the medicine name field -->
                <div class="sp1">
                    <span id="quantity_message" class="msg" style="color: green;"></span>
                    <!-- Display error message next to the medicine name field -->
                    <span id="error_message" class="msg" style="color: red;"><?php echo $error_message; ?></span><br>
                </div>
                <datalist id="medicines">
                    <?php
                    $sql = "SELECT med_name FROM MEDINFO";
                    $med_result = mysqli_query($conn, $sql);
                    if ($med_result && mysqli_num_rows($med_result) > 0) {
                        while ($row = mysqli_fetch_assoc($med_result)) {
                            // Output each medicine name as an option in the datalist
                            echo '<option value="' . $row['med_name'] . '">';
                        }
                    }
                    ?>
                </datalist>

                <label for="batch_id">Batch_ID :</label> <br>
                <input type="text" name="batch_id" id="batch_id" disabled><br><br>

                <label for="mrp">MRP :</label><br>
                <input type="text" name="mrp" id="mrp" placeholder="00" disabled><br><br>

                <label for="mfg">Manufacturing Date : </label> <br>
                <input type="date" name="mfg" disabled> <br><br>

                <label for="exp">Expiry Date : </label> <br>
                <input type="date" name="exp" disabled> <br><br>

                <label for="sprice">Selling Price: </label><br>
                <input type="text" name="sprice" id="sprice" placeholder="00"> <br><br>

                <label for="squantity">Sales Quantity: </label><br>
                <input type="text" name="squantity" id="squantity" placeholder="00" required> <br> <br>

                <label for="disc">Discount(%) [Min - 5%]: </label><br>
                <input type="text" name="disc" id="disc" placeholder="0%" required> <br> <br>

                <label for="disc">GST(%) [Min - 3%]: </label><br>
                <input type="text" name="gst" id="gst" placeholder="0%" required> <br> <br>

                <label for="total">Total Sales: </label> <br>
                <input type="text" name="total" id="total" placeholder="00" disabled><br><br>


                <label for="payment">Payment Method: </label><br>
                <select name="payment" required>
                    <option disabled selected>-Select Payment Method-</option>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Net Banking">Net Banking</option>
                </select><br><br>

                <label for="sdate">Sales Date: </label><br>
                <input type="date" name="sdate" required><br><br>
                <hr>

                <input type="submit" value="Add" name="submit">
                <input type="reset" value="Reset">

                <script>
                    // Function to handle AJAX request
                    function fetchMedicineDetails() {
                        var med_name = document.getElementById('meds').value;
                        $.ajax({
                            type: "POST",
                            url: "addsales.php", // Ensure correct URL
                            data: {
                                med_name: med_name
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.error_message) {
                                    alert(response.error_message);
                                    return; // Stop further execution
                                }

                                // Check if medicine is expired
                                var currentDate = new Date();
                                var expiryDate = new Date(response.exp_date);
                                if (currentDate > expiryDate) {
                                    alert("MEDICINE EXPIRED!");
                                    return; // Stop further execution
                                }

                                document.getElementById('batch_id').value = response.batch_id;
                                document.getElementById('mrp').value = response.mrp;

                                // Display available quantity message
                                if (response.quantity !== "") {
                                    document.getElementById('quantity_message').innerText = "Available Quantity: " + response.quantity;
                                } else {
                                    document.getElementById('quantity_message').innerText = "";
                                }

                                // Set manufacturing date
                                document.getElementsByName('mfg')[0].value = response.mfg_date;

                                // Set expiry date
                                document.getElementsByName('exp')[0].value = response.exp_date;
                            }
                        });
                    }

                    // Event listener for medicine name input field
                    document.getElementById('meds').addEventListener('change', fetchMedicineDetails);

                    // Function to calculate total based on required quantity, MRP, and discount
                    function calculateTotal() {
                        let squantity = parseInt(document.getElementById('squantity').value);
                        let availableQuantity = parseInt(document.getElementById('quantity_message').innerText.split(":")[1].trim());
                        let mrp = parseInt(document.getElementById('mrp').value);
                        let disc = parseFloat(document.getElementById('disc').value); // Using parseFloat for the discount percentage
                        let gst = parseFloat(document.getElementById('gst').value);
                        let sprice = parseFloat(document.getElementById('sprice').value);

                        if (isNaN(squantity) || isNaN(availableQuantity) || isNaN(mrp) || isNaN(disc) || isNaN(gst) || isNaN(sprice)) {
                            return; // Stop further execution if any input value is not a number
                        }

                        if (sprice > mrp) {
                            alert('Selling Price cannot exceed MRP');
                            document.getElementById('sprice').value = '';
                            return;
                        }

                        if (squantity > availableQuantity) {
                            alert('Quantity Limit Exceeded');
                            document.getElementById('squantity').value = '';
                            return;
                        }

                        // Calculate total cost price before discount
                        let totalCostPrice = sprice * squantity;

                        // Apply discount to the total cost price
                        let discountAmount = totalCostPrice * (disc / 100); // Convert discount to percentage

                        // Calculate total sales after discount
                        let totalSales = totalCostPrice - discountAmount;

                        // Calculate GST amount
                        let gstAmount = totalSales * (gst / 100); // Convert GST to percentage

                        // Calculate final total
                        let total = totalSales + gstAmount;

                        document.getElementById('total').value = total.toFixed(2);
                    }

                    // Event listeners for input fields
                    document.getElementById('squantity').addEventListener('input', calculateTotal);
                    document.getElementById('disc').addEventListener('input', calculateTotal);
                    document.getElementById('gst').addEventListener('input', calculateTotal);
                    document.getElementById('sprice').addEventListener('input', calculateTotal);
                </script>
            </form>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>