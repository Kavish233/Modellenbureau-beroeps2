<?php

include "view/registreren_view.php";

require 'config.php';

$resultaat = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $studentennummer = $_POST['studentennummer'];
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['password'];

    if (!empty($studentennummer) && !empty($naam) && !empty($email) && !empty($wachtwoord)) {

        // Check of email al bestaat
        $checkQuery = "SELECT User_ID FROM USERS WHERE Email = :email";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->execute([':email' => $email]);

        if ($checkStmt->rowCount() > 0) {
            $resultaat = "Dit e-mailadres bestaat al";
        } else {

            // Wachtwoord veilig hashen
            $wwhash = password_hash($wachtwoord, PASSWORD_DEFAULT);

            // User toevoegen
            $insertQuery = "
                INSERT INTO USERS (Studentennummer, Naam, Email, Wachtwoord, Rol, Status)
                VALUES (:studentennummer, :naam, :email, :wachtwoord, 'model', 'pending')
            ";

            $stmt = $conn->prepare($insertQuery);
            $stmt->execute([
                ':studentennummer' => $studentennummer,
                ':naam' => $naam,
                ':email' => $email,
                ':wachtwoord' => $wwhash
            ]);

            header('Location: inlog.php');
            exit;
        }

    } else {
        $resultaat = "Vul alle velden in";
    }
}

