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
$sql = "SELECT ProfielFoto, naam FROM USERS WHERE Email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();
$profielFoto = $user['ProfielFoto'] ?? null;

// Zorg dat $user altijd een array is
if (!$user) {
    $user = ['naam' => '', 'ProfielFoto' => null];
}

// Haal 3 random modellen op voor slideshow (alleen actieve modellen)
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";
$featuredModels = [];
try {
    $sql = "SELECT * FROM Modelen WHERE COALESCE(Status, '') NOT IN ('rejected', 'deactivated') ORDER BY RAND() LIMIT 3";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $featuredModels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Als er een fout is, blijf met lege array
    $featuredModels = [];
}

// View laden
include "view/home_view.php";
