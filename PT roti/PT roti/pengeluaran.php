<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) { header("Location: login.php"); exit(); }

if (isset($_POST['simpan'])) {
    $jenis = $_POST['jenis'];
    $biaya = $_POST['biaya'];
    $tgl = $_POST['tanggal'];

    $sql = "INSERT INTO pengeluaran (jenis, biaya, tanggal) VALUES ('$jenis','$biaya','$tgl')";
    mysqli_query($conn, $sql);
}
$data = mysqli_query($conn, "SELECT * FROM pengeluaran");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengeluaran Perusahaan - PT Roti</title>
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
    <a href="pengeluaran.php" class="active"><i class="fas fa-money-bill-wave me-2"></i> Pengeluaran</a>
    <a href="laporan.php"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>💸 Pengeluaran Perusahaan</h2>
    <p class="text-muted">Biaya operasional selain gaji (listrik, air, perawatan mesin, transportasi, dll)</p>

    <!-- Form Input -->
    <div class="card mb-4">
      <div class="card-header">
        <h5><i class="fas fa-plus-circle me-2"></i>Tambah Pengeluaran Perusahaan</h5>
      </div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Jenis Pengeluaran</label>
            <select name="jenis" class="form-control" required>
              <option value="">Pilih Jenis Pengeluaran</option>
              <option value="Listrik">Listrik</option>
              <option value="Air">Air</option>
              <option value="Perawatan Mesin">Perawatan Mesin</option>
              <option value="Transportasi">Transportasi</option>
              <option value="Internet">Internet</option>
              <option value="Telepon">Telepon</option>
              <option value="Sewa Tempat">Sewa Tempat</option>
              <option value="Pajak">Pajak</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Jumlah Biaya</label>
            <input type="number" name="biaya" class="form-control" placeholder="Jumlah Biaya" required>
          </div>
          <div class="col-md-12">
            <button type="submit" name="simpan" class="btn btn-primary">
              <i class="fas fa-save me-2"></i>Simpan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Data Table -->
    <div class="card">
      <div class="card-header">
        <h5><i class="fas fa-table me-2"></i>Tabel Pengeluaran</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jenis Pengeluaran</th>
                <th>Jumlah Biaya</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                  <td><?= $row['jenis'] ?></td>
                  <td><span class="badge bg-secondary"><?= $row['jenis'] ?></span></td>
                  <td class="text-end"><strong>Rp <?= number_format($row['biaya']) ?></strong></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</body>
</html>
