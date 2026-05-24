<!DOCTYPE html>
<html lang="id">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title>Belajar SwaraNusa</title>
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="jelajahi.css" />
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

  <section class="hero">
    <h2>Jelajahi Musik & Alat Musik Nusantara</h2>
    <p>
      Temukan koleksi musik tradisional, pelajari asal-usulnya, dan pelajari
      cara memainkannya lewat notasi, audio, dan video.
    </p>
    <div class="search-filter">
      <div class="search-bar">
        <img src="gmbr_jljh/search.svg" />
        <input id="search-input" type="search" placeholder="Cari judul, daerah, atau alat musik..." />
      </div>
      <div class="filter">
        <button class="dropdown-btn" id="dropdownBtn">Semua Daerah</button>
        <div class="dropdown-menu" id="dropdownMenu">
          <div class="dropdown-item">Semua Daerah</div>
          <div class="dropdown-item">Jawa</div>
          <div class="dropdown-item">Sumatra</div>
          <div class="dropdown-item">Sulawesi</div>
          <div class="dropdown-item">Kalimantan</div>
          <div class="dropdown-item">Papua</div>
        </div>
      </div>
    </div>
  </section>

  <section class="isi">
    <div class="container">
      <div class="grid" id="card-grid">
        <div class="card" data-title="karawitan" data-region="jawa">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Karawitan.png" />
            <div class="region-tag">Jawa Tengah</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Karawitan</h3>
            <p class="card-description">Seni musik Jawa Tengah</p>
            <a href="konten_jelajahi.php?id=4">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="keroncong" data-region="jawa">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Keroncong.png" />
            <div class="region-tag">Jawa Barat</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Keroncong</h3>
            <p class="card-description">Seni musik Jawa Barat</p>
            <a href="konten_jelajahi.php?id=5">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="panting" data-region="kalimantan">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Panting.png" />
            <div class="region-tag">Kalimantan Selatan</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Panting</h3>
            <p class="card-description">Seni musik Kalimantan Selatan</p>
            <a href="konten_jelajahi.php?id=6">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="angklung reog" data-region="jawa">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Angklung Reog.png" />
            <div class="region-tag">Jawa Timur</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Angklung Reog</h3>
            <p class="card-description">Seni musik Jawa Timur</p>
            <a href="konten_jelajahi.php?id=7">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="gamelan" data-region="jawa">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Gamelan.jpg" />
            <div class="region-tag">Jawa Tengah</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Gamelan</h3>
            <p class="card-description">Ansambel musik Jawa Tengah</p>
            <a href="konten_jelajahi.php?id=1">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="sasando" data-region="ntt">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Sasando.png" />
            <div class="region-tag">NTT</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Sasando</h3>
            <p class="card-description">Ansambel musik NTT</p>
            <a href="konten_jelajahi.php?id=3">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="kolintang" data-region="sulawesi">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Kolintang.png" />
            <div class="region-tag">Sulawesi Utara</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Kolintang</h3>
            <p class="card-description">Musik Sulawesi Utara</p>
            <a href="konten_jelajahi.php?id=8">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="angklung" data-region="jawa">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Angklung.jpg" />
            <div class="region-tag">Jawa Barat</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Angklung</h3>
            <p class="card-description">Ansambel musik Jawa Barat</p>
            <a href="konten_jelajahi.php?id=2">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="tifa" data-region="papua">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Tifa.png" />
            <div class="region-tag">Papua</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Tifa</h3>
            <p class="card-description">Alat musik Papua</p>
            <a href="konten_jelajahi.php?id=9">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="gambus" data-region="kalimantan">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Gambus.png" />
            <div class="region-tag">Kalimantan Timur</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Gambus</h3>
            <p class="card-description">Alat musik Kalimantan Timur</p>
            <a href="konten_jelajahi.php?id=10">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="sape" data-region="kalimantan">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Sape.png" />
            <div class="region-tag">Kalimantan Timur</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Sape</h3>
            <p class="card-description">Alat musik Kalimantan Timur</p>
            <a href="konten_jelajahi.php?id=11">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>

        <div class="card" data-title="gendang" data-region="jawa">
          <div class="image-wrapper">
            <img src="gmbr_jljh/Gambar Gendang.png" />
            <div class="region-tag">Jawa Barat</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">Gendang</h3>
            <p class="card-description">Alat musik Jawa Barat</p>
            <a href="konten_jelajahi.php?id=12">
              <button class="btn-learn">Pelajari</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
  <script src="jelajahi.js"></script>
</body>

</html>