<?php
$koneksi = mysqli_connect("localhost", "root", "", "smp_mi");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
