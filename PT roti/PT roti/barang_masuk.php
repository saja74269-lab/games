<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Simpan data
if (isset($_POST['simpan'])) {
    $tgl = $_POST['tanggal'];
    $nama = $_POST['nama_barang'];
    $supplier_id = $_POST['supplier'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga_satuan'];
    $total = $jumlah * $harga;

    // Get supplier name
    $supplier_result = mysqli_query($conn, "SELECT nama_supplier FROM suppliers WHERE id = '$supplier_id'");
    $supplier_name = mysqli_fetch_assoc($supplier_result)['nama_supplier'];

    $sql = "INSERT INTO barang_masuk (tanggal, nama_barang, supplier, jumlah, satuan, harga_satuan, total_harga)
            VALUES ('$tgl','$nama','$supplier_name','$jumlah','$satuan','$harga','$total')";
    mysqli_query($conn, $sql);
}

// Get data for dropdowns
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY nama_supplier");
$data = mysqli_query($conn, "SELECT * FROM barang_masuk ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Barang Masuk - PT Roti</title>
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
    <a href="barang_masuk.php" class="active"><i class="fas fa-box-open me-2"></i> Barang Masuk</a>
    <a href="barang_keluar.php"><i class="fas fa-dolly me-2"></i> Barang Keluar</a>
    <a href="gaji.php"><i class="fas fa-user-tie me-2"></i> Gaji Karyawan</a>
    <a href="pengeluaran.php"><i class="fas fa-money-bill-wave me-2"></i> Pengeluaran</a>
    <a href="laporan.php"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>📥 Barang Masuk</h2>
    <p class="text-muted">Catatan pembelian bahan baku dan bahan tambahan</p>

    <!-- Form Input -->
    <div class="card mb-4">
      <div class="card-header">
        <h5><i class="fas fa-plus-circle me-2"></i>Tambah Barang Masuk</h5>
      </div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Supplier</label>
            <select name="supplier" class="form-control" required>
              <option value="">Pilih Supplier</option>
              <?php 
              $suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY nama_supplier");
              while($supplier = mysqli_fetch_assoc($suppliers)) { ?>
                <option value="<?= $supplier['id'] ?>"><?= $supplier['nama_supplier'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Satuan</label>
            <input type="text" name="satuan" class="form-control" placeholder="Satuan" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Harga Satuan</label>
            <input type="number" name="harga_satuan" class="form-control" placeholder="Harga Satuan" required>
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
        <h5><i class="fas fa-table me-2"></i>Tabel Barang Masuk</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                  <td><?= $row['nama_barang'] ?></td>
                  <td><?= $row['supplier'] ?></td>
                  <td class="text-end"><?= number_format($row['jumlah']) ?></td>
                  <td><?= $row['satuan'] ?></td>
                  <td class="text-end">Rp <?= number_format($row['harga_satuan']) ?></td>
                  <td class="text-end"><strong>Rp <?= number_format($row['total_harga']) ?></strong></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</body>
</html>
