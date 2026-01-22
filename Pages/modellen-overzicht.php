<?php
// foutmeldingen zichtbaar
ini_set('display_errors', 1);
error_reporting(E_ALL);

// database connectie
require 'config.php'; // PDO $conn

// modellen ophalen
$sql = "SELECT * FROM Modelen";
$stmt = $conn->prepare($sql);
$stmt->execute();
$modellen = $stmt->fetchAll();

// view laden
include "view/modellen-overzicht_view.php";
