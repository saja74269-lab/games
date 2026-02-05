<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah Data</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h2>Tambah Data Santri</h2>

<form method="post">

Nama
<input type="text" name="nama" required>

Kelas
<input type="text" name="kelas" required>

Alamat
<textarea name="alamat" required></textarea>

Nilai
<input type="number" name="nilai" required>

<button name="simpan">Simpan</button>

</form>

<?php
if(isset($_POST['simpan'])){

$waktu = date("Y-m-d H:i:s");

mysqli_query($conn,"INSERT INTO santri(nama,kelas,alamat,nilai,waktu_input) VALUES(
'$_POST[nama]',
'$_POST[kelas]',
'$_POST[alamat]',
'$_POST[nilai]',
'$waktu'
)");

echo "<script>location='index.php'</script>";
}
?>

</div>
</body>
</html>
