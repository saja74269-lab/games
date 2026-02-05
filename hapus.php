<?php
include 'koneksi.php';
$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM santri WHERE id='$id'");
echo "<script>location='index.php'</script>";
?>
