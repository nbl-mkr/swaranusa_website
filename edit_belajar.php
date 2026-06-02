<?php
require_once "koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "admin") {
    header("Location: /belajar_html/swaranusa_website/login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: dashboard.php?tab=belajar");
    exit;
}

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $konten_id = trim($_POST["konten_id"]);
    $judul = trim($_POST["judul"]);
    $daerah = trim($_POST["daerah"]);
    $kategori = trim($_POST["kategori"]);
    $pengertian = trim($_POST["pengertian"]);
    $cara_main = trim($_POST["cara_main"]);
    $keterangan_bagian = trim($_POST["keterangan_bagian"]);
    $diperbarui = date("Y-m-d");
    $gambar = trim($_POST["gambar_lama"]);

    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] === 0) {
        $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $nama_gambar = "gambar" . str_replace(" ", "", ucwords($judul)) . "." . $ext;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], "gmbr_kontenbljr/" . $nama_gambar);
        $gambar = $nama_gambar;
    }

    $gambar_bagian = trim($_POST["gambar_bagian_lama"]);
    $gambar_bagian_files = $gambar_bagian ? explode(",", $gambar_bagian) : [];

    if (isset($_FILES["gambar_bagian"])) {
        foreach ($_FILES["gambar_bagian"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["gambar_bagian"]["error"][$i] === 0) {
                $ext = pathinfo($_FILES["gambar_bagian"]["name"][$i], PATHINFO_EXTENSION);
                $nama_bagian = "bagian" . str_replace(" ", "", ucwords($judul)) . (count($gambar_bagian_files) + 1) . "." . $ext;
                move_uploaded_file($tmp, "gmbr_kontenbljr/" . $nama_bagian);
                $gambar_bagian_files[] = $nama_bagian;
            }
        }
    }
    $gambar_bagian = implode(",", $gambar_bagian_files);

    $audio = trim($_POST["audio_lama"]);
    $audio_files = $audio ? explode(",", $audio) : [];

    if (isset($_FILES["audio"])) {
        foreach ($_FILES["audio"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["audio"]["error"][$i] === 0) {
                $nama_audio = $_FILES["audio"]["name"][$i];
                move_uploaded_file($tmp, "audio_kontenbljr/" . $nama_audio);
                $audio_files[] = $nama_audio;
            }
        }
    }
    $audio = implode(",", $audio_files);

    $video = trim($_POST["video_lama"]);
    $video_files = $video ? explode(",", $video) : [];

    if (isset($_FILES["video"])) {
        foreach ($_FILES["video"]["tmp_name"] as $i => $tmp) {
            if ($_FILES["video"]["error"][$i] === 0) {
                $nama_video = $_FILES["video"]["name"][$i];
                move_uploaded_file($tmp, "video_kontenbljr/" . $nama_video);
                $video_files[] = $nama_video;
            }
        }
    }
    $video = implode(",", $video_files);

    $stmt = $conn->prepare("UPDATE belajar SET konten_id=?, judul=?, daerah=?, kategori=?, gambar=?, pengertian=?, cara_main=?, gambar_bagian=?, keterangan_bagian=?, audio=?, video=?, diperbarui=? WHERE id=?");
    $stmt->bind_param("issssssssssi", $konten_id, $judul, $daerah, $kategori, $gambar, $pengertian, $cara_main, $gambar_bagian, $keterangan_bagian, $audio, $video, $diperbarui, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php?tab=belajar");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM belajar WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$konten = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$konten) {
    header("Location: dashboard.php?tab=belajar");
    exit;
}

$konten_list = $conn->query("SELECT id, judul FROM jelajahi ORDER BY judul ASC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Edit Konten Belajar</title>
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
                <h1>Edit Konten Belajar</h1>
                <div class="form-container">
                    <form method="POST" action="edit_belajar.php?id=<?= $id ?>" enctype="multipart/form-data">
                        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($konten['gambar']) ?>" />
                        <input type="hidden" name="gambar_bagian_lama"
                            value="<?= htmlspecialchars($konten['gambar_bagian']) ?>" />
                        <input type="hidden" name="audio_lama" value="<?= htmlspecialchars($konten['audio']) ?>" />
                        <input type="hidden" name="video_lama" value="<?= htmlspecialchars($konten['video']) ?>" />

                        <div class="form-group">
                            <label>Konten Jelajahi Terkait</label>
                            <select name="konten_id">
                                <?php foreach ($konten_list as $k): ?>
                                    <option value="<?= $k['id'] ?>" <?= $k['id'] == $konten['konten_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" value="<?= htmlspecialchars($konten['judul']) ?>"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Daerah</label>
                            <input type="text" name="daerah" value="<?= htmlspecialchars($konten['daerah']) ?>"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" required>
                                <option value="">Pilih kategori</option>
                                <option value="Ansambel" <?= $konten['kategori'] === 'Ansambel' ? 'selected' : '' ?>>
                                    Ansambel</option>
                                <option value="Gesek" <?= $konten['kategori'] === 'Gesek' ? 'selected' : '' ?>>Gesek
                                </option>
                                <option value="Petik" <?= $konten['kategori'] === 'Petik' ? 'selected' : '' ?>>Petik
                                </option>
                                <option value="Tiup" <?= $konten['kategori'] === 'Tiup' ? 'selected' : '' ?>>Tiup</option>
                                <option value="Pukul" <?= $konten['kategori'] === 'Pukul' ? 'selected' : '' ?>>Pukul
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pengertian</label>
                            <textarea name="pengertian"
                                rows="4"><?= htmlspecialchars($konten['pengertian']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Cara Memainkan</label>
                            <textarea name="cara_main" rows="4"><?= htmlspecialchars($konten['cara_main']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Gambar Hero</label>
                            <?php if ($konten['gambar']): ?>
                                <img src="gmbr_kontenbljr/<?= htmlspecialchars($konten['gambar']) ?>"
                                    class="preview-gambar" />
                            <?php endif; ?>
                            <input type="file" name="gambar" accept="image/*" />
                            <p>Kosongkan jika tidak ingin mengubah gambar hero</p>
                        </div>
                        <div class="form-group">
                            <label>Gambar Bagian</label>
                            <?php if ($konten['gambar_bagian']): ?>
                                <div class="preview-galeri">
                                    <?php foreach (explode(",", $konten['gambar_bagian']) as $g): ?>
                                        <img src="gmbr_kontenbljr/<?= htmlspecialchars(trim($g)) ?>" />
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="gambar_bagian[]" accept="image/*" multiple />
                            <p>Upload gambar baru untuk menambah gambar bagian</p>
                        </div>
                        <div class="form-group">
                            <label>Keterangan Bagian</label>
                            <textarea name="keterangan_bagian"
                                rows="3"><?= htmlspecialchars($konten['keterangan_bagian']) ?></textarea>
                            <p>Pisahkan keterangan tiap gambar dengan tanda | contoh: Keterangan gambar 1|Keterangan
                                gambar 2</p>
                        </div>
                        <div class="form-group">
                            <label>Audio</label>
                            <?php if ($konten['audio']): ?>
                                <div class="preview-audio">
                                    <?php foreach (explode(",", $konten['audio']) as $a): ?>
                                        <?php $a = trim($a); ?>
                                        <div class="audio-item">
                                            <span><?= htmlspecialchars($a) ?></span>
                                            <audio controls src="audio_kontenbljr/<?= htmlspecialchars($a) ?>"></audio>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="audio[]" accept="audio/*" multiple />
                            <p>Upload file audio baru untuk menambah audio</p>
                        </div>
                        <div class="form-group">
                            <label>Video</label>
                            <?php if ($konten['video']): ?>
                                <div class="preview-video">
                                    <?php foreach (explode(",", $konten['video']) as $v): ?>
                                        <?php $v = trim($v); ?>
                                        <div class="video-item">
                                            <span><?= htmlspecialchars($v) ?></span>
                                            <video controls width="300"
                                                src="video_kontenbljr/<?= htmlspecialchars($v) ?>"></video>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="video[]" accept="video/*" multiple />
                            <p>Upload file video baru untuk menambah video</p>
                        </div>
                        <div class="form-btn">
                            <button type="submit">Simpan</button>
                            <a href="dashboard.php?tab=belajar"><button type="button">Batal</button></a>
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
    <script src="navbar.js"></script>
</body>

</html>