<?php
include "database.php";
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama       = trim($_POST["nama"]);
    $email      = trim($_POST["email"]);
    $username   = trim($_POST["username"]);
    $password   = trim($_POST["password"]);
    $konfirmasi = trim($_POST["konfirmasi"]);

    if ($password !== $konfirmasi) {
        $pesan = "<div class='alert alert-danger'>❌ Password tidak sama.</div>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $q = "INSERT INTO user (nama_lengkap, email, username, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($kon, $q);
        mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $username, $hash);

        if (mysqli_stmt_execute($stmt)) {
            $pesan = "<div class='alert alert-success'>✅ Registrasi berhasil, silakan <a href='login.php'>login</a>.</div>";
        } else {
            $pesan = "<div class='alert alert-danger'>❌ Username / Email sudah digunakan.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Register - Samurai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('samurai keren.PNG') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
    }
    .register-box {
      background: rgba(0,0,0,0.85);
      padding: 30px;
      border-radius: 15px;
      width: 450px;
      color: white;
      border: 2px solid #e63946;
    }
    .btn-danger { width: 100%; }
    a { color: #e63946; text-decoration: none; }
  </style>
</head>
<body>
  <div class="register-box">
    <h3 class="text-center text-danger">⚔️ Register Samurai</h3>
    <?php echo $pesan; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Konfirmasi Password</label>
        <input type="password" name="konfirmasi" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-danger">Daftar ⚔️</button>
    </form>
    <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
