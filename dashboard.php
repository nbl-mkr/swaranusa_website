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

if (isset($_POST["tambah_judul"])) {
    $judul = trim($_POST["tambah_judul"]);
    $daerah = trim($_POST["tambah_daerah"]);
    $kategori = trim($_POST["tambah_kategori"]);
    $deskripsi = trim($_POST["tambah_deskripsi"]);
    $diperbarui = date("Y-m-d");

    $tambah = $conn->prepare("INSERT INTO konten (judul, daerah, kategori, deskripsi, diperbarui) VALUES (?, ?, ?, ?, ?)");
    $tambah->bind_param("sssss", $judul, $daerah, $kategori, $deskripsi, $diperbarui);
    $tambah->execute();
    $tambah->close();
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST["edit_id"])) {
    $id = $_POST["edit_id"];
    $judul = trim($_POST["edit_judul"]);
    $deskripsi = trim($_POST["edit_deskripsi"]);
    $diperbarui = date("Y-m-d");

    $edit = $conn->prepare("UPDATE konten SET judul = ?, deskripsi = ?, diperbarui = ? WHERE id = ?");
    $edit->bind_param("sssi", $judul, $deskripsi, $diperbarui, $id);
    $edit->execute();
    $edit->close();
    header("Location: dashboard.php");
    exit;
}

$result = $conn->query("SELECT * FROM konten ORDER BY diperbarui DESC");
$konten_list = $result->fetch_all(MYSQLI_ASSOC);

$total_konten = count($konten_list);
$total_user = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'user'")->fetch_assoc()["total"];
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
            <nav class="sidebar-menu">
                <div>
                    <img src="assets/logo_dashboard.png" alt="Logo Dashboard" />
                    <a href="dashboard.php">Dashboard</a>
                </div>
                <div>
                    <img src="assets/logo_analisis.png" alt="Logo Analisis" />
                    <a href="analisis.php">Analisis</a>
                </div>
                <div>
                    <img src="assets/logo_histori.png" alt="Logo Histori" />
                    <a href="histori.php">Histori</a>
                </div>
                <div>
                    <img src="assets/logo_kelola.png" alt="Logo Kelola" width="15px" height="15px" />
                    <a href="kelola.php">Kelola Akun</a>
                </div>
                <div class="logout">
                    <a href="logout.php">Logout</a>
                </div>
            </nav>
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

                <nav id="navMenu">
                    <ul>
                        <li><a href="landing.html" onclick="closeMenu()">Beranda</a></li>
                        <li><a href="jelajahi.html" onclick="closeMenu()">Jelajahi</a></li>
                        <li><a href="belajar.html" onclick="closeMenu()">Belajar</a></li>
                        <li><a href="tentang.html" onclick="closeMenu()">Tentang</a></li>
                        <li>
                            <a href="kelola.php" onclick="closeMenu()">
                                <img src="assets/user.png" alt="User" />
                            </a>
                        </li>
                    </ul>
                </nav>
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
                            <h3>Favorit Disimpan</h3>
                            <p>0</p>
                        </div>
                        <div class="card">
                            <h3>Konten Baru Bulan Ini</h3>
                            <p><?= array_reduce($konten_list, function ($carry, $item) {
                                return $carry + (date("Y-m") === substr($item["diperbarui"], 0, 7) ? 1 : 0);
                            }, 0) ?></p>
                        </div>
                    </div>

                    <div class="container-bottom">
                        <h3>Manajemen Konten</h3>
                        <a href="tambah_konten.php"><button>+ Tambah Konten Baru</button></a>
                        <div class="container-flex">
                            <div class="row1">
                                <h3>Judul</h3>
                                <h3>Daerah</h3>
                                <h3>Kategori</h3>
                                <h3>Diperbarui</h3>
                                <h3>Aksi</h3>
                            </div>
                            <?php foreach ($konten_list as $konten): ?>
                                <div class="row2">
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
    </script>
</body>

</html>