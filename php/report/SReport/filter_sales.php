<?php
include("dbcon.php");

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$sql = "SELECT * FROM sales WHERE sales_date BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT ROUND(SUM(total_sales), 2) AS ts FROM sales WHERE sales_date BETWEEN '$start_date' AND '$end_date'";
$res1 = mysqli_query($conn, $sql1);

$totalAmount = 0;

if ($res1) {
    $row = mysqli_fetch_assoc($res1);
    $totalAmount = $row['ts'];
} else {
    $totalAmount = 0; // Default value if query fails
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invoice = $row["invoice_no"];
        $medname = $row["med_name"];
        $date = $row["sales_date"];
        $amount = $row["total_sales"];
        echo "
            <tr>
                <td>$invoice</td>
                <td>$medname</td>
                <td>$date</td>
                <td>$amount</td>
            </tr>
        ";
    }
} else {
    echo "<tr><td colspan='4'>No results</td></tr>";
}

echo "<script>document.getElementById('totalAmount').innerText = '$totalAmount';</script>";
