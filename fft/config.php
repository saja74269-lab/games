<?php
$host = "localhost";
$user = "root"; // sesuaikan username MySQL
$pass = "";     // sesuaikan password MySQL
$db   = "ilham_data";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
?>
