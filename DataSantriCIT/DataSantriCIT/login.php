<?php
session_start();
include "database.php";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $cek = mysqli_query($kon, "SELECT * FROM user WHERE username='$username' OR email='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        if (password_verify($password, $data["password"])) {
            $_SESSION["id_pengguna"] = $data["id"];
            $_SESSION["username"]    = $data["username"];
            $_SESSION["nama"]        = $data["nama_lengkap"];
            $_SESSION["foto"]        = $data["foto"];
            header("Location: dashboard.php");
            exit();
        } else {
            $pesan = "<div class='alert alert-danger'>❌ Password salah.</div>";
        }
    } else {
        $pesan = "<div class='alert alert-danger'>❌ Username/Email tidak ditemukan.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - Samurai</title>
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
    .login-box {
      background: rgba(0,0,0,0.8);
      padding: 30px;
      border-radius: 15px;
      width: 400px;
      color: white;
      border: 2px solid #e63946;
    }
    .btn-danger { width: 100%; }
    a { color: #e63946; }
  </style>
</head>
<body>
  <div class="login-box">
    <h3 class="text-center text-danger">⚔️ Login Samurai</h3>
    <?php echo $pesan; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-danger">Masuk ⚔️</button>
    </form>
    <p class="text-center mt-3">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>
</body>
</html>
