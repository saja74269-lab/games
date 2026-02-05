<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaguru = $_POST['namaguru'];
    $nikguru = $_POST['nikguru'];
    $alamatguru = $_POST['alamatguru'];
    $jabatanguru = $_POST['jabatanguru'];
    $tanggallahirguru = $_POST['tanggallahirguru'];
    $tanggalinputguru = $_POST['tanggalinputguru'];
    // Simpan ke database
    $sql = "INSERT INTO biodata (namaguru, nikguru, alamatguru, jabatanguru,tanggallahirguru,tanggalinputguru) 
            VALUES ('$namaguru','$nikguru','$alamatguru','$jabatanguru','$tanggallahirguru','$tanggalinputguru)";
    if (mysqli_query($koneksi, $sql)) {
        // === Log Data Baru ===
        $logFile = "log.txt";
        $tanggal = date("Y-m-d H:i:s");
        $logData = "[$tanggal] Data baru ditambahkan | Nama: $namaguru | nik: $nikguru | alamts: $alamatguru | jabatan: $jabatanguru | tanggal lahir: $tanggallahirguru | tanggal input: $tanggalinputguru " . PHP_EOL;
        file_put_contents($logFile, $logData, FILE_APPEND);

        // kembali ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
