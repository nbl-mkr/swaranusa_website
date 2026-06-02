<?php
require_once "koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $konten_id = 0;
    $judul = trim($_POST["judul"]);
    $daerah = trim($_POST["daerah"]);
    $kategori = trim($_POST["kategori"]);
    $pengertian = trim($_POST["pengertian"]);
    $cara_main = trim($_POST["cara_main"]);
    $keterangan_bagian = trim($_POST["keterangan_bagian"]);
    $diperbarui = date("Y-m-d");

    $gambar = "";
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] === 0) {
        $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $nama_gambar = "gambar" . str_replace(" ", "", ucwords($judul)) . "." . $ext;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], "gmbr_kontenbljr/" . $nama_gambar);
        $gambar = $nama_gambar;
    }

    $gambar_bagian_files = [];
    if (isset($_FILES["gambar_bagian"])) {
        foreach ($_FILES["gambar_bagian"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["gambar_bagian"]["error"][$i] === 0) {
                $ext = pathinfo($_FILES["gambar_bagian"]["name"][$i], PATHINFO_EXTENSION);
                $nama_bagian = "bagian" . str_replace(" ", "", ucwords($judul)) . ($i + 1) . "." . $ext;
                move_uploaded_file($tmp, "gmbr_kontenbljr/" . $nama_bagian);
                $gambar_bagian_files[] = $nama_bagian;
            }
        }
    }
    $gambar_bagian = implode(",", $gambar_bagian_files);

    $audio_files = [];
    if (isset($_FILES["audio"])) {
        foreach ($_FILES["audio"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["audio"]["error"][$i] === 0) {
                $nama_audio = $_FILES["audio"]["name"][$i];
                move_uploaded_file($tmp, "gmbr_kontenbljr/" . $nama_audio);
                $audio_files[] = $nama_audio;
            }
        }
    }
    $audio = implode(",", $audio_files);

    $video_files = [];
    if (isset($_FILES["video"])) {
        foreach ($_FILES["video"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["video"]["error"][$i] === 0) {
                $nama_video = $_FILES["video"]["name"][$i];
                move_uploaded_file($tmp, "gmbr_kontenbljr/" . $nama_video);
                $video_files[] = $nama_video;
            }
        }
    }
    $video = implode(",", $video_files);

    $stmt = $conn->prepare("INSERT INTO belajar (konten_id, judul, daerah, kategori, gambar, pengertian, cara_main, gambar_bagian, keterangan_bagian, audio, video, diperbarui) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssss", $konten_id, $judul, $daerah, $kategori, $gambar, $pengertian, $cara_main, $gambar_bagian, $keterangan_bagian, $audio, $video, $diperbarui);
    $stmt->execute();
    $stmt->close();

    header("Location: konten.php?tab=belajar");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Tambah Konten Belajar</title>
    <link rel="stylesheet" href="navbar.css" />
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
                <h1>Tambah Konten Belajar</h1>
                <div class="form-container">
                    <form method="POST" action="tambah_belajar.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" required />
                        </div>
                        <div class="form-group">
                            <label>Daerah</label>
                            <input type="text" name="daerah" required />
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" required>
                                <option value="">Pilih kategori</option>
                                <option value="Ansambel">Ansambel</option>
                                <option value="Gesek">Gesek</option>
                                <option value="Petik">Petik</option>
                                <option value="Tiup">Tiup</option>
                                <option value="Pukul">Pukul</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pengertian</label>
                            <textarea name="pengertian" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Cara Memainkan</label>
                            <textarea name="cara_main" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Hero</label>
                            <input type="file" name="gambar" accept="image/*" />
                        </div>
                        <div class="form-group">
                            <label>Gambar Bagian (maks. 2 gambar)</label>
                            <input type="file" name="gambar_bagian[]" accept="image/*" multiple />
                            <p>Gambar bagian-bagian alat musik</p>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Bagian</label>
                            <textarea name="keterangan_bagian" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Audio</label>
                            <input type="file" name="audio[]" accept="audio/*" multiple />
                        </div>
                        <div class="form-group">
                            <label>Video</label>
                            <input type="file" name="video[]" accept="video/*" multiple />
                        </div>
                        <div class="form-btn">
                            <button type="submit">Simpan</button>
                            <a href="konten.php?tab=belajar"><button type="button">Batal</button></a>
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
    <script src="navbar.js"></script>
</body>

</html>