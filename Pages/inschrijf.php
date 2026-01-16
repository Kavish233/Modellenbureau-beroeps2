<?php

include "view/inschrijf_view.php";

session_start();
require 'config.php'; // PDO $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    // Controleer of gebruiker al bestaat in USERS
    $stmt = $conn->prepare("SELECT * FROM USERS WHERE Email = :email");
    $stmt->execute([':email' => $email]);
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gebruiker) {
        // Geen account gevonden → redirect naar registratiepagina
        header("Location: registreren.php");
        exit();
    }

    // Vanaf hier mag je inschrijven als model
    $user_id = $gebruiker['User_ID'];
    $voornaam = trim($_POST['voornaam']);
    $achternaam = trim($_POST['achternaam']);
    $leeftijd = intval($_POST['leeftijd']);
    $lengte = intval($_POST['lengte']);
    $beschrijving = trim($_POST['beschrijving']);
    $opleiding = trim($_POST['opleiding']);

    // Foto uploaden
    $fotoNaam = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoNaam = 'uploads/' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/' . $fotoNaam);
    }

    // Controleer of er al een profiel is voor deze gebruiker
    $stmt = $conn->prepare("SELECT * FROM Modelen WHERE User_ID = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    if ($stmt->rowCount() > 0) {
        echo "Je hebt al een modelprofiel aangemaakt!";
        exit();
    }

    // Voeg profiel toe in Modelen tabel
    $stmt = $conn->prepare("INSERT INTO Modelen (User_ID, Foto, Beschrijving, Leeftijd, Lengte, Opleiding, Status)
                            VALUES (:user_id, :foto, :beschrijving, :leeftijd, :lengte, :opleiding, 'pending')");
    $stmt->execute([
        ':user_id' => $user_id,
        ':foto' => $fotoNaam,
        ':beschrijving' => $beschrijving,
        ':leeftijd' => $leeftijd,
        ':lengte' => $lengte,
        ':opleiding' => $opleiding
    ]);

    // Redirect naar loginpagina of bevestigingspagina
    header("Location: inlog.php");
    exit();
}
?>
