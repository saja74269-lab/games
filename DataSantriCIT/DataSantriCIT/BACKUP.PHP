<?php

include "database.php"; // koneksi ke database

$nama_database = $kon->query("SELECT DATABASE()")->fetch_row()[0];
$backup_time = date("Ymd_His");
$backup_file = "backup_datasantricit_{$backup_time}.sql";

// Mulai membuat isi file SQL
$sql_backup = "-- ---------------------------------------------------------\n";
$sql_backup .= "-- Backup Database: {$nama_database}\n";
$sql_backup .= "-- Dibuat pada: " . date("Y-m-d H:i:s") . "\n";
$sql_backup .= "-- ---------------------------------------------------------\n\n";

$tables = [];
$result = $kon->query("SHOW TABLES");

while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    // Struktur tabel
    $create_table = $kon->query("SHOW CREATE TABLE `$table`")->fetch_assoc()['Create Table'];
    $sql_backup .= "\n-- Struktur tabel `$table`\n";
    $sql_backup .= "DROP TABLE IF EXISTS `$table`;\n";
    $sql_backup .= $create_table . ";\n\n";

    // Data tabel
    $rows = $kon->query("SELECT * FROM `$table`");
    if ($rows->num_rows > 0) {
        $sql_backup .= "-- Data dari tabel `$table`\n";
        while ($row = $rows->fetch_assoc()) {
            $values = array_map(function ($val) use ($kon) {
                if ($val === null) return "NULL";
                return "'" . $kon->real_escape_string($val) . "'";
            }, array_values($row));
            $sql_backup .= "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n";
        }
        $sql_backup .= "\n";
    }
}

// Header untuk mengunduh file .sql
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $backup_file . '"');
header('Content-Length: ' . strlen($sql_backup));

echo $sql_backup;
exit;
?>