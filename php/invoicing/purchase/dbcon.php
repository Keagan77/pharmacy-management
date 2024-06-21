<?php
$servername = "localhost"; // Replace 'localhost' with your MySQL server hostname if it's different
$username = "root"; // Replace 'username' with your MySQL username
$password = ""; // Replace 'password' with your MySQL password
$database = "pharmacy1"; // Replace 'database' with the name of your MySQL database

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connected successfully";
    // You can perform database operations here
}

// Close connection
//$conn->close();
