<?php
session_start();
require_once "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password"])) {
      $_SESSION["isLoggedIn"] = true;
      $_SESSION["username"] = $user["username"];
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["role"] = $user["role"];

      if ($_SESSION["role"] === "admin") {
        header("Location: /belajar_html/swaranusa_website/kelola.php");
      } else {
        header("Location: /belajar_html/swaranusa_website/menu_user/kelola_user.php");
      }
      exit;
    } else {
      $error = "Password salah.";
    }
  } else {
    $error = "Email tidak ditemukan.";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | SwaraNusa</title>
  <link rel="stylesheet" href="login.css" />
</head>

<body>
  <div class="container">
    <div class="left-side">
      <div class="overlay">
        <div class="logo">
          <img src="assets/logo_white.png" alt="SwaraNusa Logo" />
          <p>SwaraNusa</p>
        </div>
        <button><a href="index.html">Kembali ke website</a></button>
      </div>
    </div>

    <div class="right-side">
      <h1>Login</h1>
      <p>Belum punya akun? <a href="register.php">Register</a></p>

      <?php if ($error): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />

        <a href="lupapw.html">Lupa password?</a>

        <button type="submit" class="submit-button">Login</button>

        <div class="divider">
          <hr />
          <p>Atau lanjutkan dengan</p>
          <hr />
        </div>

        <div class="social-buttons">
          <button class="google-button">
            <img src="assets/google.png" alt="Google" />
            Google
          </button>
          <button class="facebook-button">
            <img src="assets/facebook.png" alt="Facebook" />
            Facebook
          </button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>