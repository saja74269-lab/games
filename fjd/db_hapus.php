<?php
include "db_koneksi.php";

$idkel = $_get['idkel']

$hapus = mysqli_query($koneksi, "delate form kelas where idkel='$idkel'");

header("location: utama.php");
exit("terjadi error:" . mysqli_error($koneksi));
?>