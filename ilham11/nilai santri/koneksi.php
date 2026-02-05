<?php
$host = "localhost";
$user = "root";     // username MySQL, default: root
$pass = "";         // password MySQL, biasanya kosong di localhost
$db   = "nilai_santri";  // nama database

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>