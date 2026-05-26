<?php
session_start();
require_once "koneksi.php";

if (!isset($_GET["id"])) {
  header("Location: belajar.php");
  exit;
}

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM konten_belajar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$konten = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$konten) {
  header("Location: belajar.php");
  exit;
}

if (isset($_SESSION["user_id"])) {
  $user_id = $_SESSION["user_id"];
  $konten_id = $konten["konten_id"];
  $dilihat_pada = date("Y-m-d H:i:s");

  $cek = $conn->prepare("SELECT id FROM histori WHERE user_id = ? AND konten_id = ? AND tipe = 'belajar'");
  $cek->bind_param("ii", $user_id, $konten_id);
  $cek->execute();
  $cek->store_result();

  if ($cek->num_rows > 0) {
    $update = $conn->prepare("UPDATE histori SET dilihat_pada = ? WHERE user_id = ? AND konten_id = ? AND tipe = 'belajar'");
    $update->bind_param("sii", $dilihat_pada, $user_id, $konten_id);
    $update->execute();
    $update->close();
  } else {
    $insert = $conn->prepare("INSERT INTO histori (user_id, konten_id, dilihat_pada, tipe) VALUES (?, ?, ?, 'belajar')");
    $insert->bind_param("iis", $user_id, $konten_id, $dilihat_pada);
    $insert->execute();
    $insert->close();
  }
  $cek->close();
}

$gambar_bagian_list = $konten['gambar_bagian'] ? explode(",", $konten['gambar_bagian']) : [];
$keterangan_bagian_list = $konten['keterangan_bagian'] ? explode("|", $konten['keterangan_bagian']) : [];
$audio_list = $konten['audio'] ? explode(",", $konten['audio']) : [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title><?= htmlspecialchars($konten['judul']) ?> - SwaraNusa</title>
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="konten_belajar.css" />
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
    <?php include 'navbar.php'; ?>
  </header>

  <section class="hero" id="home"
    style="background: url('gmbr_kontenbljr/<?= htmlspecialchars($konten['gambar']) ?>') center/cover no-repeat;">
  </section>

  <section class="isi">
    <div class="nama">
      <h1><?= htmlspecialchars($konten['judul']) ?></h1>
      <hr />
      <h3><?= htmlspecialchars($konten['daerah']) ?></h3>
    </div>
    <div class="konten">
      <div class="pengertian">
        <h2>Pengertian</h2>
        <p><?= htmlspecialchars($konten['pengertian']) ?></p>
      </div>
      <div class="ayo-belajar">
        <h2>Ayo Belajar!</h2>
        <p><?= htmlspecialchars($konten['cara_main']) ?></p>
      </div>
      <?php if (!empty($gambar_bagian_list)): ?>
        <h2>Tentang <?= htmlspecialchars($konten['judul']) ?></h2>
        <div class="tentang">
          <ul>
            <?php foreach ($gambar_bagian_list as $i => $gambar): ?>
              <li>
                <div class="gambar<?= $i + 1 ?>">
                  <img src="gmbr_kontenbljr/<?= htmlspecialchars(trim($gambar)) ?>"
                    alt="Gambar <?= htmlspecialchars($konten['judul']) ?> <?= $i + 1 ?>" />
                  <?php if (isset($keterangan_bagian_list[$i])): ?>
                    <p><?= htmlspecialchars(trim($keterangan_bagian_list[$i])) ?></p>
                  <?php endif; ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>

    <div class="audio-video">
      <?php if (!empty($audio_list)): ?>
        <div class="suara">
          <h2>Dengarkan Lantunan Suara <?= htmlspecialchars($konten['judul']) ?>!</h2>
          <?php foreach ($audio_list as $audio): ?>
            <div class="audio-wrapper">
              <audio controls>
                <source src="gmbr_kontenbljr/<?= htmlspecialchars(trim($audio)) ?>" type="audio/mpeg" />
                Your browser does not support the audio element.
              </audio>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if ($konten['video']): ?>
        <h2>Video Tutorial</h2>
        <div class="video">
          <video controls>
            <source src="gmbr_kontenbljr/<?= htmlspecialchars($konten['video']) ?>" type="video/mp4" />
            Your browser does not support the video tag.
          </video>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
</body>

</html>