<!DOCTYPE html>
<html>
<head>
    <title>Input & Output PHP</title>
</head>
<body>

<h2>Form Input Sederhana</h2>

<?php
echo "<a href='belajar.html'><button>Kembali</button></a>"
?>

<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Umur:</label><br>
    <input type="number" name="umur" required><br><br>

    <button type="submit">Kirim</button>
</form>

<hr>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];

    echo "<h2>Hasil Output:</h2>";
    echo "Nama kamu: <b>$nama</b><br>";
    echo "Umur kamu: <b>$umur tahun</b>";
}
?>

</body>
</html>
