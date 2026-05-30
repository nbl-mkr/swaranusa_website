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
            <p>Sasando berasal dari Pulau Rote, Nusa Tenggara Timur yang memiliki suara khas. Alat musik ini memiliki
              bentuk unik yang dimainkan dengan cara dipetik dan berasal dari NTT.</p>
          </div>
          <div class="card-bottom">
            <p>Nusa Tenggara Timur</p>
            <a href="konten_belajar.php" class="btn-pelajari">Pelajari</a>
          </div>
        </div>
      </div>
      <div class="card">
        <img src="assets/gendang.png" alt="Gendang" />
        <div class="card-content">
          <div class="card-top">
            <h3>Gendang</h3>
            <p>Alat Musik Pukul • 2 hari lalu</p>
            <p>Gendang adalah alat musik yang terbuat dari kayu berongga dengan bagian rongga yang ditutup kulit dan
              digunakan dalam ansambel. Gendang merupakan alat musik yang berasal dari Jawa Barat.</p>
          </div>
          <div class="card-bottom">
            <p>Jawa Barat</p>
            <a href="konten_belajar.php" class="btn-pelajari">Pelajari</a>
          </div>
        </div>
      </div>
      <div class="card">
        <img src="assets/kecapi.png" alt="Kecapi" />
        <div class="card-content">
          <div class="card-top">
            <h3>Kecapi</h3>
            <p>Alat Musik Petik • 2 hari lalu</p>
            <p>Kecapi merupakan alat musik yang dimainkan dengan cara dipetik, biasanya digunakan dalam pertunjukan
              musik dan upacara adat. Alat musik ini berasal dari Jawa Barat.</p>
          </div>
          <div class="card-bottom">
            <p>Jawa Barat</p>
            <a href="konten_belajar.php" class="btn-pelajari">Pelajari</a>
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