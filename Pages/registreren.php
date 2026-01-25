<?php
session_start();
require 'config.php'; // Zorg dat $conn hier staat

// Als gebruiker al ingelogd is, redirect naar home
if (isset($_SESSION['naam'])) {
    header('Location: home.php');
    exit;
}

$melding = "";

$prefillEmail = '';
$prefillName = '';

// Prefill vanuit inschrijf.php (1x gebruiken)
if (!empty($_SESSION['registreren_prefill']) && is_array($_SESSION['registreren_prefill'])) {
    $prefillEmail = trim($_SESSION['registreren_prefill']['email'] ?? '');
    $prefillName = trim($_SESSION['registreren_prefill']['name'] ?? '');
    unset($_SESSION['registreren_prefill']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = trim($_POST['name']);
    $email = trim($_POST['email']);
    $studentennummer = trim($_POST['studentnummer']);
    $wachtwoord = $_POST['password'];

    // Als POST faalt, behoud ingevulde waarden in form
    $prefillEmail = $email;
    $prefillName = $naam;

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
