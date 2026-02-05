<?php
// Memulai session
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Dashboard - Data Karyawan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1508780709619-79562169bc64?auto=format&fit=crop&w=1600&q=80') 
                        no-repeat center center fixed;
            background-size: cover;
            color: #333;
            min-height: 100vh;
            position: relative;
        }

        /* Overlay */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(6px);
            z-index: -1;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 15px rgba(0,0,0,0.25);
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .navbar-brand {
            font-weight: 600;
            color: #fff !important;
        }

        /* Sidebar */
        .sidebar {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            min-height: calc(100vh - 56px);
            box-shadow: 2px 0 15px rgba(0,0,0,0.15);
            position: fixed;
            width: 250px;
            left: 0; top: 56px;
            border-radius: 0 15px 15px 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .sidebar.collapsed { width: 70px; }

        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { border-bottom: 1px solid #f0f0f0; }
        .sidebar-menu a {
            display: flex; align-items: center;
            padding: 15px 20px;
            color: #444; text-decoration: none;
            transition: all 0.3s ease;
        }
        .sidebar-menu a:hover {
            background: rgba(102,126,234,0.15);
            color: #667eea;
        }
        .sidebar-menu a.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }
        .sidebar-menu i { width: 20px; margin-right: 10px; text-align: center; }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: all 0.3s ease;
        }
        .main-content.expanded { margin-left: 70px; }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, rgba(102,126,234,0.9), rgba(118,75,162,0.9));
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        }

        /* Stats & Charts */
        .stats-card, .chart-container {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stats-card:hover, .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }

        .stats-icon {
            width: 60px; height: 60px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white; margin-bottom: 15px;
        }
        .stats-number { font-size: 2rem; font-weight: 700; color: #333; margin-bottom: 5px; }
        .stats-label { color: #666; font-size: 0.9rem; font-weight: 500; }

        .btn-logout {
            background: #dc3545; border: none; color: white;
            padding: 8px 15px; border-radius: 8px; transition: 0.3s;
        }
        .btn-logout:hover { background: #c82333; transform: translateY(-2px); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand ms-3" href="#">
                <i class="fas fa-graduation-cap me-2"></i>Data Santri CIT
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i><?php echo $_SESSION["username"]; ?>
                    </a>
                    <ul class="dropdown-menu">
                       
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li><a href="inputdata.php"><i class="fas fa-users"></i><span>Data Karyawan</span></a></li>

        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">Selamat Datang, <?php echo $_SESSION["username"]; ?>!</h2>
                    <p class="mb-0">Sistem Data Karyawan - Pondok Pesantren</p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-mosque" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('expanded');
        }

        // Monthly Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Hafalan Baru',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Hafalan Ulang',
                    data: [8, 15, 12, 18, 16, 20],
                    borderColor: '#764ba2',
                    backgroundColor: 'rgba(118, 75, 162, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Juz 1', 'Juz 2', 'Juz 3', 'Juz 4', 'Juz 5'],
                datasets: [{
                    data: [30, 25, 20, 15, 10],
                    backgroundColor: ['#667eea','#764ba2','#28a745','#ffc107','#dc3545']
                }]
            }
        });
    </script>
</body>
</html>
