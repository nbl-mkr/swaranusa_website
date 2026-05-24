<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Landing Page</title>
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
          <a href="konten_jelajahi.php">
            <div class="img-wrapper">
              <img src="assets/original-hero/gambar-kolintang.png" alt="Gambar Kolintang" />
              <div class="img-overlay">
                <h3>Kolintang</h3>
                <p>Sulawesi Utara</p>
              </div>
            </div>
          </a>

          <div class="top-right">
            <a href="konten_jelajahi.php">
              <div class="img-wrapper">
                <img src="assets/original-hero/gambar-sape.png" alt="Gambar Sape" />
                <div class="img-overlay">
                  <h3>Sape</h3>
                  <p>Kalimantan Timur</p>
                </div>
              </div>
            </a>
            <a href="konten_jelajahi.php">
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
          <div class="img-wrapper">
            <img src="assets/original-hero/gambar-angklung.jpg" alt="Gambar Angklung" />
            <div class="img-overlay">
              <h3>Angklung</h3>
              <p>Jawa Barat</p>
            </div>
          </div>

          <div class="bottom-container">
            <div class="bottom-right-top">
              <div class="img-wrapper">
                <img src="assets/original-hero/gambar-rebab.png" alt="Gambar Rebab" />
                <div class="img-overlay">
                  <h3>Rebab</h3>
                  <p>Jawa Barat</p>
                </div>
              </div>
              <div class="img-wrapper">
                <img src="assets/original-hero/gambar-gamelan.jpg" alt="Gambar Gamelan" />
                <div class="img-overlay">
                  <h3>Gamelan</h3>
                  <p>Jawa Tengah</p>
                </div>
              </div>
            </div>
            <div class="img-wrapper">
              <img src="assets/original-hero/gambar-tifa.png" alt="Gambar Tifa" />
              <div class="img-overlay">
                <h3>Tifa</h3>
                <p>Papua</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section" id="pelajari">
    <h3>Pelajari Sekarang!</h3>
    <div class="pelajari-cards">
      <div class="pelajari-card">
        <div class="pelajari-left">
          <img src="assets/sasando.png" alt="Sasando image" />
        </div>
        <div class="pelajari-right">
          <h4>Sasando</h4>
          <p>Alat musik tradisional NTT - 2 hari lalu</p>
          <p>
            Sasando berasal dari Pulau Rote, Nusa Tenggara Timur yang memiliki
            suara khas. Alat musik ini memiliki bentuk unik yang dimainkan
            dengan cara dipetik dan berasal dari NTT.
          </p>
        </div>
      </div>
      <div class="pelajari-card">
        <div class="pelajari-left">
          <img src="assets/gendang.png" alt="Gendang image" />
        </div>
        <div class="pelajari-right">
          <h4>Gendang</h4>
          <p>Alat musik tradisional Jawa Barat - 2 hari lalu</p>
          <p>
            Gendang adalah alat musik yang terbuat dari kayu berongga dengan
            bagian rongga yang ditutup kulit dan digunakan dalam ansambel.
            Gendang merupakan alat musik yang berasal dari Jawa Barat.
          </p>
        </div>
      </div>
      <div class="pelajari-card">
        <div class="pelajari-left">
          <img src="assets/kecapi.png" alt="Kecapi image" />
        </div>
        <div class="pelajari-right">
          <h4>Kecapi</h4>
          <p>Alat musik tradisional Jawa Barat - 2 hari lalu</p>
          <p>
            Kecapi merupakan alat musik yang dimainkan dengan cara dipetik,
            biasanya digunakan dalam pertunjukan musik dan upacara adat. Alat
            musik ini berasal dari Jawa Barat.
          </p>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
</body>

</html>