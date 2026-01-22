<?php
// Bepaal het pad naar de uploads-map
$uploadsPath = "/beroeps/Modellenbureau/Pages/uploads/";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Modellen Overzicht</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        .model-card {
            background: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            border-radius: 6px;
        }
        .model-card img {
            width: 150px;
            border-radius: 4px;
        }
        .model-info p {
            margin: 5px 0;
        }
    </style>
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
