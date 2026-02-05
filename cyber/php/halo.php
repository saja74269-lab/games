<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo "<a href='belajar.html'><button> halo di sini </button></a>"
    ?>

    <?php
    echo "<a href='index.php'><button>halo</button></a>"
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


</from>
</body>
</html>