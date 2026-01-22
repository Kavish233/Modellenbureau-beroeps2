<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Modellen Overzicht</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/modellen-overzicht.css">
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

        <!-- Desktop rechts -->
        <div class="nav-right">
            <div class="profile-circle">P</div>
        </div>

        <!-- Mobile nav: hamburger links, profiel rechts -->
        <div class="mobile-nav">
            <div class="hamburger" id="hamburger">☰</div>
            <div class="profile-circle mobile-profile">P</div>
        </div>
    </nav>

    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#">Home</a>
        <a href="#">Inschrijven</a>
        <a href="#">Modellen zoeken</a>
    </div>
</header>

<div class="container">
    <h1>Modellen Overzicht</h1>

    <?php if (empty($modellen)): ?>
        <p>Geen modellen gevonden.</p>
    <?php else: ?>
        <?php foreach ($modellen as $model): ?>
            <div class="model-card">

                <?php
                // Controleer of er een foto is, anders fallback
                $fotoPad = (!empty($model['Foto']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/beroeps/Modellenbureau/Pages/' . $model['Foto']))
                    ? '/beroeps/Modellenbureau/Pages/' . htmlspecialchars($model['Foto'])
                    : '/beroeps/Modellenbureau/Pages/uploads/placeholder.jpg';
                ?>
                <img src="<?= $fotoPad ?>" alt="Model foto">

                <div class="model-info">
                    <p><strong>Profiel ID:</strong> <?= htmlspecialchars($model['Profiel_ID']) ?></p>
                    <p><strong>Beschrijving:</strong> <?= htmlspecialchars($model['Beschrijving']) ?></p>
                    <p><strong>Leeftijd:</strong> <?= htmlspecialchars($model['Leeftijd']) ?></p>
                    <p><strong>Lengte:</strong> <?= htmlspecialchars($model['Lengte']) ?> cm</p>
                    <p><strong>Opleiding:</strong> <?= htmlspecialchars($model['Opleiding']) ?></p>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
