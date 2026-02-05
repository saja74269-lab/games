 
<?php
// Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "db_cit");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// CREATE & UPDATE
if (isset($_POST['simpan'])) {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $nis    = $_POST['nis'];
    $kelas  = $_POST['kelas'];
    $alamat = $_POST['alamat'];

    if ($simpan == "id") {
        mysqli_query($conn, "INSERT INTO santri VALUES (','$nama','$nis','$kelas','$alamat'NOW,())");
    } else {
        mysqli_query($conn, "UPDATE santri SET 
            nama='$nama',
            nis='$nis',
            kelas='$kelas',
            alamat='$alamat'
            WHERE id='$id'");
    }
    header("Location: index.php");
}

// DELETE
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM santri WHERE id='$_GET[hapus]'");
    header("Location: index.php");
}

// EDIT
$edit = null;
if (isset($_GET['edit'])) {
    $edit = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM santri WHERE id='$_GET[edit]'")
    );
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Data Santri</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; padding: 20px; }
        h2 { color: #2c3e50; }
        input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 15px; background: #2ecc71; border: none; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background: #3498db; color: white; }
        a { text-decoration: none; color: #e74c3c; }
    </style>
</head>
<body>

<h2>Form Data Santri</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
    
    <label>Nama Santri</label>
    <input type="text" name="nama" required value="<?= $edit['nama'] ?? '' ?>">

    <label>NIS</label>
    <input type="text" name="nis" required value="<?= $edit['nis'] ?? '' ?>">

    <label>Kelas</label>
    <input type="text" name="kelas" required value="<?= $edit['kelas'] ?? '' ?>">

    <label>Alamat</label>
    <textarea name="alamat" required><?= $edit['alamat'] ?? '' ?></textarea>

    <button type="submit" name="simpan">Simpan Data</button>
</form>

<h2>Data Santri</h2>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIS</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $data = mysqli_query($conn, "SELECT * FROM santri ");
    while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['nis'] ?></td>
        <td><?= $row['kelas'] ?></td>
        <td><?= $row['alamat'] ?></td>
        <td>
            <a href="?edit=<?= $row['id'] ?>">Edit</a> |
            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus data?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
