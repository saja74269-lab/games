<?php
include "koneksi.php";

// Ambil semua data
$result = mysqli_query($koneksi, "SELECT * FROM biodata");

// Hitung jumlah santri
$jumlah_santri = mysqli_num_rows($result);

// Reset pointer untuk fetch ulang
mysqli_data_seek($result, 0);

$total_semua = 0;
$rata2_semua = 0;
$nilai_tertinggi = 0;

while($row = mysqli_fetch_assoc($result)){
    // Hitung total & rata-rata per santri
    $total = $row['nilai_it'] + $row['nilai_inggris'] + $row['nilai_diniyah'];
    $rata2 = $total / 3;

    // Akumulasi untuk semua santri
    $total_semua += $total;
    $rata2_semua += $rata2;

    // Cari nilai tertinggi
    if($total > $nilai_tertinggi){
        $nilai_tertinggi = $total;
    }
}

// Hitung rata-rata umum
if ($jumlah_santri > 0) {
    $rata2_umum = $rata2_semua / $jumlah_santri;
} else {
    $rata2_umum = 0;
}

// === Log Dashboard ===
$logFile = "log.txt";
$tanggal = date("Y-m-d H:i:s");
$logData = "[$tanggal] Dashboard diakses | Jumlah Santri: $jumlah_santri | Nilai Tertinggi: $nilai_tertinggi | Rata-rata Umum: " . number_format($rata2_umum,2) . PHP_EOL;
file_put_contents($logFile, $logData, FILE_APPEND);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Nilai Santri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; }
        .card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .dashboard-header {
            color: white; 
            padding: 15px; 
            border-radius: 10px; 
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="dashboard-header d-flex align-items-center justify-content-center" style="background:#28a745;">
    <img src="images/cit_aj-removebg-preview.png" alt="Cit AJ" style="width:200px; height:auto;">
    <h3 class="m-0">📊 Dashboard Nilai Santri</h3>
</div>

<div class="container">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h5>👨🎓 Jumlah Santri</h5>
                <h3><?php echo $jumlah_santri; ?></h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h5>🏆 Nilai Tertinggi (Total)</h5>
                <h3><?php echo $nilai_tertinggi; ?></h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h5>📈 Rata-rata Umum</h5>
                <h3><?php echo number_format($rata2_umum,2); ?></h3>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="text-center mt-4">
        <a href="inputdata.php" class="btn btn-success me-2">➕ Input Nilai</a>
        <a href="lihatdata.php" class="btn btn-primary me-2">📄 Lihat Data</a>
        <a href="lihatlog.php" class="btn btn-warning me-2">📜 Lihat Log</a>
        <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
    

    </div>

    <footer class="text-center mt-4 text-muted">
        &copy; <?php echo date("Y"); ?> CIT Boarding School - Sistem Nilai Santri
    </footer>
</div>
</body>
</html>


