<?php
session_start();
require_once "koneksi.php";

if (isset($_SESSION["user_id"])) {
  $user_id = $_SESSION["user_id"];
  $konten_id = 4;
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
  <title>Belajar SwaraNusa</title>
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

  <section class="hero" id="home" style="background: url('gmbr_kontenjljh/heroKarawitan.png') center/cover no-repeat;">
  </section>

  <section class="isi">
    <div class="nama">
      <h1>Karawitan</h1>
      <hr />
      <h3>Seni Musik dari Jawa Barat</h3>
    </div>
    <div class="konten">
      <div class="informasi-umum">
        <h2>Informasi Umum</h2>
        <p>
          Karawitan adalah seni pertunjukan musik tradisional Jawa yang terdiri
          dari ansambel gamelan, vokal sindhen, dan berbagai instrumen pengiring.
          Tradisi ini diwariskan secara turun-temurun dan memiliki peran penting dalam
          upacara adat, pertunjukan tari, hingga wayang kulit.
        </p>
      </div>
      <div class="sejarah">
        <h2>Sejarah Karawitan</h2>
        <p>
          Sejarah karawitan berakar pada perkembangan budaya Jawa sejak abad
          ke-8 hingga masa kerajaan Mataram. Karawitan awalnya berkembang
          dalam lingkungan keraton sebagai musik istana, kemudian menyebar ke
          masyarakat luas melalui tradisi wayang, upacara adat, dan pertunjukan
          rakyat. Hingga kini, karawitan tetap menjadi simbol identitas budaya
          Jawa yang diajarkan di sanggar, sekolah, dan perguruan tinggi seni.
        </p>
      </div>
      <div class="instrumen">
        <h2>Instrumen yang Digunakan</h2>
        <p>
          Ansambel karawitan biasanya menggunakan seperangkat gamelan lengkap
          yang terdiri dari instrumen pukul, gesek, petik, dan vokal.
        </p>
        <div class="instrumen-container">
          <div class="chip">Bonang</div>
          <div class="chip">Gender</div>
          <div class="chip">Gong</div>
          <div class="chip">Kenong</div>
          <div class="chip">Saron</div>
        </div>
      </div>

      <div class="galeri-karawitan">
        <h2>Galeri Karawitan</h2>
        <ul>
          <li>
            <div class="gambar1">
              <img src="gmbr_kontenjljh/karawitan 1.png" alt="Gambar Karawitan 1" />
            </div>
          </li>
          <li>
            <div class="gambar2">
              <img src="gmbr_kontenjljh/karawitan2.png" alt="Gambar Karawitan 2" />
            </div>
          </li>
          <li>
            <div class="gambar3">
              <img src="gmbr_kontenjljh/karawitan3.png" alt="Gambar Karawitan 3" />
            </div>
          </li>
        </ul>
      </div>
      <div class="nilai-budaya">
        <h2>Nilai Budaya</h2>
        <p>
          Karawitan menjadi sarana pendidikan nilai-nilai budaya Jawa, seperti
          gotong royong dalam permainan ansambel, disiplin dalam mengikuti
          tempo, dan rasa hormat terhadap tradisi. Hingga kini, karawitan
          tetap dipentaskan sebagai bentuk pelestarian budaya sekaligus
          hiburan yang mendidik.
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