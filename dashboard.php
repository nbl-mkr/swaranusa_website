<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Dashboard</title>
    <link rel="stylesheet" href="dashboard.css" />
</head>

<body>
    <div class="menu-container">
        <div class="left-side">
            <div class="logo-text">
                <img src="assets/logo_white.png" alt="Logo SwaraNusa" />
                <h1>SwaraNusa</h1>
            </div>
            <nav class="sidebar-menu">
                <div>
                    <img src="assets/logo_dashboard.png" alt="Logo Dashboard" />
                    <a href="dashboard.php">Dashboard</a>
                </div>
                <div>
                    <img src="assets/logo_analisis.png" alt="Logo Analisis" />
                    <a href="analisis.php">Analisis</a>
                </div>
                <div>
                    <img src="assets/logo_histori.png" alt="Logo Histori" />
                    <a href="histori.php">Histori</a>
                </div>
                <div>
                    <img src="assets/logo_kelola.png" alt="Logo Kelola" width="15px" height="15px" />
                    <a href="kelola.php">Kelola Akun</a>
                </div>
            </nav>
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
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <nav id="navMenu">
                    <ul>
                        <li><a href="index.html" onclick="closeMenu()">Beranda</a></li>
                        <li><a href="jelajahi.html" onclick="closeMenu()">Jelajahi</a></li>
                        <li><a href="belajar.html" onclick="closeMenu()">Belajar</a></li>
                        <li><a href="tentang.html" onclick="closeMenu()">Tentang</a></li>
                        <li>
                            <a href="kelola.php" onclick="closeMenu()">
                                <img src="assets/user.png" alt="User" />
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>

            <section class="content-area">
                <h1>Dashboard</h1>
                <div class="dashboard-container">
                    <div class="container-top">
                        <div class="card">
                            <h3>Total Konten</h3>
                            <p>123</p>
                        </div>
                        <div class="card">
                            <h3>Pengguna Aktif</h3>
                            <p>54</p>
                        </div>
                        <div class="card">
                            <h3>Favorit Disimpan</h3>
                            <p>321</p>
                        </div>
                        <div class="card">
                            <h3>Konten Baru Bulan Ini</h3>
                            <p>9</p>
                        </div>
                    </div>
                    <div class="container-bottom">
                        <h3>Manajemen Konten</h3>
                        <button>+ Tambah Konten Baru</button>
                        <div class="container-flex">
                            <div class="row1">
                                <h3>Judul</h3>
                                <h3>Daerah</h3>
                                <h3>Kategori</h3>
                                <h3>Diperbarui</h3>
                                <h3>Aksi</h3>
                            </div>
                            <div class="row2">
                                <p>Gamelan</p>
                                <p>Jawa Tengah</p>
                                <p>Ansambel</p>
                                <p>12/09/2025</p>
                                <div>
                                    <button>Edit</button>
                                    <button>Hapus</button>
                                </div>
                            </div>
                            <div class="row3">
                                <p>Angklung</p>
                                <p>Jawa Barat</p>
                                <p>Ansambel</p>
                                <p>10/09/2025</p>
                                <div>
                                    <button>Edit</button>
                                    <button>Hapus</button>
                                </div>
                            </div>
                            <div class="row4">
                                <p>Sasando</p>
                                <p>NTT</p>
                                <p>Ansambel</p>
                                <p>08/09/2025</p>
                                <div>
                                    <button>Edit</button>
                                    <button>Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div id="popup-edit" class="popup-overlay">
        <div class="popup-container">
            <div class="left-content">
                <img src="assets/gambar-gamelan.png" alt="Gambar Gamelan" />
            </div>
            <div class="right-content">
                <h3>Judul</h3>
                <input id="popup-judul" type="text" />
                <h3>Deskripsi</h3>
                <textarea id="popup-deskripsi" rows="4"></textarea>
                <div class="popup-bottom">
                    <button onclick="closePopup()">Simpan</button>
                    <img src="assets/upload.png" alt="Logo Upload" />
                </div>
            </div>
        </div>
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

        const popup = document.getElementById("popup-edit");

        document.querySelectorAll(".container-flex button:first-child").forEach((btn) => {
            btn.addEventListener("click", function () {
                popup.classList.add("active");
            });
        });

        function closePopup() {
            popup.classList.remove("active");
        }
    </script>
</body>

</html>