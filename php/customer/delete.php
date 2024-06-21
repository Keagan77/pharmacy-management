<?php
include "dbcon.php";

if (isset($_GET["deleteid"])) {
    $id = $_GET["deleteid"];

    // Display confirmation dialog before deleting
    echo "<script>
            let confirmDelete = confirm('Are you sure you want to delete this Customer Record?');
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
        $stmt = $conn->prepare("DELETE FROM cinfo WHERE c_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Customer Record Deleted Successfully!');</script>";
            echo "<script>window.location.href = 'managec.php';</script>";
            exit();
        } else {
            echo "<script>alert('Record Not Found!');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: {$e->getMessage()}');</script>";
    }
}
