<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profiel bewerken</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/profiel_bewerken.css">
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

        <!-- Desktop rechts -->
        <div class="nav-right">
            <a href="profiel_bewerken.php" style="text-decoration: none;">
                <div class="profile-circle">P</div>
            </a>
        </div>

        <!-- Mobile nav: hamburger links, profiel rechts -->
        <div class="mobile-nav">
            <div class="hamburger" id="hamburger">☰</div>
            <a href="profiel_bewerken.php" style="text-decoration: none;">
                <div class="profile-circle mobile-profile">P</div>
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

<div class="page">
    <?php if (!empty($melding)): ?>
        <div class="msg err"><?= htmlspecialchars($melding) ?></div>
    <?php endif; ?>

    <div class="grid">
        <!-- Linker card met profielfoto -->
        <div class="leftCard">
            <div class="avatar">
                <?php if (!empty($model['Foto'])): ?>
                    <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($model['Foto']) ?>" alt="Profielfoto">
                <?php else: ?>
                    <div style="width: 100%; height: 100%; background: #CFCFCF; display: flex; align-items: center; justify-content: center; color: #666;">Geen foto</div>
                <?php endif; ?>
            </div>
            <div class="leftTitle">Profielfoto</div>
            <div class="smallLabel">Upload een nieuwe foto</div>
        </div>

        <!-- Rechter card met formulier -->
        <div class="rightCard">
            <h2 style="margin-top: 0; margin-bottom: 18px;">Profiel bewerken</h2>
            
            <form method="post" enctype="multipart/form-data">
                <div class="field">
                    <label>Naam</label>
                    <input type="text" name="naam" class="input" value="<?= htmlspecialchars($user['naam'] ?? '') ?>" required>
                </div>

                <div class="field">
                    <label>Studentennummer</label>
                    <input type="text" class="input" value="<?= htmlspecialchars($user['Studentennummer'] ?? '') ?>" disabled style="background: #f0f0f0;">
                    <small style="font-size: 11px; color: #666;">Studentennummer kan niet worden gewijzigd</small>
                </div>

                <div class="field">
                    <label>Beschrijving</label>
                    <textarea name="beschrijving" class="input" rows="4"><?= htmlspecialchars($model['Beschrijving'] ?? '') ?></textarea>
                </div>

                <div class="field">
                    <label>Wijzig profielfoto</label>
                    <input type="file" name="Foto" accept="image/*" class="input" style="padding: 8px;">
                </div>

                <div class="saveWrap">
                    <button type="submit" class="btnSave">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>