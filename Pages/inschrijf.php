<?php
session_start();
require 'config.php'; // PDO $conn

// Check of gebruiker is ingelogd
if (!isset($_SESSION['naam'])) {
    header('Location: inlog.php');
    exit;
}

// Haal user data op voor profielfoto en naam
$email = $_SESSION['naam'];
$sql = "SELECT ProfielFoto, naam FROM USERS WHERE Email = :email";
$stmt = $conn->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();
$profielFoto = $user['ProfielFoto'] ?? null;

$melding = ""; // Om fouten te tonen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Email komt uit sessie (gebruiker is al ingelogd)
    $email = $_SESSION['naam'];
    
    // 1️⃣ Controleer of de gebruiker bestaat in USERS
    $stmt = $conn->prepare("SELECT * FROM USERS WHERE Email = :email");
    $stmt->execute([':email' => $email]);
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gebruiker) {
        // Als gebruiker niet bestaat, log uit en redirect naar inlog
        session_destroy();
        header("Location: inlog.php");
        exit();
    }

    $user_id = $gebruiker['User_ID'];

    // 2️⃣ Controleer of er al een volledig modelprofiel bestaat (met leeftijd en lengte)
    // Dit voorkomt dat lege profielen die via profiel_bewerken zijn aangemaakt worden geteld
    // Een volledig profiel heeft minimaal leeftijd en lengte (verplichte velden in inschrijf formulier)
    $stmt = $conn->prepare("SELECT * FROM Modelen WHERE User_ID = :user_id AND Leeftijd IS NOT NULL AND Lengte IS NOT NULL");
    $stmt->execute([':user_id' => $user_id]);
    $bestaandProfiel = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($bestaandProfiel) {
        $melding = "Je hebt al een modelprofiel aangemaakt!";
    } else {
        // Als er een leeg profiel bestaat (aangemaakt via profiel_bewerken zonder leeftijd/lengte), verwijder het eerst
        $stmt = $conn->prepare("DELETE FROM Modelen WHERE User_ID = :user_id AND (Leeftijd IS NULL OR Lengte IS NULL)");
        $stmt->execute([':user_id' => $user_id]);
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

        // 5️⃣ Voeg profiel toe aan Modelen tabel (inclusief voornaam in nieuwe kolom)
        if (empty($melding)) {
            $stmt = $conn->prepare("
                INSERT INTO Modelen (User_ID, Foto, Beschrijving, Leeftijd, Lengte, Opleiding, Status, Voornaam)
                VALUES (:user_id, :foto, :beschrijving, :leeftijd, :lengte, :opleiding, 'pending', :voornaam)
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':foto' => $fotoNaam,
                ':beschrijving' => $beschrijving,
                ':leeftijd' => $leeftijd,
                ':lengte' => $lengte,
                ':opleiding' => $opleiding,
                ':voornaam' => $voornaam
            ]);

            // 6️⃣ Redirect naar home pagina na succes
            header("Location: home.php");
            exit();
        }
    }
}

// 7️⃣ Toon eventuele foutmelding boven het formulier
if (!empty($melding)) {
    echo "<p style='color:red;'>$melding</p>";
}

include "view/inschrijf_view.php";
?>
