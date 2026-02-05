<?php
// Database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$database = "your_database_name"; // Replace with your actual database name

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
