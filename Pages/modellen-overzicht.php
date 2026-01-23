<?php
session_start();
// modellen-overzicht.php

// Foutmeldingen zichtbaar maken (alleen voor ontwikkeling)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connectie
require 'config.php'; // Zorg dat $conn (PDO) hier beschikbaar is

// Haal user data op voor profielfoto (als ingelogd)
$profielFoto = null;
if (isset($_SESSION['naam'])) {
    $email = $_SESSION['naam'];
    $sql = "SELECT ProfielFoto FROM USERS WHERE Email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    $profielFoto = $user['ProfielFoto'] ?? null;
}

// Map waar de uploads staan (relatief aan de root van je project)
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";

// Modellen ophalen uit de database (alleen actieve modellen, niet gedeactiveerde/rejected)
try {
    // Filter zowel 'rejected' als 'deactivated' (voor backwards compatibility)
    // Toon alleen modellen met status NULL, 'pending', of andere actieve statussen
    $sql = "SELECT * FROM Modelen WHERE COALESCE(Status, '') NOT IN ('rejected', 'deactivated')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $modellen = $stmt->fetchAll(PDO::FETCH_ASSOC); // associatief array
} catch (PDOException $e) {
    // Foutmelding als er iets misgaat
    die("Fout bij het ophalen van modellen: " . $e->getMessage());
}

// View laden
include "view/modellen-overzicht_view.php";
