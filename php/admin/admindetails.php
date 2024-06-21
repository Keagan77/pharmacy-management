<?php
ob_start();
include("dbcon.php");
session_start();

$sql = "SELECT * FROM STAFF;";
$result = mysqli_query($conn, $sql);

$slno = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
    <style>
        .content {
            margin-left: 250px;
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/admin.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <style>
        /* */
    </style>
</head>

<body>
    <?php
    include("../../sidenav/sidenav.html");
    ?>
    <div class="container-fluid">
        <div class="container">
            <h1>Admin Details</h1>
            <h2 id="h2-cau">Current Active User: <span style="color: green"><?php echo $_SESSION['username']; ?></span></h2> <!-- Display current user here -->
            <hr>
            <table>
                <tbody>
                    <tr>
                        <th>Sl No</th>
                        <th>Admin ID</th>
                        <th>Username</th>
                        <th>Surname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Qualification</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                    </tr>

                    <?php

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["ID"];
                            $name = $row["FName"];
                            $sname = $row["SName"];
                            $email = $row["Email"];
                            $phone = $row["Phone"];
                            $gender = $row["gender"];
                            $dob = $row["DOB"];
                            $qual = $row["Qualification"];
                            $reg = $row["reg_date"];
                            $id = $row["ID"];

                            $updateid = $id;
                            $deleteid = $id;

                            echo "
                        <tr>
                        <td>$slno</td>
                        <td>$id</td>
                        <td>$name</td>
                        <td>$sname</td>
                        <td>$gender</td>
                        <td>$email</td>
                        <td>$phone</td>
                        <td>$dob</td>
                        <td>$qual</td>
                        <td>$reg</td>
                        <td>
                        <button id='udt-btn-back'><a id='udt-btn' href='update.php?updateid= $id;'>Update</a></button>
                        <button id='del-btn-back'><a id='del-btn' href='delete.php?deleteid= $id;'>Delete</a></button>
                        </td>
                        </tr>
                        ";
                            $slno++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <hr>

            <p>Note: The current logged in user must not delete his record.</p>

        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>