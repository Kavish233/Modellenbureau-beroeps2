<!DOCTYPE html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <title>Model detail</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/modellen-detail.css?v=1">
    <script src="/beroeps/Modellenbureau/Script/menu.js" defer></script>
</head>
<body>

<header>
    <nav class="nav">
        <div class="nav-left">
            <a href="home.php">Home</a>
            <a href="inschrijf.php">Inschrijven</a>
            <a href="modellen-overzicht.php">Modellen zoeken</a>
        </div>

        <?php
        // Eerste letter van de naam voor in de profielcirkel
        $initial = strtoupper($user['naam'][0] ?? 'P');
        ?>

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

    <div class="mobile-menu" id="mobileMenu">
        <a href="home.php">Home</a>
        <a href="inschrijf.php">Inschrijven</a>
        <a href="modellen-overzicht.php">Modellen zoeken</a>
    </div>
</header>

<div class="detail-page">

    <div class="detail-card">

        <div class="detail-left">
            <img class="detail-photo" src="<?= $fotoUrl ?>" alt="Model foto">
        </div>

        <div class="detail-right">
            <div class="name-pill">
                <?= htmlspecialchars($model['voornaam'] ?? 'Model') ?>
            </div>

            <div class="stats-box">
                <div class="stat">
                    <div class="stat-label">Lengte</div>
                    <div class="stat-value"><?= htmlspecialchars((string)($model['Lengte'] ?? '—')) ?> cm</div>
                </div>

                <div class="stat">
                    <div class="stat-label">Leeftijd</div>
                    <div class="stat-value"><?= htmlspecialchars((string)($model['Leeftijd'] ?? '—')) ?> jaar</div>
                </div>

                <div class="stat-wide">
                    <div class="stat-label">Opleiding</div>
                    <div class="stat-value"><?= htmlspecialchars((string)($model['Opleiding'] ?? '—')) ?></div>
                </div>
            </div>

            <div class="desc-box">
                <?= nl2br(htmlspecialchars((string)($model['Beschrijving'] ?? ''))) ?>
            </div>

            <a class="back-link" href="modellen-overzicht.php">← Terug naar modellen</a>
        </div>

    </div>

</div>

</body>
</html>

