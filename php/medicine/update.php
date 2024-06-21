<?php
ob_start();
include "dbconm.php";
session_start();

$name1 = $pack1 = $batch1 = $gname1 = $quantity1 = $mrp1 = $sup1 = '';

$id1 = $_GET['updateid'];
$sql = "SELECT * FROM medinfo WHERE med_no= ?";
$result = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($result, "i", $id1);
mysqli_stmt_execute($result);
$result = mysqli_stmt_get_result($result);
$row = mysqli_fetch_assoc($result);
$name1 = $row["med_name"];
$pack1 = $row["med_pack"];
$batch1 = $row["batch_id"];
$gname1 = $row["gen_name"];
$quantity1 = $row["quantity"];
$mrp1 = $row["mrp"];
$exp1 = $row["exp_date"];
$sup1 = $row["med_sup"];
$mfg1 = $row["mfg_date"];

if (isset($_POST["submit"])) {
    $name = $_POST["med_name"];
    $pack = $_POST["packing"];
    $batch = $_POST["batch"];
    $gname = $_POST["gename"];
    $quantity = $_POST["quantity"];
    $mrp = $_POST["mrp"];
    $sup = $_POST["med_sup"];
    $exp = $_POST["exp_date"];
    $mfg = $_POST["mfg_date"];
    try {
        $sql_update = "UPDATE medinfo SET med_name = ?, med_pack = ?, batch_id = ?, mfg_date = ?, exp_date = ?, gen_name = ?, quantity = ?, mrp = ?, med_sup = ? WHERE med_no = ?";
        $result_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($result_update, "ssssssiisi", $name, $pack, $batch, $mfg, $exp, $gname, $quantity, $mrp, $sup, $id1);
        mysqli_stmt_execute($result_update);
        if ($result_update) {
            echo "<script>alert('Medicine Updated Successfully!');</script>";
            echo "<script>window.location.href = 'managem.php';</script>";
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
    <title>Update Medicine</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/medicine.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
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
                    <h1>Update Medicine</h1>
                    <nobr><i class="fa fa-shopping-bag">&nbsp; Update Existing Medicine</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/medicine/managem.php"><i class="fa fa-shopping-bag"></i>&nbsp; Manage</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>
            <form method="post" action="update.php?updateid= <?php echo $id1; ?>">
                <label for="med_name">Medicine Name:</label>
                <label for="packing" class="am-1">Packing:</label><br>

                <input type="text" name="med_name" class="am50" value="<?php echo $name1; ?>">
                <input type="text" name="packing" class="am15" size="3" value="<?php echo $pack1; ?>"><br><br>


                <label for="batch">Batch ID:</label>
                <label for="exp" class="am-2">Expiry Date</label><br>

                <input type="text" class="am50" name="batch" value="<?php echo $batch1; ?>" required>
                <input type="date" class="am15" name="exp_date" value="<?php echo $exp1; ?>" required><br><br>


                <label for="gename">Generic Name:</label>
                <label for="quantity" class="am-3">Quantity:</label>
                <label for="mrp" class="am-4">MRP:</label><br>

                <input type="text" class="am35" name="gename" value="<?php echo $gname1; ?>">
                <input type="text" class="am15" name="quantity" value=<?php echo $quantity1; ?> required>
                <input type="text" class="am15" name="mrp" value=<?php echo $mrp1; ?> required><br><br>

                <label for="mfg">Manufacturing Date</label> <br>
                <input type="date" name="mfg_date" value='<?php echo $mfg1; ?>' required> <br><br>

                <label for="med_sup">Supplier:</label><br>
                <select id="supplier" name="med_sup">
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