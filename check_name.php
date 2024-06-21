<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = filter_input(INPUT_POST, "firname", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($fname)) {
        echo "empty";
        exit();
    }

    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM STAFF WHERE FName = ?");
    mysqli_stmt_bind_param($stmt, "s", $fname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);

    if ($count > 0) {
        echo "taken";
    } else {
        echo "available";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
