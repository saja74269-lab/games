<?php
include "koneksi.php";

// ambil data lama
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM biodata WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaguru = $_POST['namaguru'];
    $nikguru = $_POST['nikguru'];
    $alamatguru = $_POST['alamatguru'];
    $jabatanguru = $_POST['jabatanguru'];
    $tanggallahirguru = $_POST['tanggallahirguru'];
    $tanggalinputguru = $_POST['tanggalinputguru'];

    mysqli_query($koneksi, "UPDATE biodata SET 
        nama='$namaguru', 
        nikguru='$nikguru', 
        alamatguru='$alamatguru', 
        jabatanguru='$jabatanguru'
        tanggallahirguru='$tanggallahirguru', 
        tanggalinputguru='$tanggalinputguru' 
        WHERE id=$id");

    header("Location: lihatdata.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <h2>Edit Data</h2>
    <form method="POST">
        Namaguru: <input type="text" name="namaguru" value="<?php echo $data['namaguru']; ?>"><br>
        nikguru: <input type="number" name="nikguru" value="<?php echo $data['nikguru']; ?>"><br>
        alamatguru: <input type="number" name="alamatguru" value="<?php echo $data['alamatguru']; ?>"><br>
        jabatanguru: <input type="number" name="jabatanguru" value="<?php echo $data['jabatanguru']; ?>"><br>
        tanggallahirguru: <input type="text" name="tanggallahirguru" value="<?php echo $data['tanggallahirguru']; ?>"><br>
        tanggalinputguru: <input type="number" name="tanggalinputguru" value="<?php echo $data['tanggalinputguru']; ?>"><br>
        <input type="submit" value="Simpan">
    </form>
</body>
</html>
