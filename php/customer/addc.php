<?php
ob_start();
include "dbcon.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
                    <h1>Add Customer</h1>
                    <nobr><i class="fas fa-handshake">&nbsp; Add New Customer</i></nobr>
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

            <form action="addc.php" method="POST">
                <label for="customer_name">Customer Name :</label> <!--<span class="red-star">*</span>--><br>
                <input type="text" placeholder="Name" name="customer_name" required><br>

                <label for="customer_contact">Customer Contact :</label><br>
                <input type="text" placeholder="Contact" name="customer_contact" maxlength="10" required><br>

                <label for="customer_address">Customer Address :</label><br>
                <input type="text" placeholder="Address" name="customer_address" value="Nallasopara" required><br>

                <label for="desc">Description (Any Additional Info) : </label><br>
                <input type="text" name="desc" placeholder="Description"> <br>

                <label for="hospital">Hospital/Clinic Name: </label> <br>
                <input type="text" name="hospital" placeholder='Hospital Name'> <br>

                <label for="dname">Doctor Name: </label> <br>
                <input type="text" name='dname' placeholder="Doctor Name"> <br>
                <hr>

                <input type="submit" name="submit" value="Add">
                <input type="reset" value="Reset">

            </form>
        </div>
    </div>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include dbcon.php here if it's not already included

    // Assuming $conn is your database connection

    $cname = filter_input(INPUT_POST, "customer_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $ccontact = filter_input(INPUT_POST, "customer_contact", FILTER_SANITIZE_NUMBER_INT);
    $caddress = filter_input(INPUT_POST, "customer_address", FILTER_SANITIZE_SPECIAL_CHARS);
    $desc = filter_input(INPUT_POST, "desc", FILTER_SANITIZE_SPECIAL_CHARS);
    $hospital = filter_input(INPUT_POST, "hospital", FILTER_SANITIZE_SPECIAL_CHARS);
    $dname = filter_input(INPUT_POST, "dname", FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $sql = "INSERT INTO cinfo(c_name, c_contact, c_address, description, hospital_name, doc_name) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sissss", $cname, $ccontact, $caddress, $desc, $hospital, $dname);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Customer Added Successfully!');</script>";
            echo "<script>window.location.href = 'managec.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to add customer!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>