<?php
require_once "../koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "user") {
  header("Location: /belajar_html/swaranusa_website/login.php");
  exit;
}

$user_id = $_SESSION["user_id"];
$tab = isset($_GET["tab"]) ? $_GET["tab"] : "jelajahi";

$stmt_jelajahi = $conn->prepare("
    SELECT j.id, j.judul, j.daerah, j.kategori, j.informasi_umum, j.gambar, h.dilihat_pada
    FROM histori h
    JOIN jelajahi j ON h.konten_id = j.id
    WHERE h.user_id = ? AND h.tipe = 'jelajahi'
    ORDER BY h.dilihat_pada DESC
");
$stmt_jelajahi->bind_param("i", $user_id);
$stmt_jelajahi->execute();
$histori_jelajahi = $stmt_jelajahi->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_jelajahi->close();

$stmt_belajar = $conn->prepare("
    SELECT b.id, b.judul, b.daerah, b.kategori, b.pengertian, b.gambar, h.dilihat_pada
    FROM histori h
    JOIN belajar b ON h.konten_id = b.konten_id
    WHERE h.user_id = ? AND h.tipe = 'belajar'
    ORDER BY h.dilihat_pada DESC
");
$stmt_belajar->bind_param("i", $user_id);
$stmt_belajar->execute();
$histori_belajar = $stmt_belajar->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_belajar->close();

function waktu_lalu($datetime)
{
  $sekarang = new DateTime();
  $dilihat = new DateTime($datetime);
  $selisih = $sekarang->diff($dilihat);

  if ($selisih->days == 0)
    return "Hari ini";
  if ($selisih->days == 1)
    return "1 hari lalu";
  if ($selisih->days < 7)
    return $selisih->days . " hari lalu";
  if ($selisih->days < 30)
    return floor($selisih->days / 7) . " minggu lalu";
  return floor($selisih->days / 30) . " bulan lalu";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Histori</title>
  <link rel="stylesheet" href="../navbar.css" />
  <link rel="stylesheet" href="histori_user.css" />
</head>

<body>
  <main class="main-content">
    <header>
      <ul class="logo-navbar">
        <li><img src="../gmbr_gnrl/logo.svg" width="20px" height="30px" /></li>
        <li>
          <h1>SwaraNusa</h1>
        </li>
      </ul>
      <div class="hamburger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </div>
      <?php include '../navbar.php'; ?>
    </header>

    <section class="content-area">
      <h1>Histori</h1>
      <div class="tab">
        <a href="histori_user.php?tab=jelajahi" class="tab-btn <?= $tab === 'jelajahi' ? 'active' : '' ?>">Jelajahi</a>
        <a href="histori_user.php?tab=belajar" class="tab-btn <?= $tab === 'belajar' ? 'active' : '' ?>">Belajar</a>
      </div>

      <div class="cards-container">
        <?php if ($tab === 'jelajahi'): ?>
          <?php if (empty($histori_jelajahi)): ?>
            <p>Belum ada histori jelajahi.</p>
          <?php else: ?>
            <?php foreach ($histori_jelajahi as $item): ?>
              <div class="card">
                <img src="../gmbr_kontenjljh/<?= htmlspecialchars($item["gambar"]) ?>"
                  alt="<?= htmlspecialchars($item["judul"]) ?>" />
                <div class="card-content">
                  <div class="card-top">
                    <h3><?= htmlspecialchars($item["judul"]) ?></h3>
                    <p><?= htmlspecialchars($item["kategori"]) ?> • <?= waktu_lalu($item["dilihat_pada"]) ?></p>
                    <p><?= htmlspecialchars($item["informasi_umum"]) ?></p>
                  </div>
                  <div class="card-bottom">
                    <p><?= htmlspecialchars($item["daerah"]) ?></p>
                    <a href="../konten_jelajahi.php?id=<?= $item['id'] ?>" class="btn-pelajari">Pelajari</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php else: ?>
          <?php if (empty($histori_belajar)): ?>
            <p>Belum ada histori belajar.</p>
          <?php else: ?>
            <?php foreach ($histori_belajar as $item): ?>
              <div class="card">
                <img src="../gmbr_kontenbljr/<?= htmlspecialchars($item["gambar"]) ?>"
                  alt="<?= htmlspecialchars($item["judul"]) ?>" />
                <div class="card-content">
                  <div class="card-top">
                    <h3><?= htmlspecialchars($item["judul"]) ?></h3>
                    <p><?= htmlspecialchars($item["kategori"]) ?> • <?= waktu_lalu($item["dilihat_pada"]) ?></p>
                    <p><?= htmlspecialchars($item["pengertian"]) ?></p>
                  </div>
                  <div class="card-bottom">
                    <p><?= htmlspecialchars($item["daerah"]) ?></p>
                    <a href="../konten_belajar.php?id=<?= $item['id'] ?>" class="btn-pelajari">Pelajari</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
    function toggleMenu() {
      const nav = document.getElementById("navMenu");
      const hamburger = document.querySelector(".hamburger");
      nav.classList.toggle("active");
      hamburger.classList.toggle("active");
    }

    function closeMenu() {
      const nav = document.getElementById("navMenu");
      const hamburger = document.querySelector(".hamburger");
      nav.classList.remove("active");
      hamburger.classList.remove("active");
    }

    document.addEventListener("click", function (event) {
      const nav = document.getElementById("navMenu");
      const hamburger = document.querySelector(".hamburger");
      const isClickInsideNav = nav.contains(event.target);
      const isClickOnHamburger = hamburger.contains(event.target);
      if (!isClickInsideNav && !isClickOnHamburger && nav.classList.contains("active")) {
        closeMenu();
      }
    });
  </script>
  <script src="../navbar.js"></script>
</body>

</html>