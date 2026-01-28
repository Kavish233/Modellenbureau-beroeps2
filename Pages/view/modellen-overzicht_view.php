<?php
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Modellen zoeken</title>

    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/modellen-overzicht.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="/beroeps/Modellenbureau/Script/menu.js" defer></script>
</head>
<body>

<header>
    <nav class="nav">
        <!-- Desktop links -->
        <div class="nav-left">
            <a href="home.php">Home</a>
            <a href="inschrijf.php">Inschrijven</a>
            <a href="modellen-overzicht.php">Modellen zoeken</a>
        </div>

        <?php
        // Eerste letter van de naam voor in de profielcirkel
        $initial = strtoupper($user['naam'][0] ?? 'P');
        ?>

        <!-- Desktop rechts -->
        <div class="nav-right">
            <a href="profiel_bewerken.php" style="text-decoration: none;">
                <div class="profile-circle">
                    <?php if (!empty($profielFoto)): ?>
                        <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($profielFoto) ?>" alt="Profielfoto">
                    <?php else: ?>
                        <?= $initial ?>
                    <?php endif; ?>
                </div>
            </a>
        </div>

        <!-- Mobile nav: hamburger links, profiel rechts -->
        <div class="mobile-nav">
            <div class="hamburger" id="hamburger">☰</div>
            <a href="profiel_bewerken.php" style="text-decoration: none;">
                <div class="profile-circle mobile-profile">
                    <?php if (!empty($profielFoto)): ?>
                        <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($profielFoto) ?>" alt="Profielfoto">
                    <?php else: ?>
                        <?= $initial ?>
                    <?php endif; ?>
                </div>
            </a>
        </div>
    </nav>

    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="home.php">Home</a>
        <a href="inschrijf.php">Inschrijven</a>
        <a href="modellen-overzicht.php">Modellen zoeken</a>
    </div>
</header>

<div class="container">
    <h1>Modellen zoeken</h1>

    <?php if (empty($modellen)): ?>
        <p>Geen modellen gevonden.</p>
    <?php else: ?>
        <div class="models-grid">
            <?php foreach ($modellen as $model): ?>

                <?php
                // Jij hebt uploadsPath al in je PHP gezet:
                // $uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";

                // In DB kan Foto een bestandsnaam zijn of (sub)pad.
                // We bouwen een browser-url + checken of het bestand echt bestaat:
                $fotoRel = $model['Foto'] ?? '';

                if (!empty($fotoRel) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/beroeps/Modellenbureau/Pages/' . $fotoRel)) {
                    $fotoUrl = '/beroeps/Modellenbureau/Pages/' . htmlspecialchars($fotoRel);
                } else {
                    $fotoUrl = $uploadsPath . 'placeholder.jpg';
                }

                // Tekst onder foto: eerst voornaam (nieuwe kolom), anders Beschrijving
                $kaartNaam = $model['voornaam'] ?? ($model['Beschrijving'] ?? 'Model');
                ?>

                <div class="model-tile">
                    <div class="model-image">
                        <img src="<?= $fotoUrl ?>" alt="Model foto">
                    </div>

                    <div class="model-name">
                        <?= htmlspecialchars($kaartNaam) ?>
                    </div>

                    <a class="model-btn" href="modellen-detail.php?id=<?= (int)$model['Profiel_ID'] ?>">
                        Bekijk profiel
                    </a>

                    <?php if ($isDocent): ?>
                        <button class="model-btn-delete" onclick="if(confirm('⚠️ Model verwijderen\n\nWeet je zeker dat je dit model wilt verwijderen?\n\n• Dit modelprofiel wordt permanent verwijderd\n• Deze actie kan niet ongedaan worden gemaakt\n\nWeet je zeker dat je door wilt gaan?')) { window.location.href='modellen-overzicht.php?action=delete_model&confirm=yes&id=<?= (int)$model['Profiel_ID'] ?>'; }">
                            Verwijder model
                        </button>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
