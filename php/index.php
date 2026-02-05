<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Website PHP Murni</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="header">
    <h1> Website PHP Sederhana</h1>
</div>

<div id="menu">
    <a href="index.php?page=utama">UTAMA</a>
    <a href="index.php?page=php">PHP</a>
</div>

<div id="container">
    <?php
    // Router halaman PHP
    $page = $_GET['page'] ?? 'utama';

    if ($page == "utama") {
        include "utama.php";
    }
    elseif ($page == "php") {
        include "php.php";
    }
    else {
        echo "<h2>Halaman tidak ditemukan.</h2>";
    }
    ?>
</div>

<div id="footer">
    #tahun 2025
</div>

</body>
</html>
