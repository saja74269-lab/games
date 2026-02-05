<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nilai_it = $_POST['nilai_it'];
    $nilai_inggris = $_POST['nilai_inggris'];
    $nilai_diniyah = $_POST['nilai_diniyah'];

    // Simpan ke database
    $sql = "INSERT INTO biodata (nama, nilai_it, nilai_inggris, nilai_diniyah) 
            VALUES ('$nama','$nilai_it','$nilai_inggris','$nilai_diniyah')";
    if (mysqli_query($koneksi, $sql)) {
        // === Log Data Baru ===
        $logFile = "log.txt";
        $tanggal = date("Y-m-d H:i:s");
        $logData = "[$tanggal] Data baru ditambahkan | Nama: $nama | IT: $nilai_it | Inggris: $nilai_inggris | Diniyah: $nilai_diniyah" . PHP_EOL;
        file_put_contents($logFile, $logData, FILE_APPEND);

        // kembali ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
