<?php
include "koneksi.php";

// ambil data lama
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM biodata WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nilai_it = $_POST['nilai_it'];
    $nilai_inggris = $_POST['nilai_inggris'];
    $nilai_diniyah = $_POST['nilai_diniyah'];

    mysqli_query($koneksi, "UPDATE biodata SET 
        nama='$nama', 
        nilai_it='$nilai_it', 
        nilai_inggris='$nilai_inggris', 
        nilai_diniyah='$nilai_diniyah' 
        WHERE id=$id");

    header("Location: lihatdata.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <h2>Edit Data</h2>
    <form method="POST">
        Nama: <input type="text" name="nama" value="<?php echo $data['nama']; ?>"><br>
        Nilai IT: <input type="number" name="nilai_it" value="<?php echo $data['nilai_it']; ?>"><br>
        Nilai Inggris: <input type="number" name="nilai_inggris" value="<?php echo $data['nilai_inggris']; ?>"><br>
        Nilai Diniyah: <input type="number" name="nilai_diniyah" value="<?php echo $data['nilai_diniyah']; ?>"><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
