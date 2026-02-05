<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) { header("Location: login.php"); exit(); }

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $jabatan_id = $_POST['jabatan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $lembur = $_POST['lembur'];
    $potongan = $_POST['potongan'];
    $total = $gaji_pokok + $lembur - $potongan;
    $tanggal = $_POST['tanggal_bayar'];

    // Get jabatan name
    $jabatan_result = mysqli_query($conn, "SELECT nama_jabatan FROM jabatan WHERE id = '$jabatan_id'");
    $jabatan_name = mysqli_fetch_assoc($jabatan_result)['nama_jabatan'];

    $sql = "INSERT INTO gaji (nama, jabatan, gaji_pokok, lembur, potongan, total_gaji, tanggal_bayar)
            VALUES ('$nama','$jabatan_name','$gaji_pokok','$lembur','$potongan','$total','$tanggal')";
    mysqli_query($conn, $sql);
}

// Get data for dropdowns
$jabatan_list = mysqli_query($conn, "SELECT * FROM jabatan ORDER BY nama_jabatan");
$data = mysqli_query($conn, "SELECT * FROM gaji ORDER BY tanggal_bayar DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Gaji Karyawan - PT Roti</title>
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
    <a href="gaji.php" class="active"><i class="fas fa-user-tie me-2"></i> Gaji Karyawan</a>
    <a href="pengeluaran.php"><i class="fas fa-money-bill-wave me-2"></i> Pengeluaran</a>
    <a href="laporan.php"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>👨‍🍳 Gaji Karyawan</h2>
    <p class="text-muted">Manajemen data karyawan dan penggajian</p>

    <!-- Form Input -->
    <div class="card mb-4">
      <div class="card-header">
        <h5><i class="fas fa-plus-circle me-2"></i>Tambah Data Gaji Karyawan</h5>
      </div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jabatan</label>
            <select name="jabatan" class="form-control" required>
              <option value="">Pilih Jabatan</option>
              <?php 
              $jabatan_list = mysqli_query($conn, "SELECT * FROM jabatan ORDER BY nama_jabatan");
              while($jabatan = mysqli_fetch_assoc($jabatan_list)) { ?>
                <option value="<?= $jabatan['id'] ?>"><?= $jabatan['nama_jabatan'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Gaji Pokok</label>
            <input type="number" name="gaji_pokok" class="form-control" placeholder="Gaji Pokok" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Lembur</label>
            <input type="number" name="lembur" class="form-control" placeholder="Lembur" value="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Potongan</label>
            <input type="number" name="potongan" class="form-control" placeholder="Potongan" value="0">
          </div>
          <div class="col-md-3">
            <label class="form-label">Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button type="submit" name="simpan" class="btn btn-primary w-100">
              <i class="fas fa-save me-2"></i>Simpan
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Data Table -->
    <div class="card">
      <div class="card-header">
        <h5><i class="fas fa-table me-2"></i>Tabel Gaji Karyawan</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID Karyawan</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Lembur</th>
                <th>Potongan</th>
                <th>Total Gaji</th>
                <th>Tanggal Bayar</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><strong><?= $row['nama'] ?></strong></td>
                  <td><?= $row['jabatan'] ?></td>
                  <td class="text-end">Rp <?= number_format($row['gaji_pokok']) ?></td>
                  <td class="text-end">Rp <?= number_format($row['lembur']) ?></td>
                  <td class="text-end text-danger">Rp <?= number_format($row['potongan']) ?></td>
                  <td class="text-end"><strong>Rp <?= number_format($row['total_gaji']) ?></strong></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal_bayar'])) ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</body>
</html>
