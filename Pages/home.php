<?php
session_start();
require 'config.php';

$resultaat = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['email'];
    $wachtwoord = $_POST['password'];

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
            header('Location: agenda.php');
            exit;
        } else {
            $resultaat = "Naam of wachtwoord onjuist";
        }
    } else {
        $resultaat = "Vul alle velden in";
    }
}

// Pas hier pas je view includen
include "view/home_view.php";
