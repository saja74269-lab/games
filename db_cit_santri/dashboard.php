<?php
session_start();

// Jika belum login, arahkan ke login.php
if (!isset($_SESSION["id_santri"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Santri CIT</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f8ff;
            padding: 50px;
        }
        .dashboard {
            background: white;
            max-width: 600px;
            margin: auto;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        button {
            background: #1565c0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Selamat datang, <?= $_SESSION["nama_lengkap"] ?> (<?= $_SESSION["kelas"] ?>)</h2>
        <h3>Pengalaman 3 Bulan Mondok:</h3>
        <p><?= $_SESSION["pengalaman"] ?></p>
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
