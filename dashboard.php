<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}
require_once "koneksi.php";

if (isset($_POST["hapus_id"])) {
    $hapus = $conn->prepare("DELETE FROM konten WHERE id = ?");
    $hapus->bind_param("i", $_POST["hapus_id"]);
    $hapus->execute();
    $hapus->close();
    header("Location: dashboard.php");
    exit;
}

$sort = isset($_GET["sort"]) ? $_GET["sort"] : "diperbarui";
$order = isset($_GET["order"]) ? $_GET["order"] : "DESC";
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

$allowed_sort = ["judul", "daerah", "kategori", "diperbarui"];
$allowed_order = ["ASC", "DESC"];
if (!in_array($sort, $allowed_sort))
    $sort = "diperbarui";
if (!in_array($order, $allowed_order))
    $order = "DESC";

$total_result = $conn->query("SELECT COUNT(*) as total FROM konten")->fetch_assoc()["total"];
$total_pages = ceil($total_result / $per_page);

$result = $conn->query("SELECT * FROM konten ORDER BY $sort $order LIMIT $per_page OFFSET $offset");
$konten_list = $result->fetch_all(MYSQLI_ASSOC);

$all_result = $conn->query("SELECT * FROM konten ORDER BY diperbarui DESC");
$all_konten = $all_result->fetch_all(MYSQLI_ASSOC);

$total_konten = $conn->query("SELECT COUNT(*) as total FROM konten")->fetch_assoc()["total"];
$total_user = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'")->fetch_assoc()["total"];
$total_histori = $conn->query("SELECT COUNT(*) as total FROM histori")->fetch_assoc()["total"];
$konten_bulan_ini = $conn->query("SELECT COUNT(*) as total FROM konten WHERE DATE_FORMAT(diperbarui, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')")->fetch_assoc()["total"];

$next_order = $order === "ASC" ? "DESC" : "ASC";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Dashboard</title>
    <link rel="stylesheet" href="dashboard.css" />
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
                    <span></span><span></span><span></span>
                </div>
                <?php include 'navbar_menu.php'; ?>
            </header>

            <section class="content-area">
                <h1>Dashboard</h1>
                <div class="dashboard-container">
                    <div class="container-top">
                        <div class="card">
                            <h3>Total Konten</h3>
                            <p><?= $total_konten ?></p>
                        </div>
                        <div class="card">
                            <h3>Pengguna Aktif</h3>
                            <p><?= $total_user ?></p>
                        </div>
                        <div class="card">
                            <h3>Total Histori</h3>
                            <p>
                                <?= $total_histori ?>
                            </p>
                        </div>
                        <div class="card">
                            <h3>Konten Baru Bulan Ini</h3>
                            <p><?= $konten_bulan_ini ?></p>
                        </div>
                    </div>

                    <div class="container-bottom">
                        <h3>Manajemen Konten</h3>
                        <a href="tambah_konten.php" class="btn-tambah">+ Tambah Konten Baru</a>

                        <div class="table-controls">
                            <input type="text" id="search-input" placeholder="Cari judul, daerah, kategori..." />
                            <select id="filter-kategori">
                                <option value="">Semua Kategori</option>
                                <?php
                                $kategori_list = $conn->query("SELECT DISTINCT kategori FROM konten ORDER BY kategori ASC");
                                while ($k = $kategori_list->fetch_assoc()):
                                    ?>
                                    <option value="<?= htmlspecialchars($k['kategori']) ?>">
                                        <?= htmlspecialchars($k['kategori']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="container-flex">
                            <div class="row1">
                                <h3 class="col-no">No</h3>
                                <h3 class="col-sort">
                                    <a href="?sort=judul&order=<?= $sort === 'judul' ? $next_order : 'ASC' ?>&page=1">
                                        Judul <?= $sort === 'judul' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </h3>
                                <h3 class="col-sort">
                                    <a href="?sort=daerah&order=<?= $sort === 'daerah' ? $next_order : 'ASC' ?>&page=1">
                                        Daerah <?= $sort === 'daerah' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </h3>
                                <h3 class="col-sort">
                                    <a
                                        href="?sort=kategori&order=<?= $sort === 'kategori' ? $next_order : 'ASC' ?>&page=1">
                                        Kategori <?= $sort === 'kategori' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </h3>
                                <h3 class="col-sort">
                                    <a
                                        href="?sort=diperbarui&order=<?= $sort === 'diperbarui' ? $next_order : 'DESC' ?>&page=1">
                                        Diperbarui <?= $sort === 'diperbarui' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                    </a>
                                </h3>
                                <h3>Aksi</h3>
                            </div>

                            <?php foreach ($konten_list as $i => $konten): ?>
                                <div class="row2" data-judul="<?= strtolower(htmlspecialchars($konten['judul'])) ?>"
                                    data-daerah="<?= strtolower(htmlspecialchars($konten['daerah'])) ?>"
                                    data-kategori="<?= strtolower(htmlspecialchars($konten['kategori'])) ?>">
                                    <p class="col-no-angka"><?= $offset + $i + 1 ?></p>
                                    <p><?= htmlspecialchars($konten["judul"]) ?></p>
                                    <p><?= htmlspecialchars($konten["daerah"]) ?></p>
                                    <p><?= htmlspecialchars($konten["kategori"]) ?></p>
                                    <p><?= date("d/m/Y", strtotime($konten["diperbarui"])) ?></p>
                                    <div>
                                        <a href="edit_konten.php?id=<?= $konten['id'] ?>"><button
                                                class="btn-edit">Edit</button></a>
                                        <form method="POST" style="display:inline">
                                            <input type="hidden" name="hapus_id" value="<?= $konten['id'] ?>" />
                                            <button type="submit" class="btn-hapus"
                                                onclick="return confirm('Hapus konten ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page - 1 ?>">&#8249;</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $i ?>"
                                    class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page + 1 ?>">&#8250;</a>
                            <?php endif; ?>
                        </div>
                    </div>
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

        const searchInput = document.getElementById("search-input");
        const filterKategori = document.getElementById("filter-kategori");
        const rows = document.querySelectorAll(".row2");

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const kategori = filterKategori.value.toLowerCase();

            rows.forEach((row) => {
                const judul = row.dataset.judul;
                const daerah = row.dataset.daerah;
                const rowKategori = row.dataset.kategori;

                const matchSearch = judul.includes(keyword) || daerah.includes(keyword) || rowKategori.includes(keyword);
                const matchKategori = kategori === "" || rowKategori === kategori;

                row.style.display = matchSearch && matchKategori ? "flex" : "none";
            });
        }

        searchInput.addEventListener("input", filterTable);
        filterKategori.addEventListener("change", filterTable);
    </script>
</body>

</html>