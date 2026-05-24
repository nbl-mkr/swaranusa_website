<!DOCTYPE html>
<html lang="id">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title>Halaman Belajar SwaraNusa</title>
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="belajar.css" />
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

    <?php include 'navbar.php'; ?>
  </header>

  <section class="hero" id="home">
    <h2>Belajar Musik Tradisional Nusantara</h2>
    <p>
      Pilih instrumen favoritmu dan ikuti pembelajaran lengkap dengan notasi,
      audio, dan video interaktif. Dibuat dengan desain elegan agar belajar jadi
      pengalaman menyenangkan.
    </p>
  </section>

  <div class="container">
    <div class="card">
      <img src="gmbr_bljr/kolintang.png" alt="Kolintang" />
      <div class="card-content">
        <h3>Kolintang</h3>
        <p>
          Pelajari harmoni kolintang, mulai dari laras, pola ketukan, hingga
          kolaborasi antar-instrumen.
        </p>
        <div class="progress-bar">
          <div class="progress"></div>
        </div>
        <a href="konten_belajar.php"><button class="btn">Pelajari</button>
        </a>
      </div>
    </div>

    <div class="card">
      <div class="card-content">
        <h3>Angklung</h3>
        <p>
          Pelajari teknik goyang angklung, harmoni ansambel, dan repertoar
          angklung modern dengan cara yang menyenangkan.
        </p>
        <div class="progress-bar">
          <div class="progress" style="width: 65%"></div>
        </div>
        <a href="konten_belajar.php"><button class="btn">Pelajari</button>
        </a>
      </div>
      <img src="gmbr_bljr/angklung.jpg" alt="Angklung" />
    </div>

    <div class="card">
      <img src="gmbr_bljr/sasando.png" alt="Sasando" />
      <div class="card-content">
        <h3>Sasando</h3>
        <p>
          Kuasai teknik petikan dan irama khas dari alat musik petik
          tradisional Sasando yang unik.
        </p>
        <div class="progress-bar">
          <div class="progress" style="width: 20%"></div>
        </div>
        <a href="konten_belajar.php"><button class="btn">Pelajari</button>
        </a>
      </div>
    </div>

    <div class="card">
      <div class="card-content">
        <h3>Gamelan</h3>
        <p>
          Pelajari harmoni gamelan Jawa, mulai dari laras, pola tabuhan,
          hingga ansambel instrumen.
        </p>
        <div class="progress-bar">
          <div class="progress" style="width: 60%"></div>
        </div>
        <a href="konten_belajar.php"><button class="btn">Pelajari</button>
        </a>
      </div>
      <img src="gmbr_bljr/gamelan.jpg" alt="Gamelan" />
    </div>
  </div>

  <div class="cta">
    <h3>Jadilah Bagian dari Generasi Pelestari</h3>
    <p>Tingkatkan kemampuanmu dan sebarkan semangat musik Nusantara.</p>
    <a href="https://forms.gle/F8HyB5yAnEKz9Rvz8"><button>Gabung</button></a>
  </div>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
</body>

</html>