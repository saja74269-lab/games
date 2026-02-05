<?php
$host = "localhost";
$user = "root"; // ubah jika berbeda
$pass = "";     // ubah jika pakai password
$db   = "db_cit_santri";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
