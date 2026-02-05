<?php
include 'koneksi.php';
$id=$_GET['id'];

$data=mysqli_query($conn,"SELECT * FROM santri WHERE id='$id'");
$d=mysqli_fetch_array($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h2>Edit Data</h2>

<form method="post">

Nama
<input type="text" name="nama" value="<?= $d['nama'] ?>">

Kelas
<input type="text" name="kelas" value="<?= $d['kelas'] ?>">

Alamat
<textarea name="alamat"><?= $d['alamat'] ?></textarea>

Nilai
<input type="number" name="nilai" value="<?= $d['nilai'] ?>">

<button name="update">Update</button>

</form>

<?php
if(isset($_POST['update'])){
mysqli_query($conn,"UPDATE santri SET
nama='$_POST[nama]',
kelas='$_POST[kelas]',
alamat='$_POST[alamat]',
nilai='$_POST[nilai]'
WHERE id='$id'
");

echo "<script>location='index.php'</script>";
}
?>

</div>
</body>
</html>
