<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'mi_cit';

$koneksi = new mysqli($host,$user,$pass,$db)
if ($koneksi->connect_error){
    die("koneksi gagal:" .$koneksi->connect_error);
}
$koneksi->set_charset("utf8mb4");
?>