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
                            <div class="image-wrapper">
                                <img src="assets/data_statistik.png" alt="Gambar Data Statistik" />
                            </div>
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
                            <div class="image-wrapper">
                                <img src="assets/distribusi_konten.png" alt="Gambar Distribusi Konten" />
                            </div>
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
    <script src="navbar.js"></script>
</body>

</html>