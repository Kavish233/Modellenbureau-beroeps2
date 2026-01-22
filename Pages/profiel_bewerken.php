<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';

// Check of gebruiker is ingelogd
if (!isset($_SESSION['naam'])) {
    header('Location: inlog.php');
    exit;
}

// Haal user ID op basis van email uit sessie
$email = $_SESSION['naam'];
$sql = "SELECT * FROM USERS WHERE Email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

if (!$user) {
    die("Gebruiker niet gevonden.");
}

$user_id = $user['User_ID'];

// Profiel ophalen uit Modelen tabel
$sql = "SELECT * FROM Modelen WHERE User_ID = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$model = $stmt->fetch();

// Als er nog geen modelprofiel is, maak een lege array
if (!$model) {
    $model = [
        'Profiel_ID' => null,
        'Foto' => null,
        'Beschrijving' => '',
        'Leeftijd' => null,
        'Lengte' => null,
        'Opleiding' => ''
    ];
}

$melding = "";

// Check of formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $beschrijving = trim($_POST['beschrijving'] ?? '');
    
    // Update naam in USERS tabel
    if (!empty($naam)) {
        $updateUser = "UPDATE USERS SET naam = :naam WHERE User_ID = :user_id";
        $stmt = $conn->prepare($updateUser);
        $stmt->execute([
            'naam' => $naam,
            'user_id' => $user_id
        ]);
    }

    // Profielfoto upload
    $fotoPath = $model['Foto']; // behoud oude foto standaard
    if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/uploads/";
        
        // Maak uploads directory aan als deze niet bestaat
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ext = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $ext;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['Foto']['tmp_name'], $uploadPath)) {
            $fotoPath = "uploads/" . $fileName;
        } else {
            $melding = "Fout bij het uploaden van de foto.";
        }
    }

    // Update of insert modelprofiel
    if ($model['Profiel_ID']) {
        // Update bestaand profiel
        $update = "UPDATE Modelen SET Beschrijving = :beschrijving, Foto = :foto WHERE Profiel_ID = :profiel_id";
        $stmt = $conn->prepare($update);
        $stmt->execute([
            'beschrijving' => $beschrijving,
            'foto' => $fotoPath,
            'profiel_id' => $model['Profiel_ID']
        ]);
    } else {
        // Maak nieuw profiel aan
        $insert = "INSERT INTO Modelen (User_ID, Foto, Beschrijving, Status) VALUES (:user_id, :foto, :beschrijving, 'pending')";
        $stmt = $conn->prepare($insert);
        $stmt->execute([
            'user_id' => $user_id,
            'foto' => $fotoPath,
            'beschrijving' => $beschrijving
        ]);
    }

    // Herladen van het profiel
    header("Location: profiel_bewerken.php");
    exit;
}

// View laden met user en model data
include "view/profiel_bewerken_view.php";
