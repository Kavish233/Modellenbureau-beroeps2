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

<div class="page">
    <div class="frame">
        <div class="grid">

            <!-- LINKS -->
            <div class="leftCard">
                <div class="avatar">
                    <?php if ($foto !== ''): ?>
                        <img src="<?= e($foto) ?>" alt="Profielfoto">
                    <?php endif; ?>
                </div>

                <div class="leftTitle"><?= e($model['naam'] ?? 'volledige naam') ?></div>
                <div class="smallLabel"><?= e($model['studentnummer'] ?? 'Studentnummer') ?></div>

                <div class="leftBtns">
                    <!-- Deze links kunnen je teamgenoot later koppelen -->
                    <a class="btnMini" href="profielfoto_wijzigen.php">Profielfoto wijzigen</a>
                    <a class="btnMini" href="#beschrijving">Beschrijving aanpassen</a>
                </div>

                <div class="divider"></div>

                <!-- Account verwijderen -->
                <a class="btnDanger" href="account_verwijderen.php"
                   onclick="return confirm('Weet je zeker dat je je account wilt verwijderen? Dit kan niet ongedaan gemaakt worden.');">
                    Account verwijderen
                </a>
            </div>

            <!-- RECHTS -->
            <div class="rightCard">
                <?php if ($success): ?>
                    <div class="msg ok">Opgeslagen.</div>
                <?php elseif ($errorMsg !== ''): ?>
                    <div class="msg err"><?= e($errorMsg) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="field">
                        <label for="naam">Naam</label>
                        <input class="input" id="naam" name="naam" type="text" value="<?= e((string)$model['naam']) ?>" required>
                    </div>

                    <div class="field">
                        <label for="studentnummer">Studentnummer</label>
                        <input class="input" id="studentnummer" name="studentnummer" type="text" value="<?= e((string)$model['studentnummer']) ?>" required>
                    </div>

                    <div class="field" id="beschrijving">
                        <label for="beschrijving">Beschrijving</label>
                        <textarea class="input" id="beschrijving" name="beschrijving"><?= e((string)($model['beschrijving'] ?? '')) ?></textarea>
                    </div>

                    <div class="saveWrap">
                        <button class="btnSave" type="submit">Opslaan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>