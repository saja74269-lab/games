<?php
$host = "localhost";
$user = "root";       // default XAMPP
$pass = "";           // default XAMPP
$db   = "pt_roti1";    // pastikan nama database sesuai

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
