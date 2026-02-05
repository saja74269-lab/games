<?php
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<style>
.output {
    border: 2px solid black;
    padding: 10px;
    margin: 10px 0;
}
</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>data</title>
</head>
<body>
    <style>
body { font-family: Arial; background:#f2f2f2; display:flex; justify-content:center; align-items:center; height:100vh; }
.container { background:white; padding:20px 30px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); width:300px; }
h2 { text-align:center; margin-bottom:20px; }
input[type="text"], input[type="password"] { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
button { width:100%; padding:10px; border-radius:5px; border:none; background-color:#4CAF50; color:white; font-size:16px; cursor:pointer; }
button:hover { background-color:#45a049; }
.error { color:red; text-align:center; }
</style>

<a href="index.php">
    <button>kembali index</button>
</a>
    <div class="output">
        <?php
        $data = $conn->query("SELECT * FROM ilham ORDER BY idkar ASC");
        while ($row = $data->fetch_assoc()) {
            echo "
            <div>
                {$row['idkar']}. {$row['namakar']} | {$row['alamatkar']} | {$row['jabatankar']}
                <span class='actions'>
                    <a href='index.php?edit={$row['idkar']}'>Edit</a>
                    <a href='aksi.php?hapus={$row['idkar']}' onclick=\"return confirm('Hapus data yakin gk?');\">Hapus</a>
                </span>
            </div>";
        }
        ?>
    </div>

</body>
</html>