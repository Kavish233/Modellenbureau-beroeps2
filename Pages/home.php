<?php
session_start();
require 'config.php';

// Check of gebruiker is ingelogd, anders redirect naar inlog
if (!isset($_SESSION['naam'])) {
    header('Location: inlog.php');
    exit;
}

// Haal user data op voor profielfoto
$email = $_SESSION['naam'];
$sql = "SELECT ProfielFoto FROM USERS WHERE Email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();
$profielFoto = $user['ProfielFoto'] ?? null;

// View laden
include "view/home_view.php";
