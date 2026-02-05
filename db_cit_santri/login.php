<?php
session_start();
include "config.php";

$pesan = "";

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = ($_POST["password"]);

    $query = "SELECT * FROM tb_santri WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION["id_santri"] = $data["id_santri"];
        $_SESSION["nama_lengkap"] = $data["nama_lengkap"];
        $_SESSION["kelas"] = $data["kelas"];
        $_SESSION["pengalaman"] = $data["pengalaman"];
        header("Location: dashboard.php");
        exit();
    } else {
        $pesan = "Username atau password salah, silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Santri CIT</title>
    <style>
        body {
            font-family: Arial;
            background: #e3f2fd;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            width: 320px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #90caf9;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: #1565c0;
            color: white;
            border: none;
            border-radius: 8px;
        }
        p {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 align="center">Login Santri CIT</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p><?= $pesan ?></p>
        </form>
    </div>
</body>
</html>
