<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profiel bewerken</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/profiel_bewerken.css">
    <script src="/beroeps/Modellenbureau/Script/menu.js" defer></script>

    <style>
        body { font-family: Arial, sans-serif; background-color: #f2f2f2; }
        .container { display: flex; max-width: 900px; margin: 40px auto; gap: 30px; }
        .left { flex: 1; }
        .right { flex: 2; background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        img { width: 200px; height: auto; border-radius: 6px; margin-bottom: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"], textarea { width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
        button { margin-top: 15px; padding: 10px 20px; border: none; border-radius: 4px; background: #007bff; color: #fff; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<header>
    <nav class="nav">
        <!-- Desktop links -->
        <div class="nav-left">
            <a href="#">Home</a>
            <a href="#">Inschrijven</a>
            <a href="#">Modellen zoeken</a>
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
    <div class="left">
        <h2>Huidige Profielfoto</h2>
        <?php if (!empty($model['Foto'])): ?>
            <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($model['Foto']) ?>" alt="Profielfoto">
        <?php else: ?>
            <img src="/beroeps/Modellenbureau/Pages/uploads/placeholder.jpg" alt="Geen foto">
        <?php endif; ?>
    </div>

    <div class="right">
        <h2>Profiel Bewerken</h2>
        <form method="post" enctype="multipart/form-data">
            <label>Naam / Beschrijving</label>
            <textarea name="Beschrijving" rows="2"><?= htmlspecialchars($model['Beschrijving']) ?></textarea>

            <label>Studentnummer</label>
            <input type="text" name="User_ID" value="<?= htmlspecialchars($model['User_ID']) ?>">

            <label>Lengte (cm)</label>
            <input type="text" name="Lengte" value="<?= htmlspecialchars($model['Lengte']) ?>">

            <label>Opleiding</label>
            <input type="text" name="Opleiding" value="<?= htmlspecialchars($model['Opleiding']) ?>">

            <label>Wijzig profielfoto</label>
            <input type="file" name="Foto" accept="image/*">

            <button type="submit">Opslaan</button>
        </form>
    </div>
</div>

</body>
</html>