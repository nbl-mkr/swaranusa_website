<?php
session_start();
require_once "koneksi.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"]);

  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $success = "Link reset password telah dikirim ke email Anda.";
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
  <title>Lupa Password | SwaraNusa</title>
  <link rel="stylesheet" href="lupapw.css" />
</head>

<body>
  <div class="container">
    <div class="left-side">
      <div class="overlay">
        <div class="logo">
          <img src="gmbr_gnrl/logoputih.svg" alt="SwaraNusa Logo" />
          <p>SwaraNusa</p>
        </div>
        <button>
          <a href="index.html">Kembali ke website</a>
        </button>
      </div>
    </div>

    <div class="right-side">
      <h1>Lupa Password</h1>
      <p>
        Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
        <a href="login.php">Kembali ke Login</a>
      </p>

      <?php if ($error): ?>
        <p class="error-msg">
          <?= htmlspecialchars($error) ?>
        </p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success-msg">
          <?= htmlspecialchars($success) ?>
        </p>
      <?php endif; ?>

      <form method="POST" action="lupapw.php">
        <label for="email">Masukkan Email: </label>
        <input type="email" id="email" name="email" required />
        <input type="submit" class="submit" />
      </form>
    </div>
  </div>
</body>

</html>