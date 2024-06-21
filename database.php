<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pharmacy1";
// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $database);
    // $conn1 = mysqli_connect($servername, $username, $password, $database);
} catch (mysqli_sql_exception $e) {
    //echo "Sorry! Connection Failed!";
}
if ($conn) {
    //echo "Connected Successfully!";
}
