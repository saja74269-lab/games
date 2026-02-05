<?php
include "koneksi.php";
?>

<h2>Halaman PHP (Input & Output)</h2>

<h3>Form Input Data Siswa</h3>

<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Kelas:</label><br>
    <input type="text" name="kelas" required><br><br>

    <label>Alamat:</label><br>
    <input type="text" name="alamat" required><br><br>

    <label>Tanggal Lahir:</label><br>
    <input type="date" name="tgl_lahir" required><br><br>

    <label>Tanggal Daftar:</label><br>
    <input type="date" name="tgl_daftar" required><br><br>

    <button type="submit" name="simpan">SIMPAN</button>
</form>

<hr>

<?php
// PROSES SIMPAN KE DATABASE
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $tgl_daftar = $_POST['tgl_daftar'];

    $query = "INSERT INTO siswa (nama, kelas, alamat, tgl_lahir, tgl_daftar)
              VALUES ('$nama','$kelas','$alamat','$tgl_lahir','$tgl_daftar')";
    
    mysqli_query($koneksi, $query);
}
?>

<h3>Output Data (Dari Database)</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>Tanggal Lahir</th>
        <th>Tanggal Daftar</th>
    </tr>

<?php
// AMBIL DATA DARI DATABASE
$result = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id DESC");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".$row['nama']."</td>
            <td>".$row['kelas']."</td>
            <td>".$row['alamat']."</td>
            <td>".$row['tanggallahir']."</td>
            <td>".$row['tanggaldaftar']."</td>
          </tr>";
}
?>
</table>
