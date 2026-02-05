<?php
$logFile = "log.txt";
$logs = file_exists($logFile) ? file($logFile) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lihat Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>📜 Log Aktivitas</h3>
    <pre class="bg-light p-3 border rounded" style="max-height:400px; overflow:auto;">
<?php foreach($logs as $log) echo htmlspecialchars($log); ?>
    </pre>
    <a href="dashboard.php" class="btn btn-primary">⬅ Kembali ke Dashboard</a>
</body>
</html>
