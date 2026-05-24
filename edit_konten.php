<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}
require_once "koneksi.php";

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul = trim($_POST["judul"]);
    $subjudul = trim($_POST["subjudul"]);
    $daerah = trim($_POST["daerah"]);
    $kategori = trim($_POST["kategori"]);
    $deskripsi = trim($_POST["deskripsi"]);
    $informasi_umum = trim($_POST["informasi_umum"]);
    $sejarah = trim($_POST["sejarah"]);
    $instrumen = trim($_POST["instrumen"]);
    $nilai_budaya = trim($_POST["nilai_budaya"]);
    $diperbarui = date("Y-m-d");
    $gambar = trim($_POST["gambar_lama"]);

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] === 0) {
        $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $nama_gambar = "hero" . str_replace(" ", "", ucwords($judul)) . "." . $ext;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], "gmbr_kontenjljh/" . $nama_gambar);
        $gambar = $nama_gambar;
    }

    $galeri = trim($_POST["galeri_lama"]);
    $galeri_files = $galeri ? explode(",", $galeri) : [];

    if (isset($_FILES["galeri"])) {
        foreach ($_FILES["galeri"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["galeri"]["error"][$i] === 0) {
                $ext = pathinfo($_FILES["galeri"]["name"][$i], PATHINFO_EXTENSION);
                $nama_galeri = strtolower(str_replace(" ", "", $judul)) . (count($galeri_files) + 1) . "." . $ext;
                move_uploaded_file($tmp, "gmbr_kontenjljh/" . $nama_galeri);
                $galeri_files[] = $nama_galeri;
            }
        }
    }
    $galeri = implode(",", $galeri_files);

    $stmt = $conn->prepare("UPDATE konten SET judul=?, subjudul=?, daerah=?, kategori=?, deskripsi=?, informasi_umum=?, sejarah=?, instrumen=?, galeri=?, nilai_budaya=?, gambar=?, diperbarui=? WHERE id=?");
    $stmt->bind_param("ssssssssssssi", $judul, $subjudul, $daerah, $kategori, $deskripsi, $informasi_umum, $sejarah, $instrumen, $galeri, $nilai_budaya, $gambar, $diperbarui, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM konten WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$konten = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$konten) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Edit Konten</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="tambah_konten.css" />
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
                <h1>Edit Konten</h1>
                <div class="form-container">
                    <form method="POST" action="edit_konten.php?id=<?= $id ?>" enctype="multipart/form-data">
                        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($konten['gambar']) ?>" />
                        <input type="hidden" name="galeri_lama" value="<?= htmlspecialchars($konten['galeri']) ?>" />
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" value="<?= htmlspecialchars($konten['judul']) ?>"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Subjudul</label>
                            <input type="text" name="subjudul" value="<?= htmlspecialchars($konten['subjudul']) ?>" />
                        </div>
                        <div class="form-group">
                            <label>Daerah</label>
                            <input type="text" name="daerah" value="<?= htmlspecialchars($konten['daerah']) ?>"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="kategori" value="<?= htmlspecialchars($konten['kategori']) ?>"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3"><?= htmlspecialchars($konten['deskripsi']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Informasi Umum</label>
                            <textarea name="informasi_umum"
                                rows="4"><?= htmlspecialchars($konten['informasi_umum']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Sejarah</label>
                            <textarea name="sejarah" rows="4"><?= htmlspecialchars($konten['sejarah']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Instrumen yang Digunakan</label>
                            <input type="text" name="instrumen" value="<?= htmlspecialchars($konten['instrumen']) ?>"
                                placeholder="contoh: Bonang,Gender,Gong" />
                            <small>Pisahkan dengan koma tanpa spasi</small>
                        </div>
                        <div class="form-group">
                            <label>Nilai Budaya</label>
                            <textarea name="nilai_budaya"
                                rows="4"><?= htmlspecialchars($konten['nilai_budaya']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Hero</label>
                            <?php if ($konten['gambar']): ?>
                                <img src="gmbr_kontenjljh/<?= htmlspecialchars($konten['gambar']) ?>"
                                    class="preview-gambar" />
                            <?php endif; ?>
                            <input type="file" name="gambar" accept="image/*" />
                            <small>Kosongkan jika tidak ingin mengubah gambar hero</small>
                        </div>
                        <div class="form-group">
                            <label>Galeri</label>
                            <?php if ($konten['galeri']): ?>
                                <div class="preview-galeri">
                                    <?php foreach (explode(",", $konten['galeri']) as $g): ?>
                                        <img src="gmbr_kontenjljh/<?= htmlspecialchars(trim($g)) ?>" />
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="galeri[]" accept="image/*" multiple />
                            <small>Upload gambar baru untuk menambah galeri</small>
                        </div>
                        <div class="form-btn">
                            <button type="submit">Simpan</button>
                            <a href="dashboard.php"><button type="button">Batal</button></a>
                        </div>
                    </form>
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