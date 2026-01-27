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
        'Opleiding' => '',
        'Status' => null
    ];
}

$melding = "";
$meldingType = ""; // 'ok' of 'err'

// Toon melding als account is gedeactiveerd
if (isset($_GET['deactivated']) && $_GET['deactivated'] == '1') {
    $melding = "✓ Je account is succesvol gedeactiveerd. Je modelprofiel is niet meer zichtbaar op de modellen-overzicht pagina.";
    $meldingType = "ok";
}

// Toon melding als account is geactiveerd
if (isset($_GET['activated']) && $_GET['activated'] == '1') {
    $melding = "✓ Je account is succesvol geactiveerd. Je modelprofiel is weer zichtbaar op de modellen-overzicht pagina.";
    $meldingType = "ok";
}

// Handle account deactiveren
if (isset($_GET['action']) && $_GET['action'] === 'deactivate_account') {
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Zet Status op 'rejected' in Modelen tabel
        if ($model['Profiel_ID']) {
            $deactivateModel = "UPDATE Modelen SET Status = 'rejected' WHERE User_ID = :user_id";
            $stmt = $conn->prepare($deactivateModel);
            $stmt->execute(['user_id' => $user_id]);
        } else {
            // Als er nog geen modelprofiel is, maak er een aan met status rejected
            $insert = "INSERT INTO Modelen (User_ID, Status) VALUES (:user_id, 'rejected')";
            $stmt = $conn->prepare($insert);
            $stmt->execute(['user_id' => $user_id]);
        }
        
        // Redirect terug naar profiel pagina met melding
        header('Location: profiel_bewerken.php?deactivated=1');
        exit;
    }
}

// Handle account activeren
if (isset($_GET['action']) && $_GET['action'] === 'activate_account') {
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Zet Status op 'pending' in Modelen tabel
        if ($model['Profiel_ID']) {
            $activateModel = "UPDATE Modelen SET Status = 'pending' WHERE User_ID = :user_id";
            $stmt = $conn->prepare($activateModel);
            $stmt->execute(['user_id' => $user_id]);
        } else {
            // Als er nog geen modelprofiel is, maak er een aan met status pending
            $insert = "INSERT INTO Modelen (User_ID, Status) VALUES (:user_id, 'pending')";
            $stmt = $conn->prepare($insert);
            $stmt->execute(['user_id' => $user_id]);
        }
        
        // Redirect terug naar profiel pagina met melding
        header('Location: profiel_bewerken.php?activated=1');
        exit;
    }
}

// Handle account verwijderen
if (isset($_GET['action']) && $_GET['action'] === 'delete_account') {
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Verwijder eerst modelprofiel als het bestaat
        if ($model['Profiel_ID']) {
            $deleteModel = "DELETE FROM Modelen WHERE User_ID = :user_id";
            $stmt = $conn->prepare($deleteModel);
            $stmt->execute(['user_id' => $user_id]);
        }
        
        // Verwijder gebruiker
        $deleteUser = "DELETE FROM USERS WHERE User_ID = :user_id";
        $stmt = $conn->prepare($deleteUser);
        $stmt->execute(['user_id' => $user_id]);
        
        // Vernietig sessie en redirect naar inlog
        session_destroy();
        header('Location: inlog.php?deleted=1');
        exit;
    }
}

// Handle uitloggen
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: inlog.php');
    exit;
}

// Check of formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = trim($_POST['naam'] ?? '');
    $beschrijving = trim($_POST['beschrijving'] ?? '');
    
    // Update naam in USERS tabel (alleen als naam is ingevuld)
    if (!empty($naam)) {
        $updateUser = "UPDATE USERS SET naam = :naam WHERE User_ID = :user_id";
        $stmt = $conn->prepare($updateUser);
        $stmt->execute([
            'naam' => $naam,
            'user_id' => $user_id
        ]);
    }

    // Profielfoto upload (voor USERS tabel)
    $profielFotoPath = $user['ProfielFoto'] ?? null; // behoud oude foto standaard
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
            $profielFotoPath = "uploads/" . $fileName;
            
            // Update profielfoto in USERS tabel
            $updateProfielFoto = "UPDATE USERS SET ProfielFoto = :profiel_foto WHERE User_ID = :user_id";
            $stmt = $conn->prepare($updateProfielFoto);
            $stmt->execute([
                'profiel_foto' => $profielFotoPath,
                'user_id' => $user_id
            ]);
        } else {
            $melding = "Fout bij het uploaden van de foto.";
        }
    }

    // Alleen bestaand modelprofiel bijwerken (geen nieuw profiel automatisch aanmaken)
    if ($model['Profiel_ID']) {
        $update = "UPDATE Modelen SET Beschrijving = :beschrijving WHERE Profiel_ID = :profiel_id";
        $stmt = $conn->prepare($update);
        $stmt->execute([
            'beschrijving' => $beschrijving,
            'profiel_id' => $model['Profiel_ID']
        ]);
    }

    // Herladen van het profiel - haal user opnieuw op om nieuwe profielfoto te krijgen
    $sql = "SELECT * FROM USERS WHERE Email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    
    header("Location: profiel_bewerken.php");
    exit;
}

// Herhaal model ophalen na eventuele updates (voor status)
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
        'Opleiding' => '',
        'Status' => null
    ];
}

// Bepaal of account gedeactiveerd is
$isDeactivated = isset($model['Status']) && $model['Status'] === 'rejected';

// View laden met user en model data
include "view/profiel_bewerken_view.php";
