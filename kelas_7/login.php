<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh login sederhana
    if ($username == "admin" && $password == "12345") {
        $_SESSION['username'] = $username;

        // Catat log login
        $logFile = "log.txt";
        $tanggal = date("Y-m-d H:i:s");
        $logData = "[$tanggal] User $username login" . PHP_EOL;
        file_put_contents($logFile, $logData, FILE_APPEND);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background:#f5f7fa;">
    <div class="card p-4 shadow" style="width: 350px; border-radius: 15px;">
        <h3 class="text-center mb-3">🔑 Login</h3>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>
