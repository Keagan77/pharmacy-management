<?php
ob_start();
session_start();
include "dbcon.php";

$sql = "SELECT * FROM supinfo";
$result = mysqli_query($conn, $sql);

$slno = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Supplier</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/supplier.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src='sortsup.js'></script>
    <style>
        h3 {
            margin-left: 77%;
            display: inline-block;
        }

        select {
            width: 15%;
            float: right;
        }

        #nope {
            text-align: center;
        }
    </style>
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
                    <h1>Manage Supplier</h1>
                    <nobr><i class="fas fa-group">&nbsp; Manage Existing Supplier</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/supplier/addsup.php"><i class="fas fa-group"></i>&nbsp; Add New</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <h3>Sort By:</h3>
            <select id="sort-select">
                <option id='nope' value="" selected disabled>--Choose--</option>
                <option value="1">SL No (DESC)</option>
                <option value="2">Supplier Name</option>
                <option value="3">Supplier Address</option>
            </select><br><br>
            <table>
                <tbody>
                    <tr>
                        <th>Sl No</th>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Supplier Email</th>
                        <th>Supplier Contact</th>
                        <th>Supplier Address</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                    </tr>

                    <?php

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["sup_id"];
                            $name = $row["sup_name"];
                            $email = $row["sup_email"];
                            $contact = $row["sup_contact"];
                            $address = $row["sup_address"];
                            $reg_date = $row["reg_date"];
                            $updateid = $id;

                            echo "
                        <tr>
                        <td>$slno</td>
                        <td>$id</td>
                        <td>$name</td>
                        <td>$email</td>
                        <td>$contact</td>
                        <td>$address</td>
                        <td>$reg_date</td>
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
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush();
?>