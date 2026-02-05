<?php
include "koneksi.php";

// === Log Input Data ===
$logFile = "log.txt";
$tanggal = date("Y-m-d H:i:s");
$logData = "[$tanggal] Halaman Input Data dibuka | IP: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
file_put_contents($logFile, $logData, FILE_APPEND);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Santri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-3">➕ Input Nilai Santri</h3>

    <form action="simpandata.php" method="post" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">nama guru</label>
            <input type="text" name="namaguru" class="form-control" required>

        </div>
        <div class="mb-3">
            <label class="form-label">NIK Guru</label>
            <input type="number" name="nikguru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat Guru</label>
            <input type="text" name="alamatguru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jabatan Guru</label>
            <input type="text" name="jabatanguru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">tanggallahirguru</label>
            <input type="number" name="tanggallahirguru" class="form-control" required>
        </div>
       
        </div>
        <button type="submit" class="btn btn-success" name='simpan'>Simpan Data</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>
</body>
</html>


