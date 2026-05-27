<?php
require_once "koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt_jelajahi = $conn->prepare("
    SELECT j.judul, j.daerah, j.kategori, j.deskripsi, j.gambar, h.dilihat_pada
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
    SELECT b.judul, b.daerah, b.kategori, b.pengertian, b.gambar, h.dilihat_pada
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
    <title>Menu - Histori</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="histori.css" />
</head>

<body>
    <div class="menu-container">
        <div class="left-side">
            <div class="logo-text">
                <img src="assets/logo_white.png" alt="Logo SwaraNusa" />
                <h1>SwaraNusa</h1>
            </div>
            <?php include 'sidebar_admin.php'; ?>
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
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <?php include 'navbar_menu.php'; ?>
            </header>

            <section class="content-area">
                <h1>Histori</h1>
                <div class="tab">
                    <button class="tab-btn active" onclick="gantiTab('jelajahi')">Jelajahi</button>
                    <button class="tab-btn" onclick="gantiTab('belajar')">Belajar</button>
                </div>

                <div id="tab-jelajahi" class="tab-konten">
                    <div class="cards-container">
                        <?php if (empty($histori_jelajahi)): ?>
                            <p>Belum ada histori jelajahi.</p>
                        <?php else: ?>
                            <?php foreach ($histori_jelajahi as $item): ?>
                                <div class="card">
                                    <img src="gmbr_kontenjljh/<?= htmlspecialchars($item["gambar"]) ?>"
                                        alt="<?= htmlspecialchars($item["judul"]) ?>" />
                                    <div class="card-content">
                                        <div class="card-top">
                                            <h3><?= htmlspecialchars($item["judul"]) ?></h3>
                                            <p><?= htmlspecialchars($item["kategori"]) ?> •
                                                <?= waktu_lalu($item["dilihat_pada"]) ?>
                                            </p>
                                            <p><?= htmlspecialchars($item["deskripsi"]) ?></p>
                                        </div>
                                        <div class="card-bottom">
                                            <p><?= htmlspecialchars($item["daerah"]) ?></p>
                                            <a href="konten_jelajahi.php" class="btn-pelajari">Pelajari</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="tab-belajar" class="tab-konten" style="display: none;">
                    <div class="cards-container">
                        <?php if (empty($histori_belajar)): ?>
                            <p>Belum ada histori belajar.</p>
                        <?php else: ?>
                            <?php foreach ($histori_belajar as $item): ?>
                                <div class="card">
                                    <img src="gmbr_kontenbljr/<?= htmlspecialchars($item["gambar"]) ?>"
                                        alt="<?= htmlspecialchars($item["judul"]) ?>" />
                                    <div class="card-content">
                                        <div class="card-top">
                                            <h3><?= htmlspecialchars($item["judul"]) ?></h3>
                                            <p><?= htmlspecialchars($item["kategori"]) ?> •
                                                <?= waktu_lalu($item["dilihat_pada"]) ?>
                                            </p>
                                            <p><?= htmlspecialchars($item["pengertian"]) ?></p>
                                        </div>
                                        <div class="card-bottom">
                                            <p><?= htmlspecialchars($item["daerah"]) ?></p>
                                            <a href="konten_belajar.php" class="btn-pelajari">Pelajari</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        function gantiTab(tab) {
            document.querySelectorAll(".tab-konten").forEach(el => el.style.display = "none");
            document.querySelectorAll(".tab-btn").forEach(el => el.classList.remove("active"));
            document.getElementById("tab-" + tab).style.display = "block";
            event.target.classList.add("active");
        }

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