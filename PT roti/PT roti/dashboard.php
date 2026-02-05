<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Get summary data with error handling
$total_masuk = 0;
$total_keluar = 0;
$total_gaji = 0;
$total_pengeluaran = 0;
$count_masuk = 0;
$count_keluar = 0;

// Check if tables exist and get data
$tables = ['barang_masuk', 'barang_keluar', 'gaji', 'pengeluaran'];
foreach ($tables as $table) {
    $check_table = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($check_table) == 0) {
        // Table doesn't exist, create it
        if ($table == 'barang_masuk') {
            mysqli_query($conn, "CREATE TABLE barang_masuk (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tanggal DATE NOT NULL,
                nama_barang VARCHAR(255) NOT NULL,
                supplier VARCHAR(255) NOT NULL,
                jumlah INT NOT NULL,
                satuan VARCHAR(50) NOT NULL,
                harga_satuan DECIMAL(15,2) NOT NULL,
                total_harga DECIMAL(15,2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        } elseif ($table == 'barang_keluar') {
            mysqli_query($conn, "CREATE TABLE barang_keluar (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tanggal DATE NOT NULL,
                nama_produk VARCHAR(255) NOT NULL,
                customer VARCHAR(255) NOT NULL,
                jumlah INT NOT NULL,
                satuan VARCHAR(50) NOT NULL,
                harga_jual DECIMAL(15,2) NOT NULL,
                total_penjualan DECIMAL(15,2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        } elseif ($table == 'gaji') {
            mysqli_query($conn, "CREATE TABLE gaji (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(255) NOT NULL,
                jabatan VARCHAR(255) NOT NULL,
                gaji_pokok DECIMAL(15,2) NOT NULL,
                lembur DECIMAL(15,2) DEFAULT 0,
                potongan DECIMAL(15,2) DEFAULT 0,
                total_gaji DECIMAL(15,2) NOT NULL,
                tanggal_bayar DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        } elseif ($table == 'pengeluaran') {
            mysqli_query($conn, "CREATE TABLE pengeluaran (
                id INT AUTO_INCREMENT PRIMARY KEY,
                tanggal DATE NOT NULL,
                jenis VARCHAR(255) NOT NULL,
                biaya DECIMAL(15,2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
        }
    }
}

// Now get the data
$result = mysqli_query($conn, "SELECT SUM(total_harga) AS t FROM barang_masuk");
if ($result) $total_masuk = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT SUM(total_penjualan) AS t FROM barang_keluar");
if ($result) $total_keluar = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT SUM(total_gaji) AS t FROM gaji");
if ($result) $total_gaji = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT SUM(biaya) AS t FROM pengeluaran");
if ($result) $total_pengeluaran = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM barang_masuk");
if ($result) $count_masuk = mysqli_fetch_assoc($result)['c'] ?? 0;

$result = mysqli_query($conn, "SELECT COUNT(*) AS c FROM barang_keluar");
if ($result) $count_keluar = mysqli_fetch_assoc($result)['c'] ?? 0;

$laba_rugi = $total_keluar - ($total_masuk + $total_gaji + $total_pengeluaran);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - PT Roti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f7f7; }
    .sidebar {
      width: 220px;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      background: #343a40;
      padding-top: 20px;
    }
    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #495057;
    }
    .sidebar a.active {
      background: #007bff;
    }
    .content {
      margin-left: 220px;
      padding: 20px;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center text-white">🍞 PT Roti</h4>
    <a href="dashboard.php" class="active"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="barang_masuk.php"><i class="fas fa-box-open me-2"></i> Barang Masuk</a>
    <a href="barang_keluar.php"><i class="fas fa-dolly me-2"></i> Barang Keluar</a>
    <a href="gaji.php"><i class="fas fa-user-tie me-2"></i> Gaji Karyawan</a>
    <a href="pengeluaran.php"><i class="fas fa-money-bill-wave me-2"></i> Pengeluaran</a>
    <a href="laporan.php"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>📊 Dashboard</h2>
    <p>Selamat datang, <b><?php echo $_SESSION["username"]; ?></b>!</p>
    <!-- Summary Cards -->
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="card p-3 text-center bg-primary text-white">
          <h5><i class="fas fa-box-open me-2"></i>Barang Masuk</h5>
          <p class="fs-4 mb-1"><?= $count_masuk ?></p>
          <small>Transaksi</small>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card p-3 text-center bg-success text-white">
          <h5><i class="fas fa-dolly me-2"></i>Barang Keluar</h5>
          <p class="fs-4 mb-1"><?= $count_keluar ?></p>
          <small>Transaksi</small>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card p-3 text-center bg-warning text-white">
          <h5><i class="fas fa-user-tie me-2"></i>Total Gaji</h5>
          <p class="fs-4 mb-1">Rp <?= number_format($total_gaji) ?></p>
          <small>Bulan Ini</small>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card p-3 text-center bg-danger text-white">
          <h5><i class="fas fa-money-bill-wave me-2"></i>Pengeluaran</h5>
          <p class="fs-4 mb-1">Rp <?= number_format($total_pengeluaran) ?></p>
          <small>Operasional</small>
        </div>
      </div>
    </div>

    <!-- Financial Summary -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-chart-pie me-2"></i>Ringkasan Keuangan</h5>
          </div>
          <div class="card-body">
            <table class="table table-borderless">
              <tr>
                <td><strong>Total Pembelian Bahan Baku:</strong></td>
                <td class="text-end">Rp <?= number_format($total_masuk) ?></td>
              </tr>
              <tr>
                <td><strong>Total Penjualan:</strong></td>
                <td class="text-end text-success">Rp <?= number_format($total_keluar) ?></td>
              </tr>
              <tr>
                <td><strong>Total Gaji Karyawan:</strong></td>
                <td class="text-end text-warning">Rp <?= number_format($total_gaji) ?></td>
              </tr>
              <tr>
                <td><strong>Total Pengeluaran:</strong></td>
                <td class="text-end text-danger">Rp <?= number_format($total_pengeluaran) ?></td>
              </tr>
              <tr class="table-<?= $laba_rugi >= 0 ? 'success' : 'danger' ?>">
                <td><strong>Laba/Rugi:</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($laba_rugi) ?></strong></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-chart-bar me-2"></i>Grafik Arus Kas</h5>
          </div>
          <div class="card-body">
            <canvas id="cashFlowChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-chart-line me-2"></i>Trend Barang Masuk/Keluar</h5>
          </div>
          <div class="card-body">
            <canvas id="barangChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-chart-pie me-2"></i>Distribusi Pengeluaran</h5>
          </div>
          <div class="card-body">
            <canvas id="expenseChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    <script>
    // Cash Flow Chart
    const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(cashFlowCtx, {
        type: 'bar',
        data: {
            labels: ['Pembelian', 'Penjualan', 'Gaji', 'Pengeluaran'],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [<?= $total_masuk ?>, <?= $total_keluar ?>, <?= $total_gaji ?>, <?= $total_pengeluaran ?>],
                backgroundColor: ['#dc3545', '#28a745', '#ffc107', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Barang Chart
    const barangCtx = document.getElementById('barangChart').getContext('2d');
    new Chart(barangCtx, {
        type: 'line',
        data: {
            labels: ['Barang Masuk', 'Barang Keluar'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [<?= $count_masuk ?>, <?= $count_keluar ?>],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Expense Chart
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');
    new Chart(expenseCtx, {
        type: 'doughnut',
        data: {
            labels: ['Gaji Karyawan', 'Pengeluaran Operasional'],
            datasets: [{
                data: [<?= $total_gaji ?>, <?= $total_pengeluaran ?>],
                backgroundColor: ['#ffc107', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    </script>
  </div>
</body>
</html>
