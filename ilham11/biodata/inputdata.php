<head>
    <title>Form Biodata</title>
</head>
<body>
    <h2>Input Biodata</h2>
    <form action="simpandata.php" method="post">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" rows="4" cols="30" required></textarea><br><br>

        <label>hobin:</label><br>
        <textarea name="hobin" rows="4" cols="30" required></textarea><br><br>

        <label>telopon:</label><br>
        <textarea name="telopon" rows="4" cols="30" required></textarea><br><br>

        <label>kelas:</label><br>
        <textarea name="kelas" rows="4" cols="30" required></textarea><br><br>


        <input type="submit" value="Simpan">
    </form>
    <br>
    <a href="lihatdata.php">Lihat Data</a>
</body>
</html>