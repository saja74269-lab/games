<?php
include "koneksi.php";
$result = mysqli_query($koneksi, "SELECT * FROM biodata");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Biodata</title>
</head>
<body>
    <h2>Daftar Biodata</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>hobin</th>
            <th>telopon</th>
            <th>kelas</th>
        </tr>
        <?php
        $no=1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$row['nama']."</td>
                    <td>".$row['alamat']."</td>
                     <td>".$row['hobin']."</td>
                    <td>".$row['telopon']."</td>
                     <td>".$row['kelas']."</td>
                 </tr>";
        }
        ?>
    </table>
    <br>
    <a href="inputdata.php">Input Lagi</a>
</body>
</html>