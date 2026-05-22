<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["role"] !== "user") {
  header("Location: /belajar_html/swaranusa_website/login.php");
  exit;
}
require_once "../koneksi.php";

$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu - Kelola Akun</title>
  <link rel="stylesheet" href="kelola_user.css" />
</head>

<body>
  <div class="menu-container">
    <div class="left-side">
      <div class="logo-text">
        <img src="../assets/logo_white.png" alt="Logo SwaraNusa" />
        <h1>SwaraNusa</h1>
      </div>
      <nav class="sidebar-menu">
        <div>
          <img src="../assets/logo_histori.png" alt="Logo Histori" />
          <a href="histori_user.php">Histori</a>
        </div>
        <div>
          <img src="../assets/logo_kelola.png" alt="Logo Kelola" width="15px" height="15px" />
          <a href="kelola_user.php">Kelola Akun</a>
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
            <li><a href="../index.html" onclick="closeMenu()">Beranda</a></li>
            <li><a href="../jelajahi.html" onclick="closeMenu()">Jelajahi</a></li>
            <li><a href="../belajar.html" onclick="closeMenu()">Belajar</a></li>
            <li><a href="../tentang.html" onclick="closeMenu()">Tentang</a></li>
            <li>
              <a href="../kelola.php" onclick="closeMenu()">
                <img src="../assets/user.png" alt="User" />
              </a>
            </li>
          </ul>
        </nav>
      </header>

      <section class="content-area">
        <h1>Kelola Akun</h1>
        <div class="kelola-container">
          <div class="kelola-profile">
            <img src="../assets/profile.png" alt="Profile Photo" />
            <h2>
              <?= htmlspecialchars($user["username"]) ?>
            </h2>
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
              <p class="cursor-pointer">
                Lihat keamanan akun Anda saat menggunakan website ini.
              </p>
              <hr />
              <h3>Keamanan akun Anda</h3>
              <p>Akun Anda memiliki tingkat keamanan yang baik</p>
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