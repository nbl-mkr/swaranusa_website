<?php require_once "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Beranda SwaraNusa</title>
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="landing.css" />
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

    <!-- Hamburger -->
    <div class="hamburger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <?php include 'navbar.php'; ?>
  </header>
  <section class="hero" id="home">
    <div class="hero-left">
      <h2>SwaraNusa</h2>
      <p>
        Platform Pembelajaran seni musik tradisional yang menyediakan media
        literatur, audio, dan video.
      </p>
      <a href="belajar.php"> <button>Ayo Belajar!</button></a>
    </div>
    <div class="hero-right">
      <img src="assets/hero.png" alt="Hero image" />
    </div>
  </section>
  <section class="section" id="populer">
    <div class="populer-minggu-ini">
      <h3>Populer Minggu Ini</h3>
      <div class="populer-container">
        <div class="populer-top">
          <a href="konten_jelajahi.php?id=8">
            <div class="img-wrapper">
              <img src="assets/original-hero/gambar-kolintang.png" alt="Gambar Kolintang" />
              <div class="img-overlay">
                <h3>Kolintang</h3>
                <p>Sulawesi Utara</p>
              </div>
            </div>
          </a>

          <div class="top-right">
            <a href="konten_jelajahi.php?id=11">
              <div class="img-wrapper">
                <img src="assets/original-hero/gambar-sape.png" alt="Gambar Sape" />
                <div class="img-overlay">
                  <h3>Sape</h3>
                  <p>Kalimantan Timur</p>
                </div>
              </div>
            </a>
            <a href="konten_jelajahi.php?id=10">
              <div class="img-wrapper">
                <img src="assets/original-hero/gambar-gambus.png" alt="Gambar Gambus" />
                <div class="img-overlay">
                  <h3>Gambus</h3>
                  <p>Kalimantan Timur</p>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="populer-bottom">
          <a href="konten_jelajahi.php?id=2">
            <div class="img-wrapper">
              <img src="assets/original-hero/gambar-angklung.jpg" alt="Gambar Angklung" />
              <div class="img-overlay">
                <h3>Angklung</h3>
                <p>Jawa Barat</p>
              </div>
            </div>
          </a>

          <div class="bottom-container">
            <div class="bottom-right-top">
              <a href="konten_jelajahi.php?id=4">
                <div class="img-wrapper">
                  <img src="assets/original-hero/gambar-karawitan.png" alt="Gambar Karawitan" />
                  <div class="img-overlay">
                    <h3>Karawitan</h3>
                    <p>Jawa Tengah</p>
                  </div>
                </div>
              </a>
              <a href="konten_jelajahi.php?id=1">
                <div class="img-wrapper">
                  <img src="assets/original-hero/gambar-gamelan.jpg" alt="Gambar Gamelan" />
                  <div class="img-overlay">
                    <h3>Gamelan</h3>
                    <p>Jawa Tengah</p>
                  </div>
                </div>
              </a>
            </div>
            <a href="konten_jelajahi.php?id=9">
              <div class="img-wrapper">
                <img src="assets/original-hero/gambar-tifa.png" alt="Gambar Tifa" />
                <div class="img-overlay">
                  <h3>Tifa</h3>
                  <p>Papua</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section" id="pelajari">
    <h3>Pelajari Sekarang!</h3>
    <div class="pelajari-cards">
      <div class="card">
        <img src="assets/sasando.png" alt="Sasando" />
        <div class="card-content">
          <div class="card-top">
            <h3>Sasando</h3>
            <p>Alat Musik Petik • 2 hari lalu</p>
            <p>Sasando adalah alat musik petik tradisional yang berasal dari Pulau Rote, Nusa Tenggara Timur. Alat musik
              ini terbuat dari bambu sebagai resonator utama yang dikelilingi daun lontar berbentuk setengah lingkaran,
              dengan senar-senar yang dipetik untuk menghasilkan bunyi. Sasando memiliki suara yang khas, lembut, dan
              merdu sehingga sering disebut harpa dari Timur.</p>
          </div>
          <div class="card-bottom">
            <p>Nusa Tenggara Timur</p>
            <a href="konten_belajar.php" class="btn-pelajari">Detail</a>
          </div>
        </div>
      </div>
      <div class="card">
        <img src="assets/gendang.png" alt="Gendang" />
        <div class="card-content">
          <div class="card-top">
            <h3>Gendang</h3>
            <p>Alat Musik Pukul • 2 hari lalu</p>
            <p>Gendang adalah alat musik membranofon tradisional yang terbuat dari kayu berongga dengan bagian ujungnya
              ditutup kulit binatang. Alat musik ini berfungsi sebagai pengatur irama dan tempo dalam ansambel musik
              tradisional Sunda dan Jawa. Gendang dimainkan dengan cara dipukul menggunakan telapak tangan atau stik
              kayu.</p>
          </div>
          <div class="card-bottom">
            <p>Jawa Barat</p>
            <a href="konten_belajar.php" class="btn-pelajari">Detail</a>
          </div>
        </div>
      </div>
      <div class="card">
        <img src="assets/keroncong.png" alt="Keroncong" />
        <div class="card-content">
          <div class="card-top">
            <h3>Keroncong</h3>
            <p>Ansambel • 2 hari lalu</p>
            <p>Keroncong merupakan genre musik asli Indonesia yang berkembang dari pengaruh musik Portugis pada abad
              ke-16. Musik ini ditandai dengan penggunaan ukulele, cello, biola, seruling, dan vokal yang khas.
              Keroncong memiliki karakter melodi yang lembut dan syahdu, sering dimainkan dalam pertunjukan budaya dan
              perayaan nasional.</p>
          </div>
          <div class="card-bottom">
            <p>Jawa Barat</p>
            <a href="konten_belajar.php" class="btn-pelajari">Detail</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
  <script src="navbar.js"></script>
</body>

</html>