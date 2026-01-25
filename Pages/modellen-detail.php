<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php'; // PDO: $conn

// Check of gebruiker is ingelogd
if (!isset($_SESSION['naam'])) {
    header('Location: inlog.php');
    exit;
}

// Profielfoto rechtsboven in nav ophalen
$profielFoto = null;
$email = $_SESSION['naam'];
$sql = "SELECT ProfielFoto FROM USERS WHERE Email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$profielFoto = $user['ProfielFoto'] ?? null;

// ID uit URL
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die("Geen geldig profiel-ID meegegeven.");
}

// Model ophalen
$stmt = $conn->prepare("SELECT * FROM Modelen WHERE Profiel_ID = :id");
$stmt->execute(['id' => $id]);
$model = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$model) {
    die("Model niet gevonden (ID: " . htmlspecialchars((string)$id) . ").");
}

// Foto URL bepalen (zelfde logica als jij gebruikt)
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";
$fotoRel = $model['Foto'] ?? '';

if (!empty($fotoRel) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/beroeps/Modellenbureau/Pages/' . $fotoRel)) {
    $fotoUrl = '/beroeps/Modellenbureau/Pages/' . htmlspecialchars($fotoRel);
} else {
    $fotoUrl = $uploadsPath . 'placeholder.jpg';
}

// View laden
include "view/modellen-detail_view.php";
