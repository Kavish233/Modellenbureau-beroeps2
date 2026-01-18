<?php
session_start();
require 'config.php'; // PDO $conn

// Include altijd het formulier view
include "view/inschrijf_view.php";

$melding = ""; // Om fouten te tonen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $melding = "Vul je e-mailadres in.";
    } else {
        // 1️⃣ Controleer of de gebruiker bestaat in USERS
        $stmt = $conn->prepare("SELECT * FROM USERS WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$gebruiker) {
            // Geen account → redirect naar registratiepagina
            header("Location: registreren.php");
            exit();
        }

        $user_id = $gebruiker['User_ID'];

        // 2️⃣ Controleer of er al een modelprofiel bestaat
        $stmt = $conn->prepare("SELECT * FROM Modelen WHERE User_ID = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        if ($stmt->rowCount() > 0) {
            $melding = "Je hebt al een modelprofiel aangemaakt!";
        } else {
            // 3️⃣ Verwerk formuliergegevens
            $voornaam = trim($_POST['voornaam'] ?? '');
            $achternaam = trim($_POST['achternaam'] ?? '');
            $leeftijd = intval($_POST['leeftijd'] ?? 0);
            $lengte = intval($_POST['lengte'] ?? 0);
            $beschrijving = trim($_POST['beschrijving'] ?? '');
            $opleiding = trim($_POST['opleiding'] ?? '');

            // 4️⃣ Foto uploaden
            $fotoNaam = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fotoNaam = 'uploads/' . uniqid() . '.' . $ext;

                if (!move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/' . $fotoNaam)) {
                    $melding = "Fout bij het uploaden van de foto!";
                }
            }

            // 5️⃣ Voeg profiel toe aan Modelen tabel
            if (empty($melding)) {
                $stmt = $conn->prepare("
                    INSERT INTO Modelen (User_ID, Foto, Beschrijving, Leeftijd, Lengte, Opleiding, Status)
                    VALUES (:user_id, :foto, :beschrijving, :leeftijd, :lengte, :opleiding, 'pending')
                ");
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':foto' => $fotoNaam,
                    ':beschrijving' => $beschrijving,
                    ':leeftijd' => $leeftijd,
                    ':lengte' => $lengte,
                    ':opleiding' => $opleiding
                ]);

                // 6️⃣ Redirect naar loginpagina na succes
                header("Location: home.php");
                exit();
            }
        }
    }
}

// 7️⃣ Toon eventuele foutmelding boven het formulier
if (!empty($melding)) {
    echo "<p style='color:red;'>$melding</p>";
}
?>
