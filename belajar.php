<?php
require_once "koneksi.php";

$konten_list = $conn->query("SELECT * FROM belajar ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
?>
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
    <?php foreach ($konten_list as $i => $konten): ?>
      <div class="card">
        <?php if ($i % 2 === 0): ?>
          <img src="gmbr_kontenbljr/<?= htmlspecialchars($konten['gambar']) ?>"
            alt="<?= htmlspecialchars($konten['judul']) ?>" />
          <div class="card-content">
            <h3><?= htmlspecialchars($konten['judul']) ?></h3>
            <p><?= htmlspecialchars($konten['pengertian']) ?></p>
            <div class="progress-bar">
              <div class="progress"></div>
            </div>
            <a href="konten_belajar.php?id=<?= $konten['id'] ?>"><button class="btn">Pelajari</button></a>
          </div>
        <?php else: ?>
          <div class="card-content">
            <h3><?= htmlspecialchars($konten['judul']) ?></h3>
            <p><?= htmlspecialchars($konten['pengertian']) ?></p>
            <div class="progress-bar">
              <div class="progress"></div>
            </div>
            <a href="konten_belajar.php?id=<?= $konten['id'] ?>"><button class="btn">Pelajari</button></a>
          </div>
          <img src="gmbr_kontenbljr/<?= htmlspecialchars($konten['gambar']) ?>"
            alt="<?= htmlspecialchars($konten['judul']) ?>" />
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="cta">
    <h3>Jadilah Bagian dari Generasi Pelestari</h3>
    <p>Tingkatkan kemampuanmu dan sebarkan semangat musik Nusantara.</p>
    <a href="https://forms.gle/F8HyB5yAnEKz9Rvz8"><button>Gabung</button></a>
  </div>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
  <script src="navbar.js"></script>
</body>

</html>