<?php
include 'koneksi.php';
$id=$_GET['id'];

$data=mysqli_query($conn,"SELECT * FROM santri WHERE id='$id'");
$d=mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Data</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h2>Detail Data</h2>

<p><b>Nama :</b> <?= $d['nama'] ?></p>
<p><b>Kelas :</b> <?= $d['kelas'] ?></p>
<p><b>Alamat :</b> <?= $d['alamat'] ?></p>
<p><b>Nilai :</b> <?= $d['nilai'] ?></p>

<p><b>Status :</b>
<?php
if($d['nilai'] >= 75){
echo "<span style='color:green'><b>Lulus</b></span>";
}else{
echo "<span style='color:red'><b>Tidak Lulus</b></span>";
}
?>
</p>

<p><b>Waktu Input :</b> <?= $d['waktu_input'] ?></p>

<br>
<a href="index.php" class="btn btn-lihat">Kembali</a>

</div>
</body>
</html>
