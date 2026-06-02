<?php
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri("http://localhost/belajar_html/swaranusa_website/google_callback.php");
$client->addScope("email");
$client->addScope("profile");

header("Location: " . $client->createAuthUrl());
exit;