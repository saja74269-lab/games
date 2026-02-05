<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) { header("Location: login.php"); exit(); }

// Get data with error handling
$total_masuk = 0;
$total_keluar = 0;
$total_gaji = 0;
$total_pengeluaran = 0;

$result = mysqli_query($conn, "SELECT SUM(total_harga) AS t FROM barang_masuk");
if ($result) $total_masuk = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT SUM(total_penjualan) AS t FROM barang_keluar");
if ($result) $total_keluar = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT SUM(total_gaji) AS t FROM gaji");
if ($result) $total_gaji = mysqli_fetch_assoc($result)['t'] ?? 0;

$result = mysqli_query($conn, "SELECT SUM(biaya) AS t FROM pengeluaran");
if ($result) $total_pengeluaran = mysqli_fetch_assoc($result)['t'] ?? 0;

$laba_rugi = $total_keluar - ($total_masuk + $total_gaji + $total_pengeluaran);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Keuangan - PT Roti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
    <a href="dashboard.php"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="barang_masuk.php"><i class="fas fa-box-open me-2"></i> Barang Masuk</a>
    <a href="barang_keluar.php"><i class="fas fa-dolly me-2"></i> Barang Keluar</a>
    <a href="gaji.php"><i class="fas fa-user-tie me-2"></i> Gaji Karyawan</a>
    <a href="pengeluaran.php"><i class="fas fa-money-bill-wave me-2"></i> Pengeluaran</a>
    <a href="laporan.php" class="active"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>📑 Laporan Keuangan</h2>
    <p class="text-muted">Rekap otomatis dari semua transaksi</p>

    <!-- Laba Rugi Report -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-chart-line me-2"></i>Laba Rugi</h5>
          </div>
          <div class="card-body">
            <table class="table table-borderless">
              <tr>
                <td><strong>Pendapatan:</strong></td>
                <td class="text-end text-success">Rp <?= number_format($total_keluar) ?></td>
              </tr>
              <tr>
                <td><strong>Harga Pokok Penjualan:</strong></td>
                <td class="text-end text-danger">Rp <?= number_format($total_masuk) ?></td>
              </tr>
              <tr>
                <td><strong>Laba Kotor:</strong></td>
                <td class="text-end">Rp <?= number_format($total_keluar - $total_masuk) ?></td>
              </tr>
              <tr>
                <td><strong>Biaya Operasional:</strong></td>
                <td class="text-end text-danger">Rp <?= number_format($total_gaji + $total_pengeluaran) ?></td>
              </tr>
              <tr class="table-<?= $laba_rugi >= 0 ? 'success' : 'danger' ?>">
                <td><strong>Laba/Rugi Bersih:</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($laba_rugi) ?></strong></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-chart-bar me-2"></i>Cash Flow</h5>
          </div>
          <div class="card-body">
            <table class="table table-borderless">
              <tr>
                <td><strong>Arus Kas Masuk:</strong></td>
                <td class="text-end text-success">Rp <?= number_format($total_keluar) ?></td>
              </tr>
              <tr>
                <td><strong>Arus Kas Keluar:</strong></td>
                <td class="text-end text-danger">Rp <?= number_format($total_masuk + $total_gaji + $total_pengeluaran) ?></td>
              </tr>
              <tr class="table-<?= $laba_rugi >= 0 ? 'success' : 'danger' ?>">
                <td><strong>Saldo Kas:</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($laba_rugi) ?></strong></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Detailed Reports -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-user-tie me-2"></i>Laporan Gaji Karyawan</h5>
          </div>
          <div class="card-body">
            <?php
            $gaji_data = mysqli_query($conn, "SELECT nama, jabatan, total_gaji, tanggal_bayar FROM gaji ORDER BY tanggal_bayar DESC LIMIT 10");
            ?>
            <div class="table-responsive">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Total Gaji</th>
                    <th>Tanggal Bayar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($gaji_data)) { ?>
                    <tr>
                      <td><?= $row['nama'] ?></td>
                      <td><?= $row['jabatan'] ?></td>
                      <td class="text-end">Rp <?= number_format($row['total_gaji']) ?></td>
                      <td><?= date('d/m/Y', strtotime($row['tanggal_bayar'])) ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="mt-3">
              <strong>Total Gaji: Rp <?= number_format($total_gaji) ?></strong>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-money-bill-wave me-2"></i>Rincian Pengeluaran</h5>
          </div>
          <div class="card-body">
            <?php
            $pengeluaran_data = mysqli_query($conn, "SELECT jenis, SUM(biaya) as total FROM pengeluaran GROUP BY jenis ORDER BY total DESC");
            ?>
            <div class="table-responsive">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Jenis Pengeluaran</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($pengeluaran_data)) { ?>
                    <tr>
                      <td><?= $row['jenis'] ?></td>
                      <td class="text-end">Rp <?= number_format($row['total']) ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
  </table>
            </div>
            <div class="mt-3">
              <strong>Total Pengeluaran: Rp <?= number_format($total_pengeluaran) ?></strong>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
