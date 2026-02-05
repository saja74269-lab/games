<?php
include "koneksi.php";

function tambahLog($user, $aktivitas) {
    global $koneksi;
    $user = mysqli_real_escape_string($koneksi, $user);
    $aktivitas = mysqli_real_escape_string($koneksi, $aktivitas);

    $sql = "INSERT INTO log_aktivitas (user, aktivitas) VALUES ('$user', '$aktivitas')";
    mysqli_query($koneksi, $sql);
}
