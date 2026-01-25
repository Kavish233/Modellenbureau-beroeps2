<?php
session_start();
require 'config.php';

// Als gebruiker al ingelogd is, redirect naar home
if (isset($_SESSION['naam'])) {
    header('Location: home.php');
    exit;
}

$resultaat = "";
$isSuccess = false;

// Check of account is verwijderd
if (isset($_GET['deleted']) && $_GET['deleted'] == '1') {
    $resultaat = "Je account is succesvol verwijderd.";
    $isSuccess = true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['email'] ?? '';
    $wachtwoord = $_POST['password'] ?? '';

    if (strlen($naam) > 0 && strlen($wachtwoord) > 0) {
        $wwhash = sha1($wachtwoord);
        
        // Probeer eerst met SHA1 hash
        $query = "SELECT * FROM USERS WHERE Email= :nm AND wachtwoord= :pw";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':nm' => $naam,
            ':pw' => $wwhash
        ]);

        $resultaten = $stmt->fetchAll();

        // Als SHA1 niet werkt, probeer plain text (voor backwards compatibility)
        if (count($resultaten) == 0) {
            $query = "SELECT * FROM USERS WHERE Email= :nm AND wachtwoord= :pw";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':nm' => $naam,
                ':pw' => $wachtwoord  // Plain text
            ]);
            
            $resultaten = $stmt->fetchAll();
            
            // Als plain text werkt, update het wachtwoord naar SHA1 hash
            if (count($resultaten) > 0) {
                $updateQuery = "UPDATE USERS SET wachtwoord = :wwhash WHERE Email = :nm";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->execute([
                    ':wwhash' => $wwhash,
                    ':nm' => $naam
                ]);
            }
        }

        if (count($resultaten) > 0) {
            $_SESSION['naam'] = $naam;
            header('Location: home.php');
            exit;
        } else {
            $resultaat = "E-mailadres of wachtwoord onjuist";
        }
    } else {
        $resultaat = "Vul alle velden in";
    }
}

include "view/inlog_view.php";