<?php
session_start();
require_once "koneksi.php";

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $konten_id = 3;
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>Sasando - SwaraNusa</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="konten_jelajahi.css" />
</head>

<body>
    <header>
        <ul class="logo-navbar">
            <li>
                <img src="gmbr_gnrl/logo.svg" width="20px" height="30px" />
            </li>
            <li>
                <h1>SwaraNusa</h1>
            </li>
        </ul>

        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
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

    <section class="hero" id="home" style="background: url('gmbr_kontenjljh/heroSasando.png') center/cover no-repeat;">
    </section>

    <section class="isi">
        <div class="nama">
            <h1>Sasando</h1>
            <hr />
            <h3>Seni Musik dari Nusa Tenggara Timur</h3>
        </div>
        <div class="konten">
            <div class="informasi-umum">
                <h2>Informasi Umum</h2>
                <p>
                    Sasando adalah alat musik petik tradisional yang berasal dari Pulau Rote,
                    Nusa Tenggara Timur. Alat musik ini terbuat dari bambu sebagai resonator
                    utama yang dikelilingi daun lontar berbentuk setengah lingkaran, dengan
                    senar-senar yang dipetik untuk menghasilkan bunyi. Sasando memiliki suara
                    yang khas, lembut, dan merdu sehingga sering disebut harpa dari Timur.
                </p>
            </div>
            <div class="sejarah">
                <h2>Sejarah Sasando</h2>
                <p>
                    Sasando diperkirakan sudah ada sejak abad ke-7 dan berasal dari tradisi
                    masyarakat Pulau Rote yang menggunakan daun lontar dalam kehidupan sehari-hari.
                    Menurut legenda setempat, sasando pertama kali diciptakan oleh seorang pemuda
                    bernama Sangguana yang terinspirasi dari mimpinya. Kini sasando menjadi simbol
                    kebanggaan budaya NTT dan terus dikembangkan oleh para seniman lokal maupun nasional.
                </p>
            </div>
            <div class="instrumen">
                <h2>Instrumen yang Digunakan</h2>
                <p>
                    Sasando dimainkan sebagai instrumen solo maupun pengiring vokal dalam
                    musik tradisional masyarakat Rote dan NTT.
                </p>
                <div class="instrumen-container">
                    <div class="chip">Sasando Gong</div>
                    <div class="chip">Sasando Biola</div>
                    <div class="chip">Sasando Elektrik</div>
                    <div class="chip">Senar Melodi</div>
                    <div class="chip">Daun Lontar</div>
                </div>
            </div>

            <div class="galeri-karawitan">
                <h2>Galeri Sasando</h2>
                <ul>
                    <li>
                        <div class="gambar1">
                            <img src="gmbr_kontenjljh/karawitan 1.png" alt="Gambar Sasando 1" />
                        </div>
                    </li>
                    <li>
                        <div class="gambar2">
                            <img src="gmbr_kontenjljh/karawitan2.png" alt="Gambar Sasando 2" />
                        </div>
                    </li>
                    <li>
                        <div class="gambar3">
                            <img src="gmbr_kontenjljh/karawitan3.png" alt="Gambar Sasando 3" />
                        </div>
                    </li>
                </ul>
            </div>
            <div class="nilai-budaya">
                <h2>Nilai Budaya</h2>
                <p>
                    Sasando merupakan cerminan kearifan lokal masyarakat Rote dalam memanfaatkan
                    alam sekitar, khususnya pohon lontar yang menjadi bagian tak terpisahkan dari
                    kehidupan mereka. Melalui sasando, nilai penghargaan terhadap alam dan warisan
                    leluhur terus diwariskan kepada generasi muda sebagai identitas budaya yang
                    harus dijaga dan dilestarikan.
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
                <p>
                    SwaraNusa menghadirkan literatur, foto, audio, dan video untuk
                    membuka akses ke kekayaan musik Indonesia dan mengapresiasi warisan
                    budayanya.
                </p>
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
            <p>
                © 2025 SwaraNusa. All rights reserved. Made with
                <span class="heart">❤️</span> in Indonesia.
            </p>
        </div>
    </footer>
    <script src="burger.js"></script>
</body>

</html>