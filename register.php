<?php
session_start();
require_once "koneksi.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $firstname = trim($_POST["firstname"]);
  $lastname = trim($_POST["lastname"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];

  $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $error = "Email sudah terdaftar.";
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $username = $firstname . " " . $lastname;

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
      $success = "Akun berhasil dibuat! Silakan login.";
    } else {
      $error = "Gagal membuat akun. Coba lagi.";
    }

    $stmt->close();
  }

  $check->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buat Akun | SwaraNusa</title>
  <link rel="stylesheet" href="register.css" />
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
      <h1>Buat Akun</h1>
      <p>Sudah punya akun? <a href="login.php">Login</a></p>

      <?php if ($error): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success-msg"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <form method="POST" action="register.php">
        <div class="name-group">
          <input type="text" name="firstname" placeholder="First Name" required />
          <input type="text" name="lastname" placeholder="Last Name" required />
        </div>

        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />

        <button type="submit" class="submit-button">Buat Akun</button>

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