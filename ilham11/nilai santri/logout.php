<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Catat log logout
$logFile = "log.txt";
$tanggal = date("Y-m-d H:i:s");
$logData = "[$tanggal] User logout" . PHP_EOL;
file_put_contents($logFile, $logData, FILE_APPEND);

// Arahkan ke halaman login
header("Location: login.php");
exit;
?>
