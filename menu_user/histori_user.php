<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "user") {
  header("Location: /belajar_html/swaranusa_website/login.php");
  exit;
}
require_once "../koneksi.php";

$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("
    SELECT k.id, k.judul, k.daerah, k.kategori, k.deskripsi, k.gambar, h.dilihat_pada
    FROM histori h
    JOIN konten k ON h.konten_id = k.id
    WHERE h.user_id = ?
    ORDER BY h.dilihat_pada DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$histori_list = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

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
  <title>Menu - Histori</title>
  <link rel="stylesheet" href="../navbar.css" />
  <link rel="stylesheet" href="histori_user.css" />
</head>

<body>
  <div class="menu-container">
    <div class="left-side">
      <div class="logo-text">
        <img src="../assets/logo_white.png" alt="Logo SwaraNusa" />
        <h1>SwaraNusa</h1>
      </div>
      <?php include 'sidebar_user.php'; ?>
    </div>

    <main class="main-content">
      <header>
        <ul class="logo-navbar">
          <li></li>
          <li>
            <h1></h1>
          </li>
        </ul>
        <div class="hamburger" onclick="toggleMenu()">
          <span></span><span></span><span></span>
        </div>
        <?php include '../navbar_menu_user.php'; ?>
      </header>

      <section class="content-area">
        <h1>Histori</h1>
        <div class="cards-container">
          <?php if (empty($histori_list)): ?>
            <p>Belum ada histori.</p>
          <?php else: ?>
            <?php foreach ($histori_list as $item): ?>
              <div class="card">
                <img src="../gmbr_kontenjljh/<?= htmlspecialchars($item["gambar"]) ?>"
                  alt="<?= htmlspecialchars($item["judul"]) ?>" />
                <div class="card-content">
                  <div class="card-top">
                    <h3><?= htmlspecialchars($item["judul"]) ?></h3>
                    <p><?= htmlspecialchars($item["kategori"]) ?> • <?= waktu_lalu($item["dilihat_pada"]) ?></p>
                    <p><?= htmlspecialchars($item["deskripsi"]) ?></p>
                  </div>
                  <div class="card-bottom">
                    <p><?= htmlspecialchars($item["daerah"]) ?></p>
                    <a href="../konten_jelajahi.php?id=<?= $item['id'] ?>" class="btn-pelajari">Pelajari</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>

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
</body>

</html>