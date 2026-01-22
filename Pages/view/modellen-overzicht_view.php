<?php
// Bepaal het pad naar de uploads-map
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Modellen Overzicht</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/modellen-overzicht.css">

</head>
<body>

<div class="container">
    <h1>Modellen Overzicht</h1>

    <?php if (empty($modellen)): ?>
        <p>Geen modellen gevonden.</p>
    <?php else: ?>
        <?php foreach ($modellen as $model): ?>
            <div class="model-card">

                <?php if (!empty($model['Foto'])): ?>
                    <img src="<?= $uploadsPath . htmlspecialchars(basename($model['Foto'])) ?>" alt="Model foto">
                <?php else: ?>
                    <img src="<?= $uploadsPath ?>placeholder.jpg" alt="Geen foto">
                <?php endif; ?>

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
