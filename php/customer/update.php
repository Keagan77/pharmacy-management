<?php
ob_start();
include "dbcon.php";
session_start();

if (isset($_GET['updateid'])) {
    $id1 = $_GET['updateid'];
    $sql = "SELECT * FROM cinfo WHERE c_id=?";

    try {
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $id1);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the row
        $row = mysqli_fetch_assoc($result);

        $name1 = $row["c_name"];
        $contact1 = $row["c_contact"];
        $address1 = $row["c_address"];
        $desc1 = $row["description"];
        $hosp1 = $row["hospital_name"];
        $dname1 = $row["doc_name"];

        if (isset($_POST["submit"])) {
            $name = filter_input(INPUT_POST, "customer_name", FILTER_SANITIZE_SPECIAL_CHARS);
            $contact = filter_input(INPUT_POST, "customer_contact", FILTER_SANITIZE_SPECIAL_CHARS);
            $address = filter_input(INPUT_POST, "customer_address", FILTER_SANITIZE_SPECIAL_CHARS);
            $desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_SPECIAL_CHARS);
            $hosp = filter_input(INPUT_POST, "hospital", FILTER_SANITIZE_SPECIAL_CHARS);
            $dname = filter_input(INPUT_POST, "dname", FILTER_SANITIZE_SPECIAL_CHARS);

            $sql_update = "UPDATE cinfo SET c_name=?, c_contact=?, c_address=?, description=?, hospital_name=?, doc_name=? WHERE c_id=?";

            // Prepare the statement
            $stmt_update = mysqli_prepare($conn, $sql_update);

            // Bind parameters
            mysqli_stmt_bind_param($stmt_update, "sissssi", $name, $contact, $address, $desc, $hosp, $dname, $id1);

            // Execute the statement
            $result_update = mysqli_stmt_execute($stmt_update);

            if ($result_update) {
                echo "<script>alert('Customer Updated!');</script>";
                echo "<script>window.location.href = 'managec.php';</script>";
                exit();
            } else {
                echo "<script>alert('Failed to update customer!');</script>";
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No customer ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/customer.css">
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
    include("../../sidenav/sidenav.html");
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Update Customer</h1>
                    <nobr><i class="fas fa-handshake">&nbsp; Update Existing Customer</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/customer/managec.php"><i class="fas fa-handshake"></i>&nbsp; Manage</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>
            <form action="update.php?updateid=<?php echo $id1; ?>" method="POST">
                <label for="customer_name">Customer Name</label><br>
                <input type="text" name="customer_name" value="<?php echo $name1; ?>" required><br>

                <label for="customer_contact">Customer Contact</label><br>
                <input type="text" name="customer_contact" value=<?php echo $contact1; ?> maxlength="10" required><br>

                <label for="customer_address">Customer Address</label><br>
                <input type="text" name="customer_address" value="<?php echo $address1; ?>" required><br>

                <label for="desc">Description</label><br>
                <input type="text" name="desc" value="<?php echo $desc1; ?>"><br>

                <label for="hospital">Hospital Name: </label> <br>
                <input type="text" name="hospital" placeholder='Hospital Name' value='<?php echo $hosp1; ?>'> <br>

                <label for="dname">Doctor Name: </label> <br>
                <input type="text" name='dname' placeholder="Doctor Name" value='<?php echo $dname1; ?>'> <br>
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