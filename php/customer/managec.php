<?php
ob_start();
include "dbcon.php";

$sql = "SELECT * FROM cinfo";

// Execute query
$result = mysqli_query($conn, $sql);

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/medicine.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src="sortcustomer.js"></script>
    <style>
        select {
            float: right;
            width: 15%;
        }

        h3 {
            display: inline-block;
            margin-left: 77%
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
    include("../../sidenav/sidenav.html");
    ?>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Manage Customer</h1>
                    <nobr><i class="fas fa-handshake">&nbsp; Manage Existing Customer</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/customer/addc.php"><i class="fas fa-handshake"></i>&nbsp; Add New</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <h3>Sort By:</h3>
            <select id="sort-select">
                <option id='nope' value="" selected disabled>--Choose--</option>
                <option value="1">Customer Name</option>
                <option value="2">Customer Address</option>
                <option value="3">Hospital Name</option>
            </select><br><br>
            <table>
                <tbody>
                    <tr>
                        <th>Sl No</th>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>
                        <th>Customer Address</th>
                        <th>Description</th>
                        <th>Hospital/Clinic</th>
                        <th>Doctor Name</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $sl_no = 1; // Initialize Sl No variable
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $cid = $row["c_id"];
                            $cname = $row["c_name"];
                            $ccontact = $row["c_contact"];
                            $caddress = $row["c_address"];
                            $desc = $row["description"];
                            $hospital = $row["hospital_name"];
                            $dname = $row["doc_name"];

                            echo "
                            <tr>
                            <td>$sl_no</td> 
                            <td>$cid</td>
                            <td>$cname</td>
                            <td>$ccontact</td>
                            <td>$caddress</td>
                            <td>$desc</td>
                            <td>$hospital</td>
                            <td>$dname</td>
                            <td>
                            <button id='udt-btn-back'><a id='udt-btn' href='update.php?updateid=$cid;'>Update</a></button>
                            <button id='del-btn-back'><a id='del-btn' href='delete.php?deleteid=$cid;'>Delete</a></button>
                            </td>
                            </tr>
                            ";
                            $sl_no++;
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