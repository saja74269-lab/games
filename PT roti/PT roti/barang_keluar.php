<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) { header("Location: login.php"); exit(); }

if (isset($_POST['simpan'])) {
    $tgl = $_POST['tanggal'];
    $nama = $_POST['nama_produk'];
    $customer_id = $_POST['customer'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga_jual'];
    $total = $jumlah * $harga;

    // Get customer name
    $customer_result = mysqli_query($conn, "SELECT nama_customer FROM customers WHERE id = '$customer_id'");
    $customer_name = mysqli_fetch_assoc($customer_result)['nama_customer'];

    $sql = "INSERT INTO barang_keluar (tanggal, nama_produk, customer, jumlah, satuan, harga_jual, total_penjualan)
            VALUES ('$tgl','$nama','$customer_name','$jumlah','$satuan','$harga','$total')";
    mysqli_query($conn, $sql);
}

// Get data for dropdowns
$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY nama_customer");
$data = mysqli_query($conn, "SELECT * FROM barang_keluar ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Barang Keluar - PT Roti</title>
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
    <a href="barang_keluar.php" class="active"><i class="fas fa-dolly me-2"></i> Barang Keluar</a>
    <a href="gaji.php"><i class="fas fa-user-tie me-2"></i> Gaji Karyawan</a>
    <a href="pengeluaran.php"><i class="fas fa-money-bill-wave me-2"></i> Pengeluaran</a>
    <a href="laporan.php"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>📤 Barang Keluar</h2>
    <p class="text-muted">Catatan hasil produksi dan penjualan</p>

    <!-- Form Input -->
    <div class="card mb-4">
      <div class="card-header">
        <h5><i class="fas fa-plus-circle me-2"></i>Tambah Barang Keluar</h5>
      </div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Customer</label>
            <select name="customer" class="form-control" required>
              <option value="">Pilih Customer</option>
              <?php 
              $customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY nama_customer");
              while($customer = mysqli_fetch_assoc($customers)) { ?>
                <option value="<?= $customer['id'] ?>"><?= $customer['nama_customer'] ?></option>
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
            <label class="form-label">Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" placeholder="Harga Jual" required>
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
        <h5><i class="fas fa-table me-2"></i>Tabel Barang Keluar</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Customer</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Jual</th>
                <th>Total Penjualan</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($data)) { ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                  <td><?= $row['nama_produk'] ?></td>
                  <td><?= $row['customer'] ?></td>
                  <td class="text-end"><?= number_format($row['jumlah']) ?></td>
                  <td><?= $row['satuan'] ?></td>
                  <td class="text-end">Rp <?= number_format($row['harga_jual']) ?></td>
                  <td class="text-end"><strong>Rp <?= number_format($row['total_penjualan']) ?></strong></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</body>
</html>
