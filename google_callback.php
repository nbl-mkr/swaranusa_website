<?php
require_once "koneksi.php";
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri("http://localhost/belajar_html/swaranusa_website/google_callback.php");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $google_service = new Google\Service\Oauth2($client);
    $google_user = $google_service->userinfo->get();

    $google_id = $google_user->id;
    $email = $google_user->email;
    $name = $google_user->name;

    $stmt = $conn->prepare("SELECT id, username, role FROM users WHERE google_id = ? OR email = ?");
    $stmt->bind_param("ss", $google_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $update = $conn->prepare("UPDATE users SET google_id = ? WHERE id = ?");
        $update->bind_param("si", $google_id, $user['id']);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO users (username, email, google_id, role) VALUES (?, ?, ?, 'user')");
        $insert->bind_param("sss", $name, $email, $google_id);
        $insert->execute();
        $user = ["id" => $conn->insert_id, "username" => $name, "role" => "user"];
    }

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
    header("Location: login.php");
    exit;
}