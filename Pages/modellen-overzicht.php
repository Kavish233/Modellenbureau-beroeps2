<?php
session_start();
// modellen-overzicht.php

// Foutmeldingen zichtbaar maken (alleen voor ontwikkeling)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connectie
require 'config.php'; // Zorg dat $conn (PDO) hier beschikbaar is

// Haal user data op voor profielfoto en rol (als ingelogd)
$profielFoto = null;
$isDocent = false;
if (isset($_SESSION['naam'])) {
    $email = $_SESSION['naam'];
    $sql = "SELECT ProfielFoto, rol FROM USERS WHERE Email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    $profielFoto = $user['ProfielFoto'] ?? null;
    $isDocent = ($user['rol'] ?? '') === 'docent';
}

// Handle verwijder model (alleen voor docenten)
if ($isDocent && isset($_GET['action']) && $_GET['action'] === 'delete_model') {
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes' && isset($_GET['id'])) {
        $modelId = (int)$_GET['id'];
        try {
            // Verwijder model uit Modelen tabel
            $deleteModel = "DELETE FROM Modelen WHERE Profiel_ID = :profiel_id";
            $stmt = $conn->prepare($deleteModel);
            $stmt->execute(['profiel_id' => $modelId]);
            
            // Redirect terug met succesmelding
            header('Location: modellen-overzicht.php?deleted=1');
            exit;
        } catch (PDOException $e) {
            // Foutmelding als er iets misgaat
            $deleteError = "Fout bij het verwijderen van het model: " . $e->getMessage();
        }
    }
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
