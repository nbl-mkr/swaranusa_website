<?php
require_once "../koneksi.php";

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "user") {
  header("Location: /belajar_html/swaranusa_website/login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
  $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
  $nama_foto = "foto_" . $_SESSION["user_id"] . "." . $ext;
  move_uploaded_file($_FILES["foto"]["tmp_name"], "../profile_photos/" . $nama_foto);

  $stmt = $conn->prepare("UPDATE users SET foto = ? WHERE id = ?");
  $stmt->bind_param("si", $nama_foto, $_SESSION["user_id"]);
  $stmt->execute();
  $stmt->close();

  header("Location: kelola_user.php");
  exit;
}

$stmt = $conn->prepare("SELECT username, email, foto FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

$foto = $user["foto"] ? "../profile_photos/" . $user["foto"] : "../assets/profile.png";
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Akun</title>
  <link rel="stylesheet" href="../navbar.css" />
  <link rel="stylesheet" href="kelola_user.css" />
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
      <h1>Kelola Akun</h1>
      <div class="kelola-container">
        <div class="kelola-profile">
          <div class="foto-wrapper">
            <img src="<?= htmlspecialchars($foto) ?>" alt="Profile Photo" />
            <form method="POST" action="kelola_user.php" enctype="multipart/form-data">
              <label for="foto" class="btn-edit-foto">
                <img src="../assets/pencil.png" alt="edit" />
              </label>
              <input type="file" name="foto" id="foto" accept="image/*" style="display:none"
                onchange="this.form.submit()" />
            </form>
          </div>
          <h2><?= htmlspecialchars($user["username"]) ?></h2>
          <p>Kelola data privasi untuk kenyamanan Anda.</p>
        </div>

        <div class="kelola-content">
          <div class="kelola-left">
            <div>
              <h3>Akun Anda</h3>
              <p>Lihat data akun Anda saat menggunakan website ini.</p>
              <hr />
              <p class="cursor-pointer">Data akun Anda</p>
            </div>
            <div>
              <h3>Apa yang bisa ditemukan disini?</h3>
              <p>Data akun Anda</p>
              <hr />
              <p class="cursor-pointer">Keamanan akun Anda</p>
            </div>
          </div>

          <div class="kelola-right">
            <h3>Keamanan</h3>
            <p class="cursor-pointer">Lihat keamanan akun Anda saat menggunakan website ini.</p>
            <hr />
            <h3>Keamanan akun Anda</h3>
            <p>Akun Anda memiliki tingkat keamanan yang baik</p>
          </div>
        </div>
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