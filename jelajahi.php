<?php require_once "koneksi.php";

$daerah_filter = isset($_GET["daerah"]) ? $_GET["daerah"] : "";
$search = isset($_GET["search"]) ? $_GET["search"] : "";

$query = "SELECT * FROM konten WHERE 1=1";
$params = [];
$types = "";

if ($daerah_filter && $daerah_filter !== "Semua Daerah") {
  $query .= " AND daerah LIKE ?";
  $params[] = "%" . $daerah_filter . "%";
  $types .= "s";
}

if ($search) {
  $query .= " AND (judul LIKE ? OR daerah LIKE ?)";
  $params[] = "%" . $search . "%";
  $params[] = "%" . $search . "%";
  $types .= "ss";
}

$stmt = $conn->prepare($query);
if ($params) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$konten_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title>Halaman Jelajahi SwaraNusa</title>
  <link rel="stylesheet" href="navbar.css" />
  <link rel="stylesheet" href="jelajahi.css" />
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
    <h2>Jelajahi Musik & Alat Musik Nusantara</h2>
    <p>
      Temukan koleksi musik tradisional, pelajari asal-usulnya, dan pelajari
      cara memainkannya lewat notasi, audio, dan video.
    </p>
    <div class="search-filter">
      <div class="search-bar">
        <img src="gmbr_jljh/search.svg" />
        <input id="search-input" type="search" placeholder="Cari judul, daerah, atau alat musik..."
          value="<?= htmlspecialchars($search) ?>" />
      </div>
      <div class="filter">
        <button class="dropdown-btn" id="dropdownBtn">
          <?= $daerah_filter ? htmlspecialchars($daerah_filter) : "Semua Daerah" ?>
        </button>
        <div class="dropdown-menu" id="dropdownMenu">
          <div class="dropdown-item <?= $daerah_filter === '' ? 'selected' : '' ?>">Semua Daerah</div>
          <div class="dropdown-item <?= $daerah_filter === 'Jawa' ? 'selected' : '' ?>">Jawa</div>
          <div class="dropdown-item <?= $daerah_filter === 'Sumatra' ? 'selected' : '' ?>">Sumatra</div>
          <div class="dropdown-item <?= $daerah_filter === 'Sulawesi' ? 'selected' : '' ?>">Sulawesi</div>
          <div class="dropdown-item <?= $daerah_filter === 'Kalimantan' ? 'selected' : '' ?>">Kalimantan</div>
          <div class="dropdown-item <?= $daerah_filter === 'Papua' ? 'selected' : '' ?>">Papua</div>
          <div class="dropdown-item <?= $daerah_filter === 'NTT' ? 'selected' : '' ?>">NTT</div>
        </div>
      </div>
    </div>
  </section>

  <section class="isi">
    <div class="container">
      <div class="grid" id="card-grid">
        <?php if (empty($konten_list)): ?>
          <p>Tidak ada konten yang ditemukan.</p>
        <?php else: ?>
          <?php foreach ($konten_list as $konten): ?>
            <div class="card">
              <div class="image-wrapper">
                <img src="gmbr_jljh/Gambar <?= htmlspecialchars($konten['judul']) ?>.png"
                  onerror="this.src='gmbr_jljh/Gambar <?= htmlspecialchars($konten['judul']) ?>.jpg'" />
                <div class="region-tag"><?= htmlspecialchars($konten['daerah']) ?></div>
              </div>
              <div class="card-content">
                <h3 class="card-title"><?= htmlspecialchars($konten['judul']) ?></h3>
                <p class="card-description"><?= htmlspecialchars($konten['deskripsi']) ?></p>
                <a href="konten_jelajahi.php?id=<?= $konten['id'] ?>">
                  <button class="btn-learn">Pelajari</button>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
  <script src="burger.js"></script>
  <script src="jelajahi.js"></script>
</body>

</html>