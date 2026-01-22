<?php
// modellen-overzicht.php

// Foutmeldingen zichtbaar maken (alleen voor ontwikkeling)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connectie
require 'config.php'; // Zorg dat $conn (PDO) hier beschikbaar is

// Map waar de uploads staan (relatief aan de root van je project)
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";

// Modellen ophalen uit de database
try {
    $sql = "SELECT * FROM Modelen";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $modellen = $stmt->fetchAll(PDO::FETCH_ASSOC); // associatief array
} catch (PDOException $e) {
    // Foutmelding als er iets misgaat
    die("Fout bij het ophalen van modellen: " . $e->getMessage());
}

// View laden
include "view/modellen-overzicht_view.php";
