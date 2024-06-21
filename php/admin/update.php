<?php
ob_start();
session_start();
include("dbcon.php");
if (isset($_GET['updateid'])) {
    $id1 = $_GET['updateid'];
    $sql = "SELECT * FROM staff WHERE ID=$id1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $fname1 = htmlspecialchars($row["FName"]);
    $sname1 = htmlspecialchars($row["SName"]);
    $email1 = htmlspecialchars($row["Email"]);
    $phone1 = htmlspecialchars($row["Phone"]);
    $gender1 = htmlspecialchars($row["gender"]);
    $dob1 = htmlspecialchars($row["DOB"]);
    $qual1 = htmlspecialchars($row["Qualification"]);
    $reg1 = htmlspecialchars($row["reg_date"]);

    if (isset($_POST["submit"])) {
        $fname = htmlspecialchars($_POST["fname"]);
        $sname = htmlspecialchars($_POST["sname"]);
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        $phone = htmlspecialchars($_POST["phone"]);
        $gender = htmlspecialchars($_POST["gender"]);
        $dob = htmlspecialchars($_POST["dob"]);
        $qual = htmlspecialchars($_POST["qualification"]);
        $reg = htmlspecialchars($_POST["reg"]);

        try {
            $sql_update = "UPDATE staff SET FName = '$fname', SName = '$sname', Email = '$email', Phone = '$phone', gender = '$gender', DOB = '$dob', Qualification = '$qual', reg_date = '$reg' WHERE ID = $id1";
            $result_update = mysqli_query($conn, $sql_update);
            if ($result_update) {
                echo "<script>alert('Staff Updated!');</script>";
                echo "<script>window.location.href = 'admindetails.php';</script>";
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "No Staff ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Details</title>
    <style>
        .content {
            margin-left: 230px;
        }
    </style>
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/admin.css">
</head>

<body>
    <?php
    include("../../sidenav/sidenav.html");
    ?>
    <div class="container-fluid">
        <div class="container">
            <form action="update.php?updateid=<?php echo $id1; ?>" method="POST">
                <h1>Update Admin Details</h1>
                <hr>

                <label for="fname">Username/First Name</label> <br>
                <input type="text" name="fname" value="<?php echo $fname1; ?>" required> <br><br>

                <label for="sname">Surname</label> <br>
                <input type="text" name="sname" value="<?php echo $sname1; ?>" required> <br><br>

                <label for="email">Email</label> <br>
                <input type="text" name="email" value="<?php echo $email1; ?>" required> <br><br>

                <label for="phone">Phone</label><br>
                <input type="text" name="phone" value="<?php echo $phone1; ?>" required> <br><br>

                <label for="dob">Date of Birth</label> <br>
                <input type="date" name="dob" value="<?php echo $dob1; ?>" required> <br><br>

                <label for="gender">Gender</label> <br>
                <select name="gender" required>
                    <option disabled>Select Gender</option>
                    <option value="male" <?php if ($gender1 == "male") echo "selected"; ?>>Male</option>
                    <option value="female" <?php if ($gender1 == "female") echo "selected"; ?>>Female</option>
                </select>
                <br><br>

                <label for="qualification">Qualification</label><br>
                <select name="qualification" required>
                    <option disabled>Select Qualification</option>
                    <option value="10p" <?php if ($qual1 == "10p") echo "selected"; ?>>10th Pass</option>
                    <option value="12p" <?php if ($qual1 == "12p") echo "selected"; ?>>12th Pass</option>
                    <option value="BSPS" <?php if ($qual1 == "BSPS") echo "selected"; ?>>Bachelor in Pharmaceutical Studies</option>
                    <option value="Phd" <?php if ($qual1 == "Phd") echo "selected"; ?>>Masters in Pharmaceutical Studies</option>
                </select>
                <br><br>

                <label for="reg">Registration Date</label><br>
                <input type="date" name="reg" value="<?php echo $reg1; ?>" required>
                <br><br>

                <input type="submit" name="submit" value="Update">
                <input type="Reset" value="Reset">
            </form>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>