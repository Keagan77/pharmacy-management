<?php
ob_start();
session_start();
include "dbcon.php";
function generateRandomSupId()
{
    return mt_rand(10000, 30000);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/supplier.css">
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
                    <h1>Add Supplier</h1>
                    <nobr><i class="fas fa-group">&nbsp; Add New Supplier</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/supplier/managesup.php"><i class="fas fa-group"></i>&nbsp; Manage</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <form method="POST" action="addsup.php">
                <label for="sup_id">Supplier ID</label> <br>
                <input type="text" name="sup_id" value="<?php echo generateRandomSupId(); ?>" disabled><br>

                <label for="name">Supplier Name :</label><br>
                <input type="text" placeholder="Name" id="name" name="supname"><br>

                <label for="email">Supplier Email :</label><br>
                <input type="text" placeholder="example@domain.com" id="email" name="supemail"><br>

                <label for="contact">Supplier Contact :</label><br>
                <input type="text" placeholder="Contact" id="contact" name="supcontact"><br>

                <label for="address">Supplier Address :</label><br>
                <input type="text" placeholder="Address" id="address" name="supaddress"><br><br>
                <hr>

                <input type="submit" value="Add">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "supname", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'supemail', FILTER_VALIDATE_EMAIL);
    $contact = filter_input(INPUT_POST, "supcontact", FILTER_VALIDATE_INT);
    $address = $_POST["supaddress"];
    $sup_id = generateRandomSupId();

    try {
        $sql = "INSERT INTO SUPINFO(sup_id, sup_name, sup_email, sup_contact, sup_address) VALUES(?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "issis", $sup_id, $name, $email, $contact, $address);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Supplier Added Successfully!');</script>";
            echo "<script>window.location.href = 'managesup.php';</script>";
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Exception Caught: " . $e->getMessage() . "');</script>";
    }
}
ob_end_flush();
?>