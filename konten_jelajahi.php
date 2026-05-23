<?php
session_start();
require_once "koneksi.php";

if (!isset($_GET["id"])) {
    header("Location: jelajahi.html");
    exit;
}

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM konten WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$konten = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$konten) {
    header("Location: jelajahi.html");
    exit;
}

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $konten_id = $id;
    $dilihat_pada = date("Y-m-d H:i:s");

    $cek = $conn->prepare("SELECT id FROM histori WHERE user_id = ? AND konten_id = ?");
    $cek->bind_param("ii", $user_id, $konten_id);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $update = $conn->prepare("UPDATE histori SET dilihat_pada = ? WHERE user_id = ? AND konten_id = ?");
        $update->bind_param("sii", $dilihat_pada, $user_id, $konten_id);
        $update->execute();
        $update->close();
    } else {
        $insert = $conn->prepare("INSERT INTO histori (user_id, konten_id, dilihat_pada) VALUES (?, ?, ?)");
        $insert->bind_param("iis", $user_id, $konten_id, $dilihat_pada);
        $insert->execute();
        $insert->close();
    }
    $cek->close();
}

$instrumen_list = $konten['instrumen'] ? explode(",", $konten['instrumen']) : [];
$galeri_list = $konten['galeri'] ? explode(",", $konten['galeri']) : [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>
        <?= htmlspecialchars($konten['judul']) ?> - SwaraNusa
    </title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="konten_jelajahi.css" />
</head>

<body>
    <header>
        <ul class="logo-navbar">
            <li><img src="gmbr_gnrl/logo.svg" width="20px" height="30px" /></li>
            <li>
                <h1>SwaraNusa</h1>
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
                        <img src="gmbr_gnrl/usr.png" width="15px" height="15px" />
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="hero" id="home"
        style="background: url('gmbr_kontenjljh/<?= htmlspecialchars($konten['gambar']) ?>') center/cover no-repeat;">
    </section>

    <section class="isi">
        <div class="nama">
            <h1>
                <?= htmlspecialchars($konten['judul']) ?>
            </h1>
            <hr />
            <h3>
                <?= htmlspecialchars($konten['subjudul']) ?>
            </h3>
        </div>
        <div class="konten">
            <div class="informasi-umum">
                <h2>Informasi Umum</h2>
                <p>
                    <?= htmlspecialchars($konten['informasi_umum']) ?>
                </p>
            </div>
            <div class="sejarah">
                <h2>Sejarah
                    <?= htmlspecialchars($konten['judul']) ?>
                </h2>
                <p>
                    <?= htmlspecialchars($konten['sejarah']) ?>
                </p>
            </div>
            <div class="instrumen">
                <h2>Instrumen yang Digunakan</h2>
                <p>
                    <?= htmlspecialchars($konten['deskripsi']) ?>
                </p>
                <div class="instrumen-container">
                    <?php foreach ($instrumen_list as $instrumen): ?>
                        <div class="chip">
                            <?= htmlspecialchars(trim($instrumen)) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if (!empty($galeri_list)): ?>
                <div class="galeri-karawitan">
                    <h2>Galeri
                        <?= htmlspecialchars($konten['judul']) ?>
                    </h2>
                    <ul>
                        <?php foreach ($galeri_list as $i => $gambar): ?>
                            <li>
                                <div class="gambar<?= $i + 1 ?>">
                                    <img src="gmbr_kontenjljh/<?= htmlspecialchars(trim($gambar)) ?>"
                                        alt="Gambar <?= htmlspecialchars($konten['judul']) ?> <?= $i + 1 ?>" />
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="nilai-budaya">
                <h2>Nilai Budaya</h2>
                <p>
                    <?= htmlspecialchars($konten['nilai_budaya']) ?>
                </p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section brand">
                <h2 class="logo">
                    <img src="gmbr_gnrl/logoputih.svg" />
                    SwaraNusa
                </h2>
                <p>SwaraNusa menghadirkan literatur, foto, audio, dan video untuk membuka akses ke kekayaan musik
                    Indonesia dan mengapresiasi warisan budayanya.</p>
            </div>
            <div class="footer-section nav">
                <h2>Navigasi</h2>
                <ul>
                    <li><a href="landing.html">Beranda</a></li>
                    <li><a href="jelajahi.html">Jelajahi</a></li>
                    <li><a href="belajar.html">Belajar</a></li>
                    <li><a href="tentang.html">Tentang</a></li>
                </ul>
            </div>
            <div class="footer-section social">
                <h2>Ikuti Kami</h2>
                <div class="icons">
                    <a href="https://www.facebook.com/"><img src="gmbr_gnrl/fb.svg" alt="Facebook" /></a>
                    <a href="https://twitter.com/"><img src="gmbr_gnrl/twt.svg" alt="Twitter" /></a>
                    <a href="https://www.instagram.com/"><img src="gmbr_gnrl/ig.svg" alt="Instagram" /></a>
                </div>
            </div>
        </div>
        <hr />
        <div class="footer-bottom">
            <p>© 2025 SwaraNusa. All rights reserved. Made with <span class="heart">❤️</span> in Indonesia.</p>
        </div>
    </footer>
    <script src="burger.js"></script>
</body>

</html>