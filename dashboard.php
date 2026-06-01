<?php
require_once "koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}

$total_konten = $conn->query("SELECT COUNT(*) as total FROM jelajahi")->fetch_assoc()["total"];
$total_user = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'")->fetch_assoc()["total"];
$total_histori_jelajahi = $conn->query("SELECT COUNT(*) as total FROM histori WHERE tipe = 'jelajahi'")->fetch_assoc()["total"];
$total_histori_belajar = $conn->query("SELECT COUNT(*) as total FROM histori WHERE tipe = 'belajar'")->fetch_assoc()["total"];
$konten_bulan_ini = $conn->query("SELECT COUNT(*) as total FROM jelajahi WHERE DATE_FORMAT(diperbarui, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')")->fetch_assoc()["total"];

$konten_terbaru = $conn->query("SELECT judul, daerah FROM jelajahi ORDER BY diperbarui DESC LIMIT 3")->fetch_all(MYSQLI_ASSOC);

$data_histori = $conn->query("
    SELECT tipe, COUNT(*) as total 
    FROM histori 
    GROUP BY tipe
")->fetch_all(MYSQLI_ASSOC);

$data_bulanan = $conn->query("
    SELECT DATE_FORMAT(diperbarui, '%b') as bulan, COUNT(*) as total 
    FROM jelajahi 
    WHERE YEAR(diperbarui) = YEAR(NOW()) 
    GROUP BY DATE_FORMAT(diperbarui, '%Y-%m') 
    ORDER BY diperbarui ASC
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Dashboard</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="dashboard.css" />
</head>

<body>
    <div class="menu-container">
        <div class="left-side">
            <div class="logo-text">
                <img src="assets/logo_white.png" alt="Logo SwaraNusa" />
                <h1>SwaraNusa</h1>
            </div>
            <?php include 'sidebar_admin.php'; ?>
        </div>

        <main class="main-content">
            <header>
                <ul class="logo-navbar">
                    <li></li>
                    <li>
                        <h1></h1>
                    </li>
                </ul>
                <div class="hamburger" onclick="toggleMenu()">
                    <span></span><span></span><span></span>
                </div>
                <?php include 'navbar_menu.php'; ?>
            </header>

            <section class="content-area">
                <h1>Dashboard</h1>

                <div class="container-top">
                    <div class="card">
                        <h3>Total Konten</h3>
                        <p><?= $total_konten ?></p>
                    </div>
                    <div class="card">
                        <h3>Pengguna Aktif</h3>
                        <p><?= $total_user ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Histori</h3>
                        <p><?= $total_histori_jelajahi + $total_histori_belajar ?></p>
                    </div>
                    <div class="card">
                        <h3>Konten Baru Bulan Ini</h3>
                        <p><?= $konten_bulan_ini ?></p>
                    </div>
                </div>

                <div class="analisis-container">
                    <div class="container-left">
                        <div class="card">
                            <h3>Data Statistik</h3>
                            <canvas id="chartBulanan"></canvas>
                        </div>
                        <div class="card">
                            <h3>Data Bulan Ini</h3>
                            <?php foreach ($konten_terbaru as $k): ?>
                                <p><?= htmlspecialchars($k['judul']) ?> - <?= htmlspecialchars($k['daerah']) ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="container-right">
                        <div class="card">
                            <h3>Distribusi Konten</h3>
                            <canvas id="chartDistribusi"></canvas>
                        </div>
                        <div class="card">
                            <h3>Apa yang bisa ditemukan disini?</h3>
                            <p>Trending topik terbaru</p>
                            <p>Detail pengunjung topik</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        function toggleMenu() {
            const nav = document.getElementById("navMenu");
            const hamburger = document.querySelector(".hamburger");
            nav.classList.toggle("active");
            hamburger.classList.toggle("active");
        }

        function closeMenu() {
            const nav = document.getElementById("navMenu");
            const hamburger = document.querySelector(".hamburger");
            nav.classList.remove("active");
            hamburger.classList.remove("active");
        }

        document.addEventListener("click", function (event) {
            const nav = document.getElementById("navMenu");
            const hamburger = document.querySelector(".hamburger");
            const isClickInsideNav = nav.contains(event.target);
            const isClickOnHamburger = hamburger.contains(event.target);
            if (!isClickInsideNav && !isClickOnHamburger && nav.classList.contains("active")) {
                closeMenu();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        const bulanMap = {
            'Jan': 'Jan', 'Feb': 'Feb', 'Mar': 'Mar', 'Apr': 'Apr', 'May': 'Mei',
            'Jun': 'Jun', 'Jul': 'Jul', 'Aug': 'Agu', 'Sep': 'Sep', 'Oct': 'Okt',
            'Nov': 'Nov', 'Dec': 'Des'
        };

        const tipeMap = { 'jelajahi': 'Jelajahi', 'belajar': 'Belajar' };

        const bulananLabel = <?= json_encode(array_column($data_bulanan, 'bulan')) ?>.map(b => bulanMap[b] || b);
        const bulananData = <?= json_encode(array_column($data_bulanan, 'total')) ?>;

        const distribusiLabel = <?= json_encode(array_column($data_histori, 'tipe')) ?>.map(t => tipeMap[t] || t);
        const distribusiData = <?= json_encode(array_column($data_histori, 'total')) ?>.map(Number);
        new Chart(document.getElementById('chartBulanan'), {
            type: 'bar',
            data: {
                labels: bulananLabel,
                datasets: [{
                    label: 'Konten per bulan',
                    data: bulananData,
                    backgroundColor: '#543a14',
                    barPercentage: 0.3,
                    categoryPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });

        new Chart(document.getElementById('chartDistribusi'), {
            type: 'doughnut',
            data: {
                labels: distribusiLabel,
                datasets: [{
                    data: distribusiData,
                    backgroundColor: ['#543a14', '#f0bb78']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        color: '#ffffff',
                        formatter: (value, ctx) => {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            return ((value / total) * 100).toFixed(1) + '%';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
    <script src="navbar.js"></script>
</body>

</html>