<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';

// Voor demo: user ID hardcoded, meestal komt dit uit de sessie
$user_id = 1;

// Profiel ophalen
$sql = "SELECT * FROM Modelen WHERE User_ID = :user_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$model = $stmt->fetch();

if (!$model) {
    die("Profiel niet gevonden.");
}

// Check of formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['Beschrijving'] ?? '';
    $studentnummer = $_POST['User_ID'] ?? '';
    $lengte = $_POST['Lengte'] ?? '';
    $opleiding = $_POST['Opleiding'] ?? '';

    // Profielfoto upload
    if (isset($_FILES['Foto']) && $_FILES['Foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['Foto']['tmp_name'];
        $fileName = uniqid() . "_" . basename($_FILES['Foto']['name']);
        $uploadDir = __DIR__ . "/uploads/";
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $uploadPath)) {
            $fotoPath = "uploads/" . $fileName;
        } else {
            $fotoPath = $model['Foto']; // hou oude foto
        }
    } else {
        $fotoPath = $model['Foto']; // hou oude foto
    }

    // Update profiel
    $update = "UPDATE Modelen SET Beschrijving = :beschrijving, User_ID = :studentnummer, Lengte = :lengte, Opleiding = :opleiding, Foto = :foto WHERE Profiel_ID = :profiel_id";
    $stmt = $conn->prepare($update);
    $stmt->execute([
        'beschrijving' => $naam,
        'studentnummer' => $studentnummer,
        'lengte' => $lengte,
        'opleiding' => $opleiding,
        'foto' => $fotoPath,
        'profiel_id' => $model['Profiel_ID']
    ]);

    // Herladen van het profiel
    header("Location: profiel_bewerken.php");
    exit;
}

// View laden
include "view/profiel_bewerken_view.php";
