<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// === TAMBAH ===
if (isset($_POST['aksi']) && $_POST['aksi'] == "tambah") {

    $nama = $_POST['namakar'];
    $alamat = $_POST['alamatkar'];
    $jabatan  = $_POST['jabatankar'];
    $tgl  = $_POST['tanggalinput'];

    $conn->query("INSERT INTO ilham (namakar, alamatkar, jabatankar, tanggalinput)
                  VALUES ('$nama','$alamat','$jabatan','$tgl')");

    header("Location: lihat_data.php");
    exit;
}

// === EDIT ===
if (isset($_POST['aksi']) && $_POST['aksi'] == "edit") {

    $id   = $_POST['idkar'];
    $nama = $_POST['namakar'];
    $alamat  = $_POST['alamatkar'];
    $jabatan = $_POST['jabatankar'];
    $tgl  = $_POST['tanggalinput'];

    $conn->query("UPDATE ilham SET 
                    namakar='$nama',
                    alamatkar='$alamat',
                    jabatankar='$jabatan',
                    tanggalinput='$tgl'
                  WHERE idkar='$id'");

    header("Location: lihat_data.php");
    exit;
}

// === HAPUS ===
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];
    $conn->query("DELETE FROM ilham WHERE idkar='$id'");

    header("Location: lihat_data.php");
    exit;
}
