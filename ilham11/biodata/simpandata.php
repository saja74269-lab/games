<?php
include "koneksi.php";

$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$hobin = $_POST['hobin'];
$telopon = $_POST['telopon'];
$kelas = $_POST['kelas'];

$sql = "INSERT INTO biodata (nama,alamat,hobin,telopon,kelas) VALUES ('$nama', '$alamat','$hobin', '$telopon','$kelas')";
if (mysqli_query($koneksi, $sql)) {
    echo "Data berhasil disimpan. <a href='lihatdata.php'>Lihat Data</a>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
}
?>

alamat
hobin
telopon
kelas
