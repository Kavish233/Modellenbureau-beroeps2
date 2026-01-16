<?php
session_start();
require 'config.php'; // Zorg dat $conn hier staat

$melding = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = trim($_POST['name']);
    $email = trim($_POST['email']);
    $studentennummer = trim($_POST['studentnummer']);
    $wachtwoord = $_POST['password'];

    // Controleer of alle velden zijn ingevuld
    if (!empty($naam) && !empty($email) && !empty($studentennummer) && !empty($wachtwoord)) {

        // Controleer of e-mail al bestaat
        $stmt = $conn->prepare("SELECT * FROM USERS WHERE Email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() > 0) {
            $melding = "E-mail is al in gebruik!";
        } else {
            // Hash het wachtwoord (sha1 omdat je login dat ook gebruikt)
            $wwhash = sha1($wachtwoord);

            // Voeg gebruiker toe met rol 'model' en status 'pending'
            $stmt = $conn->prepare("INSERT INTO USERS (Studentennummer, naam, Email, wachtwoord, rol, Status)
                                    VALUES (:studentennummer, :naam, :email, :pw, 'model', 'pending')");

            $stmt->execute([
                ':studentennummer' => $studentennummer,
                ':naam' => $naam,
                ':email' => $email,
                ':pw' => $wwhash
            ]);

            // Redirect naar inlogpagina na succesvolle registratie
            header("Location: inlog.php");
            exit(); // Stop het script na redirect
        }
    } else {
        $melding = "Vul alle velden correct in!";
    }
}

// Als er iets misgaat, toon de view met foutmelding
include 'view/registreren_view.php';
?>
