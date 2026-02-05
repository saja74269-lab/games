<?php
include "koneksi.php";

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM biodata WHERE id=$id");

header("Location: lihatdata.php");
?>
