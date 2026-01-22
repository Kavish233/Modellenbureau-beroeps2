<?php
session_start();
require 'config.php';

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
        $query = "SELECT * FROM USERS WHERE Email= :nm AND wachtwoord= :pw";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':nm' => $naam,
            ':pw' => $wwhash
        ]);

        $resultaten = $stmt->fetchAll();

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