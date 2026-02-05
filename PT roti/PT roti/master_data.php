<?php
include "database.php";
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Handle form submissions
if (isset($_POST['add_supplier'])) {
    $nama = $_POST['nama_supplier'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO suppliers (nama_supplier, alamat, telepon, email) VALUES ('$nama','$alamat','$telepon','$email')";
    mysqli_query($conn, $sql);
}

if (isset($_POST['add_customer'])) {
    $nama = $_POST['nama_customer'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO customers (nama_customer, alamat, telepon, email) VALUES ('$nama','$alamat','$telepon','$email')";
    mysqli_query($conn, $sql);
}

if (isset($_POST['add_jabatan'])) {
    $nama = $_POST['nama_jabatan'];
    
    $sql = "INSERT INTO jabatan (nama_jabatan) VALUES ('$nama')";
    mysqli_query($conn, $sql);
}

// Get data
$suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY nama_supplier");
$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY nama_customer");
$jabatan = mysqli_query($conn, "SELECT * FROM jabatan ORDER BY nama_jabatan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Master Data - PT Roti</title>
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
    <a href="laporan.php"><i class="fas fa-file-invoice-dollar me-2"></i> Laporan Keuangan</a>
    <a href="master_data.php" class="active"><i class="fas fa-database me-2"></i> Master Data</a>
    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2>🗃️ Master Data</h2>
    <p class="text-muted">Kelola data master untuk Supplier, Customer, dan Jabatan</p>

    <!-- Supplier Management -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-truck me-2"></i>Data Supplier</h5>
          </div>
          <div class="card-body">
            <form method="post" class="mb-3">
              <div class="row g-2">
                <div class="col-md-6">
                  <input type="text" name="nama_supplier" class="form-control" placeholder="Nama Supplier" required>
                </div>
                <div class="col-md-6">
                  <input type="text" name="telepon" class="form-control" placeholder="Telepon">
                </div>
                <div class="col-md-12">
                  <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                </div>
                <div class="col-md-12">
                  <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-12">
                  <button type="submit" name="add_supplier" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Supplier
                  </button>
                </div>
              </div>
            </form>
            <div class="table-responsive" style="max-height: 300px;">
              <table class="table table-sm table-striped">
                <thead class="table-dark">
                  <tr>
                    <th>Nama Supplier</th>
                    <th>Telepon</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($suppliers)) { ?>
                    <tr>
                      <td><?= $row['nama_supplier'] ?></td>
                      <td><?= $row['telepon'] ?></td>
                      <td><?= $row['email'] ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Customer Management -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-users me-2"></i>Data Customer</h5>
          </div>
          <div class="card-body">
            <form method="post" class="mb-3">
              <div class="row g-2">
                <div class="col-md-6">
                  <input type="text" name="nama_customer" class="form-control" placeholder="Nama Customer" required>
                </div>
                <div class="col-md-6">
                  <input type="text" name="telepon" class="form-control" placeholder="Telepon">
                </div>
                <div class="col-md-12">
                  <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                </div>
                <div class="col-md-12">
                  <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="col-md-12">
                  <button type="submit" name="add_customer" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Customer
                  </button>
                </div>
              </div>
            </form>
            <div class="table-responsive" style="max-height: 300px;">
              <table class="table table-sm table-striped">
                <thead class="table-dark">
                  <tr>
                    <th>Nama Customer</th>
                    <th>Telepon</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($customers)) { ?>
                    <tr>
                      <td><?= $row['nama_customer'] ?></td>
                      <td><?= $row['telepon'] ?></td>
                      <td><?= $row['email'] ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Jabatan Management -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5><i class="fas fa-briefcase me-2"></i>Data Jabatan</h5>
          </div>
          <div class="card-body">
            <form method="post" class="mb-3">
              <div class="row g-2">
                <div class="col-md-4">
                  <input type="text" name="nama_jabatan" class="form-control" placeholder="Nama Jabatan" required>
                </div>
                <div class="col-md-2">
                  <button type="submit" name="add_jabatan" class="btn btn-warning btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah Jabatan
                  </button>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-sm table-striped">
                <thead class="table-dark">
                  <tr>
                    <th>No</th>
                    <th>Nama Jabatan</th>
                    <th>Tanggal Dibuat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 1;
                  while($row = mysqli_fetch_assoc($jabatan)) { ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $row['nama_jabatan'] ?></td>
                      <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

