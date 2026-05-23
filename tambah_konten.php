<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}
require_once "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul = trim($_POST["judul"]);
    $subjudul = trim($_POST["subjudul"]);
    $daerah = trim($_POST["daerah"]);
    $kategori = trim($_POST["kategori"]);
    $deskripsi = trim($_POST["deskripsi"]);
    $informasi_umum = trim($_POST["informasi_umum"]);
    $sejarah = trim($_POST["sejarah"]);
    $instrumen = trim($_POST["instrumen"]);
    $nilai_budaya = trim($_POST["nilai_budaya"]);
    $diperbarui = date("Y-m-d");

    $gambar = "";
    $galeri = "";

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] === 0) {
        $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $nama_gambar = "hero" . str_replace(" ", "", ucwords($judul)) . "." . $ext;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], "gmbr_kontenjljh/" . $nama_gambar);
        $gambar = $nama_gambar;
    }

    $galeri_files = [];
    if (isset($_FILES["galeri"])) {
        foreach ($_FILES["galeri"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["galeri"]["error"][$i] === 0) {
                $ext = pathinfo($_FILES["galeri"]["name"][$i], PATHINFO_EXTENSION);
                $nama_galeri = strtolower(str_replace(" ", "", $judul)) . ($i + 1) . "." . $ext;
                move_uploaded_file($tmp, "gmbr_kontenjljh/" . $nama_galeri);
                $galeri_files[] = $nama_galeri;
            }
        }
    }
    $galeri = implode(",", $galeri_files);

    $stmt = $conn->prepare("INSERT INTO konten (judul, subjudul, daerah, kategori, deskripsi, informasi_umum, sejarah, instrumen, galeri, nilai_budaya, gambar, diperbarui) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $judul, $subjudul, $daerah, $kategori, $deskripsi, $informasi_umum, $sejarah, $instrumen, $galeri, $nilai_budaya, $gambar, $diperbarui);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Konten</title>
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="tambah_konten.css" />
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
                    <span></span><span></span><span></span>
                </div>
                <nav id="navMenu">
                    <ul>
                        <li><a href="landing.html" onclick="closeMenu()">Beranda</a></li>
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
                <h1>Tambah Konten Baru</h1>
                <div class="form-container">
                    <form method="POST" action="tambah_konten.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" required />
                        </div>
                        <div class="form-group">
                            <label>Subjudul</label>
                            <input type="text" name="subjudul" placeholder="Contoh: Seni Musik dari Jawa Tengah" />
                        </div>
                        <div class="form-group">
                            <label>Daerah</label>
                            <input type="text" name="daerah" required />
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" required />
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Informasi Umum</label>
                            <textarea name="informasi_umum" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Sejarah</label>
                            <textarea name="sejarah" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Instrumen yang Digunakan</label>
                            <input type="text" name="instrumen" placeholder="Contoh: Bonang,Gender,Gong,Kenong,Saron" />
                            <small>Pisahkan dengan koma tanpa spasi</small>
                        </div>
                        <div class="form-group">
                            <label>Nilai Budaya</label>
                            <textarea name="nilai_budaya" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Hero</label>
                            <input type="file" name="gambar" accept="image/*" />
                            <small>Nama file otomatis: hero[Judul].[ext]</small>
                        </div>
                        <div class="form-group">
                            <label>Galeri (maks. 3 gambar)</label>
                            <input type="file" name="galeri[]" accept="image/*" multiple />
                            <small>Nama file otomatis: [judul]1.[ext], [judul]2.[ext], dst</small>
                        </div>
                        <div class="form-btn">
                            <button type="submit">Simpan</button>
                            <a href="dashboard.php"><button type="button">Batal</button></a>
                        </div>
                    </form>
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
</body>

</html>