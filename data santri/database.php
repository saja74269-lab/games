<?php
$host = "localhost";   // server database
$user = "root";        // user database (default root di XAMPP)
$pass = "";            // password database (kosong di XAMPP bawaan)
$db   = "datasantricit";    // nama database

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
