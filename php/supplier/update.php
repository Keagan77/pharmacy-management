<?php
ob_start();
session_start();
include "dbcon.php";

$id1 = $_GET['updateid'];
$sql = "SELECT * FROM SUPINFO WHERE sup_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id1);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$id1 = $row["sup_id"];
$name1 = $row["sup_name"];
$email1 = $row["sup_email"];
$contact1 = $row["sup_contact"];
$address1 = $row["sup_address"];

if (isset($_POST["submit"])) {
    $id = filter_input(INPUT_POST, "sup_id", FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, "supname", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "supemail", FILTER_VALIDATE_EMAIL);
    $contact = filter_input(INPUT_POST, "supcontact", FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, "supaddress", FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $sql = "UPDATE SUPINFO SET sup_id=?, sup_name=?, sup_email=?, sup_contact=?, sup_address=? WHERE sup_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issisi", $id, $name, $email, $contact, $address, $id1);
        mysqli_stmt_execute($stmt);

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Supplier Updated Successfully!');</script>";
            echo "<script>window.location.href = 'managesup.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to update supplier!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Exception Caught: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Supplier</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/supplier.css">
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
                    <h1>Update Supplier</h1>
                    <nobr><i class="fas fa-group">&nbsp; Update Existing Supplier</i></nobr>
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

            <form method="POST" action="update.php?updateid=<?php echo $id1; ?>">

                <label for="sup_id">Supplier ID</label> <br>
                <input type="text" name="sup_id" value="<?php echo $id1; ?>"><br>

                <label for="name">Supplier Name</label><br>
                <input type="text" id="name" name="supname" value="<?php echo $name1; ?>"><br>

                <label for="email">Supplier Email</label><br>
                <input type="text" id="email" name="supemail" value="<?php echo $email1; ?>"><br>

                <label for="contact">Supplier Contact</label><br>
                <input type="text" id="contact" name="supcontact" maxlength="10" value="<?php echo $contact1; ?>"><br>

                <label for="address">Supplier Address</label><br>
                <input type="text" id="address" name="supaddress" value="<?php echo $address1; ?>"><br><br>
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