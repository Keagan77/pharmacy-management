<?php
include "dbcon.php";

if (isset($_GET["deleteid"])) {
    $id = $_GET["deleteid"];

    // Display confirmation dialog before deleting
    echo "<script>
            let confirmDelete = confirm('Are you sure you want to delete this Purchase Record?');
            if (confirmDelete) {
                window.location.href = 'delete.php?confirmed={$id}';
            } else {
                window.history.back();
            }
          </script>";
}

if (isset($_GET["confirmed"])) {
    $id = $_GET["confirmed"];

    try {
        // Fetch the quantity and med_name from the purchase table for the deleted record
        $fetch_query = "SELECT quantity, med_name FROM purchase WHERE sl_no = $id";
        $fetch_result = mysqli_query($conn, $fetch_query);

        if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
            $row = mysqli_fetch_assoc($fetch_result);
            $quantity = $row['quantity'];
            $med_name = $row['med_name'];

            // Subtract the quantity from the medinfo table
            $update_query = "UPDATE medinfo SET quantity = quantity - $quantity WHERE med_name = '$med_name'";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                // If the update is successful, proceed with deleting the purchase record
                $delete_query = "DELETE FROM purchase WHERE sl_no = $id";
                $delete_result = mysqli_query($conn, $delete_query);

                if ($delete_result) {
                    // If the delete is successful, redirect to managep.php
                    echo "<script>alert('Purchase Record Deleted Successfully!');</script>";
                    echo "<script>window.location.href = 'managep.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Failed to delete purchase record');</script>";
                }
            } else {
                echo "<script>alert('Failed to update medinfo table');</script>";
            }
        } else {
            echo "<script>alert('Record Not Found!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: {$e->getMessage()}');</script>";
    }
}
