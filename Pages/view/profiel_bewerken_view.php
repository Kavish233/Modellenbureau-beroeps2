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

        <?php
        // Eerste letter van de naam voor in de profielcirkel
        $initial = strtoupper($user['naam'][0] ?? 'P');
        ?>

        <!-- Desktop rechts -->
        <div class="nav-right">
            <a href="profiel_bewerken.php" style="text-decoration: none;">
                <div class="profile-circle">
                    <?php if (!empty($user['ProfielFoto'])): ?>
                        <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($user['ProfielFoto']) ?>" alt="Profielfoto">
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
                    <?php if (!empty($user['ProfielFoto'])): ?>
                        <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($user['ProfielFoto']) ?>" alt="Profielfoto">
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

<div class="page">
    <?php if (!empty($melding)): ?>
        <div class="msg <?= !empty($meldingType) ? $meldingType : 'err' ?>"><?= htmlspecialchars($melding) ?></div>
    <?php endif; ?>

    <div class="grid">
        <!-- Linker card met profielfoto -->
        <div class="leftCard">
            <div class="avatar">
                <?php if (!empty($user['ProfielFoto'])): ?>
                    <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($user['ProfielFoto']) ?>" alt="Profielfoto" id="profileImage">
                <?php else: ?>
                    <div style="width: 100%; height: 100%; background: #CFCFCF; display: flex; align-items: center; justify-content: center; color: #666;">Geen foto</div>
                <?php endif; ?>
            </div>
            <div class="leftTitle">Profielfoto</div>
            
            <div class="leftBtns">
                <!-- Formulier voor alleen foto upload -->
                <form id="fotoForm" method="post" enctype="multipart/form-data" style="display: none;">
                    <input type="file" name="Foto" accept="image/*" id="hiddenFotoInput" onchange="this.form.submit();">
                </form>
                
                <button type="button" class="btnMini" onclick="document.getElementById('hiddenFotoInput').click();">Profielfoto wijzigen</button>
                
                <div class="divider"></div>
                
                <?php if ($isDeactivated): ?>
                    <button type="button" class="btnMini btnActivate" onclick="if(confirm('✓ Account activeren\n\nWeet je zeker dat je je account wilt activeren?\n\n• Je modelprofiel wordt weer zichtbaar op de modellen-overzicht pagina')) { window.location.href='profiel_bewerken.php?action=activate_account&confirm=yes'; }">Account activeren</button>
                <?php else: ?>
                    <button type="button" class="btnMini" onclick="if(confirm('⚠️ Account deactiveren\n\nWeet je zeker dat je je account wilt deactiveren?\n\n• Je modelprofiel zal niet meer zichtbaar zijn op de modellen-overzicht pagina\n• Je kunt later altijd je account weer activeren\n• Je blijft ingelogd en kunt je profiel bewerken')) { window.location.href='profiel_bewerken.php?action=deactivate_account&confirm=yes'; }">Account deactiveren</button>
                <?php endif; ?>
                
                <button type="button" class="btnMini" onclick="if(confirm('🗑️ Account verwijderen\n\nWAARSCHUWING: Deze actie kan NIET ongedaan worden gemaakt!\n\n• Je account en alle gegevens worden permanent verwijderd\n• Je modelprofiel wordt verwijderd\n• Je wordt uitgelogd\n\nWeet je zeker dat je door wilt gaan?')) { window.location.href='profiel_bewerken.php?action=delete_account&confirm=yes'; }">Account verwijderen</button>
                
                <a href="profiel_bewerken.php?action=logout" class="btnMini" onclick="return confirm('Weet je zeker dat je wilt uitloggen?');">Uitloggen</a>
            </div>
        </div>

        <!-- Rechter card met formulier -->
        <div class="rightCard">
            <h2 style="margin-top: 0; margin-bottom: 18px;">Profiel bewerken</h2>
            
            <form method="post" enctype="multipart/form-data">

                <div class="field">
                    <label>Studentennummer</label>
                    <input type="text" class="input" value="<?= htmlspecialchars($user['Studentennummer'] ?? '') ?>" disabled style="background: #f0f0f0;">
                    <small style="font-size: 11px; color: #666;">Studentennummer kan niet worden gewijzigd</small>
                </div>

                <?php if ($hasFullModelProfile): ?>
                    <!-- Modelprofiel velden - alleen zichtbaar als je een volledig modelprofiel hebt -->
                    <div class="field">
                        <label>naam</label>
                        <input type="text" name="voornaam" class="input" value="<?= htmlspecialchars($model['voornaam'] ?? '') ?>">
                    </div>

                    <div class="field">
                        <label>Leeftijd</label>
                        <input type="number" name="leeftijd" class="input" value="<?= htmlspecialchars($model['Leeftijd'] ?? '') ?>" min="0">
                    </div>

                    <div class="field">
                        <label>Lengte (cm)</label>
                        <input type="number" name="lengte" class="input" value="<?= htmlspecialchars($model['Lengte'] ?? '') ?>" min="0">
                    </div>

                    <div class="field">
                        <label>Model-foto</label>
                        <?php if (!empty($model['Foto'])): ?>
                            <div style="margin-bottom: 10px;">
                                <img src="/beroeps/Modellenbureau/Pages/<?= htmlspecialchars($model['Foto']) ?>" alt="Model foto" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="model_foto" accept="image/*" class="input">
                        <small style="font-size: 11px; color: #666;">Upload een nieuwe model-foto (optioneel)</small>
                    </div>

                    <div class="field">
                        <label>Opleiding</label>
                        <input type="text" class="input" value="<?= htmlspecialchars($model['Opleiding'] ?? '') ?>" disabled style="background: #f0f0f0;">
                        <small style="font-size: 11px; color: #666;">Opleiding kan niet worden gewijzigd</small>
                    </div>
                <?php endif; ?>

                <div class="field">
                    <label>Beschrijving</label>
                    <textarea name="beschrijving" class="input" rows="4"><?= htmlspecialchars($model['Beschrijving'] ?? '') ?></textarea>
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