<?php
require_once "koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}

if (isset($_POST["hapus_id"])) {
    $hapus = $conn->prepare("DELETE FROM jelajahi WHERE id = ?");
    $hapus->bind_param("i", $_POST["hapus_id"]);
    $hapus->execute();
    $hapus->close();
    header("Location: konten.php");
    exit;
}

if (isset($_POST["hapus_belajar_id"])) {
    $hapus = $conn->prepare("DELETE FROM belajar WHERE id = ?");
    $hapus->bind_param("i", $_POST["hapus_belajar_id"]);
    $hapus->execute();
    $hapus->close();
    header("Location: konten.php?tab=belajar");
    exit;
}

$tab = isset($_GET["tab"]) ? $_GET["tab"] : "jelajahi";

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

$total_result = $conn->query("SELECT COUNT(*) as total FROM jelajahi")->fetch_assoc()["total"];
$total_pages = ceil($total_result / $per_page);

$result = $conn->query("SELECT * FROM jelajahi ORDER BY $sort $order LIMIT $per_page OFFSET $offset");
$konten_list = $result->fetch_all(MYSQLI_ASSOC);

$total_result_belajar = $conn->query("SELECT COUNT(*) as total FROM belajar")->fetch_assoc()["total"];
$total_pages_belajar = ceil($total_result_belajar / $per_page);

$result_belajar = $conn->query("SELECT * FROM belajar ORDER BY $sort $order LIMIT $per_page OFFSET $offset");
$konten_belajar_list = $result_belajar->fetch_all(MYSQLI_ASSOC);

$next_order = $order === "ASC" ? "DESC" : "ASC";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Konten</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="konten.css" />
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
                <h1>Konten</h1>

                <div class="konten-container">
                    <?php if ($tab === 'jelajahi'): ?>
                        <div class="container-bottom">
                            <h3>Manajemen Konten</h3>
                            <a href="tambah_konten.php" class="btn-tambah">+ Tambah Konten Baru</a>

                            <div class="table-controls">
                                <input type="text" id="search-input" placeholder="Cari judul, daerah, kategori..." />
                                <select id="filter-kategori">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    $kategori_list = $conn->query("SELECT DISTINCT kategori FROM jelajahi ORDER BY kategori ASC");
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
                                        <a
                                            href="?tab=jelajahi&sort=judul&order=<?= $sort === 'judul' ? $next_order : 'ASC' ?>&page=1">
                                            Judul <?= $sort === 'judul' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3 class="col-sort">
                                        <a
                                            href="?tab=jelajahi&sort=daerah&order=<?= $sort === 'daerah' ? $next_order : 'ASC' ?>&page=1">
                                            Daerah <?= $sort === 'daerah' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3 class="col-sort">
                                        <a
                                            href="?tab=jelajahi&sort=kategori&order=<?= $sort === 'kategori' ? $next_order : 'ASC' ?>&page=1">
                                            Kategori <?= $sort === 'kategori' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3 class="col-sort">
                                        <a
                                            href="?tab=jelajahi&sort=diperbarui&order=<?= $sort === 'diperbarui' ? $next_order : 'DESC' ?>&page=1">
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
                                    <a
                                        href="?tab=jelajahi&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page - 1 ?>">&#8249;</a>
                                <?php endif; ?>
                                <?php
                                $start = max(1, $page - 1);
                                $end = min($total_pages, $start + 2);
                                if ($end - $start < 2)
                                    $start = max(1, $end - 2);
                                for ($i = $start; $i <= $end; $i++):
                                    ?>
                                    <a href="?tab=jelajahi&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $i ?>"
                                        class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                                <?php endfor; ?>
                                <?php if ($page < $total_pages): ?>
                                    <a
                                        href="?tab=jelajahi&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page + 1 ?>">&#8250;</a>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="container-bottom">
                            <h3>Manajemen Konten</h3>
                            <a href="tambah_konten_belajar.php" class="btn-tambah">+ Tambah Konten Baru</a>

                            <div class="table-controls">
                                <input type="text" id="search-input-belajar"
                                    placeholder="Cari judul, daerah, kategori..." />
                                <select id="filter-kategori-belajar">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    $kategori_belajar_list = $conn->query("SELECT DISTINCT kategori FROM belajar ORDER BY kategori ASC");
                                    while ($k = $kategori_belajar_list->fetch_assoc()):
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
                                        <a
                                            href="?tab=belajar&sort=judul&order=<?= $sort === 'judul' ? $next_order : 'ASC' ?>&page=1">
                                            Judul <?= $sort === 'judul' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3 class="col-sort">
                                        <a
                                            href="?tab=belajar&sort=daerah&order=<?= $sort === 'daerah' ? $next_order : 'ASC' ?>&page=1">
                                            Daerah <?= $sort === 'daerah' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3 class="col-sort">
                                        <a
                                            href="?tab=belajar&sort=kategori&order=<?= $sort === 'kategori' ? $next_order : 'ASC' ?>&page=1">
                                            Kategori <?= $sort === 'kategori' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3 class="col-sort">
                                        <a
                                            href="?tab=belajar&sort=diperbarui&order=<?= $sort === 'diperbarui' ? $next_order : 'DESC' ?>&page=1">
                                            Diperbarui <?= $sort === 'diperbarui' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                        </a>
                                    </h3>
                                    <h3>Aksi</h3>
                                </div>

                                <?php foreach ($konten_belajar_list as $i => $konten): ?>
                                    <div class="row2-belajar" data-judul="<?= strtolower(htmlspecialchars($konten['judul'])) ?>"
                                        data-daerah="<?= strtolower(htmlspecialchars($konten['daerah'])) ?>"
                                        data-kategori="<?= strtolower(htmlspecialchars($konten['kategori'])) ?>">
                                        <p class="col-no-angka"><?= $offset + $i + 1 ?></p>
                                        <p><?= htmlspecialchars($konten["judul"]) ?></p>
                                        <p><?= htmlspecialchars($konten["daerah"]) ?></p>
                                        <p><?= htmlspecialchars($konten["kategori"]) ?></p>
                                        <p><?= date("d/m/Y", strtotime($konten["diperbarui"])) ?></p>
                                        <div>
                                            <a href="edit_konten_belajar.php?id=<?= $konten['id'] ?>"><button
                                                    class="btn-edit">Edit</button></a>
                                            <form method="POST" style="display:inline">
                                                <input type="hidden" name="hapus_belajar_id" value="<?= $konten['id'] ?>" />
                                                <button type="submit" class="btn-hapus"
                                                    onclick="return confirm('Hapus konten ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a
                                        href="?tab=belajar&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page - 1 ?>">&#8249;</a>
                                <?php endif; ?>
                                <?php
                                $start = max(1, $page - 1);
                                $end = min($total_pages_belajar, $start + 2);
                                if ($end - $start < 2)
                                    $start = max(1, $end - 2);
                                for ($i = $start; $i <= $end; $i++):
                                    ?>
                                    <a href="?tab=belajar&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $i ?>"
                                        class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                                <?php endfor; ?>
                                <?php if ($page < $total_pages_belajar): ?>
                                    <a
                                        href="?tab=belajar&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $page + 1 ?>">&#8250;</a>
                                <?php endif; ?>
                            </div>
                        </div>
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

        const searchInput = document.getElementById("search-input");
        const filterKategori = document.getElementById("filter-kategori");
        const rows = document.querySelectorAll(".row2");

        if (searchInput && filterKategori) {
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
        }

        const searchInputBelajar = document.getElementById("search-input-belajar");
        const filterKategoriBelajar = document.getElementById("filter-kategori-belajar");
        const rowsBelajar = document.querySelectorAll(".row2-belajar");

        if (searchInputBelajar && filterKategoriBelajar) {
            function filterTableBelajar() {
                const keyword = searchInputBelajar.value.toLowerCase();
                const kategori = filterKategoriBelajar.value.toLowerCase();
                rowsBelajar.forEach((row) => {
                    const judul = row.dataset.judul;
                    const daerah = row.dataset.daerah;
                    const rowKategori = row.dataset.kategori;
                    const matchSearch = judul.includes(keyword) || daerah.includes(keyword) || rowKategori.includes(keyword);
                    const matchKategori = kategori === "" || rowKategori === kategori;
                    row.style.display = matchSearch && matchKategori ? "flex" : "none";
                });
            }
            searchInputBelajar.addEventListener("input", filterTableBelajar);
            filterKategoriBelajar.addEventListener("change", filterTableBelajar);
        }
    </script>
    <script src="navbar.js"></script>
</body>

</html>