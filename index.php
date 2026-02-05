<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Data Santri</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h2>Data Santri</h2>
<a href="tambah.php" class="btn btn-tambah">+ Tambah Data</a>

<table>
<tr>
<th>No</th>
<th>Nama</th>
<th>Kelas</th>
<th>Alamat</th>
<th>Nilai</th>
<th>Status</th>
<th>Waktu Input</th>
<th>Aksi</th>
</tr>

<?php
$no=1;
$data=mysqli_query($conn,"SELECT * FROM santri ORDER BY id DESC");

while($d=mysqli_fetch_array($data)){
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama'] ?></td>
<td><?= $d['kelas'] ?></td>
<td><?= $d['alamat'] ?></td>
<td><?= $d['nilai'] ?></td>
<td>
<?php
if($d['nilai'] >= 75){
echo "<b style='color:green'>Lulus</b>";
}else{
echo "<b style='color:red'>Tidak Lulus</b>";
}
?>
</td>
<td><?= $d['waktu_input'] ?></td>

<td>
<a href="lihat.php?id=<?= $d['id'] ?>" class="btn btn-lihat">Lihat</a>
<a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-edit">Edit</a>
<a href="hapus.php?id=<?= $d['id'] ?>" class="btn btn-hapus"
onclick="return confirm('yakin Hapus ini data?')">Hapus</a>
</td>

</tr>

<?php } ?>

</table>
</div>
</body>
</html>
