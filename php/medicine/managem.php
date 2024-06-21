<?php
ob_start();
include "dbconm.php";
// SQL query
$sql = "SELECT * FROM medinfo";
// Execute query
$result = mysqli_query($conn, $sql);
session_start();

$slno = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medicine</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/pharmacy-management-system/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/pharmacy-management-system/css/medicine.css">
    <link rel="icon" href="/pharmacy-management-system/images/hands.png">
    <script src='sortmed.js'></script>
    <style>
        select {
            float: right;
        }

        h3 {
            display: inline-block;
            margin-left: 77%
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
                    <h1>Manage Medicine</h1>
                    <nobr><i class="fa fa-shopping-bag">&nbsp; Manage Medicine (Current Stock)</i></nobr>
                </div>
                <div class="right-dash">
                    <div class="dropdown">
                        <i class="fa fa-gear icon" onclick="toggleDropdown()" id="gear"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="/pharmacy-management-system/php/admin/admindetails.php"><i class="fas fa-user"></i>&nbsp; Admin Details</a>
                            <a href="/pharmacy-management-system/php/medicine/addm.php"><i class="fa fa-shopping-bag"></i>&nbsp; Add New</a>
                            <a href="/pharmacy-management-system/logout.php"><i class="fas fa-key"></i>&nbsp; Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <hr>

            <div>
                <h3>Sort By:</h3>
                <select id="sort-select">
                    <!--6,10 OK-->
                    <option value="" selected disabled>--Choose--</option>
                    <option value="2">Medicine Name</option>
                    <option value="5">Manufacturing Date</option>
                    <option value="6">Expiry Date</option>
                    <option value="7">Pack</option>
                    <option value="9">M.R.P</option>
                    <option value="8">Quantity</option>
                    <option value="10">Medicine Supplier</option>
                </select>
            </div><br>
            <table id="medicine-table">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Medicine No</th>
                        <th>Medicine Name</th>
                        <th>Medicine Pack</th>
                        <th>Batch ID</th>
                        <th>Manufacturing Date</th>
                        <th>Expiry Date</th>
                        <th>Generic Name</th>
                        <th>Quantity</th>
                        <th>M.R.P</th>
                        <th>Medicine Supplier</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $medno = htmlspecialchars($row["med_no"]);
                            $medname = $row["med_name"];
                            $pack = $row["med_pack"];
                            $gname = $row["gen_name"];
                            $medsup = $row["med_sup"];
                            $quanity = $row["quantity"];
                            $batch = $row["batch_id"];
                            $exp = $row["exp_date"];
                            $mrp = $row["mrp"];
                            $mfg = $row["mfg_date"];
                            //$updateid = $id;

                            echo "
                            <tr>
                            <td>$slno</td>
                            <td>$medno</td>
                            <td>$medname</td>
                            <td>$pack</td>
                            <td>$batch</td>
                            <td>$mfg</td>
                            <td>$exp</td>
                            <td>$gname</td>
                            <td>$quanity</td>
                            <td>$mrp</td>
                            <td>$medsup</td>
                            <td>
                            <button id='udt-btn-back'><a id='udt-btn' href='update.php?updateid=$medno;'>Update</a></button><br>
                            <button id='del-btn-back'><a id='del-btn' href='delete.php?deleteid=$medno;'>Delete</a></button>
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
        </div>
    </div>

</body>

</html>

<?php
ob_end_flush();
?>