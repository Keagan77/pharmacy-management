<?php
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "pharmacy1"; // Change this to the name of your MySQL database

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";

// Close connection
//$conn->close();
