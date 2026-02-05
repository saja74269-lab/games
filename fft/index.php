<?php
include 'config.php';


// cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// jika edit mode
$editData = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM ilham WHERE idkar=$id");
    $editData = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard karyawan</title>

<?php 
echo "<a href='dashbord.php'><button>kembali dashbord</button></a>"
?>

<style>
body { font-family: Arial; background:#f2f2f2; display:flex; justify-content:center; align-items:flex-start; padding-top:50px; }
.container { background:white; padding:20px 30px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); width:500px; }
h2 { text-align:center; margin-bottom:20px; }
input[type="text"], input[type="date"] { width:100%; padding:10px; margin:10px 0; border-radius:5px; border:1px solid #ccc; }
button { width:100%; padding:10px; border-radius:5px; border:none; background-color:#4CAF50; color:white; font-size:16px; cursor:pointer; }
button:hover { background-color:#45a049; }
.output { margin-top:20px; max-height:300px; overflow-y:auto; border:1px solid #ddd; padding:10px; border-radius:5px; background-color:#fafafa; font-size:14px; }
.logout { text-align:right; margin-bottom:10px; }
.logout a { color:#f00; text-decoration:none; }
.logout a:hover { text-decoration:underline; }
.actions a { margin-right:10px; text-decoration:none; color:#00f; }
.actions a:hover { text-decoration:underline; }
</style>
</head>
<body>

<div class="container">
    <div class="logout"><a href="logout.php">Logout</a></div>
    <h2>Data update</h2>

    <!-- FORM EDIT -->
    <?php if ($editData): ?>
    <form action="aksi.php" method="POST">
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="idkar" value="<?= $editData['idkar']; ?>">

        <input type="text" name="namakar" value="<?= $editData['namakar']; ?>" required>
        <input type="text" name="alamatkar" value="<?= $editData['alamatkar']; ?>" required>
        <input type="text" name="jabatankar" value="<?= $editData['jabatankar']; ?>" required>
        
        <button type="submit">Update Data</button>
    </form>

    

    <?php else: ?>
    <!-- FORM TAMBAH -->
    <form action="aksi.php" method="POST">
        <input type="hidden" name="aksi" value="tambah">

        
        <input type="text" name="namakar" placeholder="namakar" required>
        <input type="text" name="alamatkar" placeholder ="alamatkar" required>
        <input type="text" name="jabatankar" placeholder="jabatankar" required>
        

    <button type="submit">Tambah Data</button>
    </form> 
    <?php endif; ?>


<h2>__D__A__T__A__</h2>
     
    <?php
echo "<a href='lihat_data.php'><button>lihat data</button></a>"
?>

</div>
</body>
</html>
