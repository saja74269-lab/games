<?php
// koneksi database
$koneksi = new mysqli("localhost", "root", "", "nilai_santri");

// cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// ambil data dari tabel (pastikan nama tabelnya sesuai, misalnya 'santri' atau 'biodata')
$result = mysqli_query($koneksi, "SELECT * FROM biodata");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Nilai Santri</title>
    <style>
        body {font-family: Arial, sans-serif;}
        .menu {
            width: 90%; margin: 20px auto; text-align: center;
        }
        .btn {
            display: inline-block;
            margin: 5px;
            background: green;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }
        table {border-collapse: collapse; width: 90%; margin: auto;}
        th, td {border: 1px solid #ddd; padding: 8px; text-align: center;}
        th {background: green; color: white;}
        .aksi a {margin: 0 5px; text-decoration: none;}
    </style>
</head>
<body>

<h2 align="center">📋 Daftar Nilai Santri</h2>

<!-- Menu tombol -->
<div class="menu">
    <a href="home.php" class="btn">🏠 Home</a>
    <a href="input.php" class="btn">+ Input Data</a>
</div>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Nilai IT</th>
        <th>Nilai Inggris</th>
        <th>Nilai Diniyah</th>
        <th>Total</th>
        <th>Rata-rata</th>
        <th>Aksi</th>
    </tr>
    <?php
    if ($result && $result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $total = $row['nilai_it'] + $row['nilai_inggris'] + $row['nilai_diniyah'];
            $rata  = $total / 3;
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$row['nama']."</td>
                    <td>".$row['nilai_it']."</td>
                    <td>".$row['nilai_inggris']."</td>
                    <td>".$row['nilai_diniyah']."</td>
                    <td>".$total."</td>
                    <td>".number_format($rata,2)."</td>
                    <td>
                        <a href='edit.php?id=".$row['id']."'>✏️ Edit</a> | 
                        <a href='hapus.php?id=".$row['id']."' onclick=\"return confirm('Yakin hapus data ini?')\">🗑 Hapus</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Data belum ada</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$koneksi->close();
?>


