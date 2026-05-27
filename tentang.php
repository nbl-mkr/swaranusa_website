<?php require_once "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title>Halaman Tentang SwaraNusa</title>
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="tentang.css" />
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
    <h2>Tentang SwaraNusa</h2>
    <p>
      Menghadirkan literatur, foto, audio, dan video untuk membuka akses ke
      kekayaan musik Indonesia dan mengapresiasi warisan budayanya.
    </p>
  </section>

  <section class="isi">
    <div class="Cerita">
      <ul id="horizontal">
        <li>
          <h3>Cerita Kami</h3>
          <ul>
            <li>
              <p>
                <b>Misi</b> kami adalah membuka akses seluas- <br />
                luasnya ke kekayaan musik tradisional <br />
                Indonesia. Kami ingin siapa pun, dari mana <br />
                pun, bisa belajar, menikmati, dan mendalami <br />
                musik ini.
              </p>
              <br />

              <p>
                <b>Visi</b> kami adalah menjadikan musik Indonesia
                <br />
                dikenal dan dihargai di seluruh dunia. Karena <br />
                itu, kami berkomitmen menjadi jembatan <br />
                antara para pelajar dan pengajar ahli, agar <br />
                tradisi musik kita terus hidup dan <br />
                berkembang.
              </p>
              <br />

              <p>
                <b>Berdiri</b> sejak 2025, SwaraNusa didirikan oleh
                <br />
                musisi dan pendidik yang punya semangat <br />
                besar untuk berbagi ilmu. Dari situ, tumbuh <br />
                sebuah komunitas belajar yang aktif dan <br />
                mendukung satu sama lain.
              </p>
            </li>
          </ul>
        </li>
        <li>
          <img src="gmbr_kontak/014145900_1496725240-Bekerja2 1.png" alt="" />
        </li>
      </ul>
    </div>

    <h3 id="text">Mengapa Memilih SwaraNusa?</h3>
    <div class="daftar-fitur">
      <div class="fitur">
        <div class="ikon musik"><img src="gmbr_kontak/Overlay.svg" /></div>
        <div class="teks">
          <h3>Instruktur Berpengalaman</h3>
          <p>
            Belajar langsung dengan musisi yang ahli dan peduli dengan musik
            tradisional Indonesia.
          </p>
        </div>
      </div>

      <div class="fitur">
        <div class="ikon komunitas">
          <img src="gmbr_kontak/Overlay-1.svg" />
        </div>
        <div class="teks">
          <h3>Komunitas yang Mendukung</h3>
          <p>
            Bergabung dengan komunitas pelajar dan pengajar yang saling
            semangat.
          </p>
        </div>
      </div>

      <div class="fitur">
        <div class="ikon buku"><img src="gmbr_kontak/Overlay-2.svg" /></div>
        <div class="teks">
          <h3>Kurikulum Lengkap</h3>
          <p>
            Materi belajar mencakup berbagai alat musik, gaya, dan tingkatan
            kemampuan.
          </p>
        </div>
      </div>

      <div class="fitur">
        <div class="ikon dunia"><img src="gmbr_kontak/Overlay-3.svg" /></div>
        <div class="teks">
          <h3>Belajar dari Mana Saja</h3>
          <p>
            Akses materi fleksibel, pelajari kapan saja sesuai kebutuhanmu.
          </p>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
  <script src="navbar.js"></script>
</body>

</html>