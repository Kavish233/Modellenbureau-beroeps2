<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schrijf je in als model</title>

    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/inschrijf.css">
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
        <a href="home.php">Home</a>
        <a href="inschrijf.php">Inschrijven</a>
        <a href="modellen-overzicht.php">Modellen zoeken</a>
    </div>
</header>

<div class="register-page">

    <h1>Schrijf je in als model</h1>

    <div class="register-container">

        <div class="info-box">
            <div class="info-icon">i</div>
            <p>
                Je inschrijving wordt beoordeeld door een docent voordat deze wordt goedgekeurd.
            </p>
            <p>
                Alleen studenten van het Grafisch Lyceum Rotterdam kunnen zich registreren als model.
            </p>


        </div>

        <form class="register-form" action="inschrijf.php" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="form-group">
                    <label for="voornaam">Voornaam</label>
                    <input type="text" id="voornaam" name="voornaam" required>
                </div>

                <div class="form-group">
                    <label for="achternaam">Achternaam</label>
                    <input type="text" id="achternaam" name="achternaam" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="leeftijd">Leeftijd</label>
                    <input type="number" id="leeftijd" name="leeftijd" required>
                </div>

                <div class="form-group">
                    <label for="lengte">Lengte (cm)</label>
                    <input type="number" id="lengte" name="lengte" required>
                </div>
            </div>

            <div class="form-group">
                <label for="beschrijving">Korte beschrijving</label>
                <textarea id="beschrijving" name="beschrijving" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="foto">Foto uploaden</label>
                <input type="file" id="foto" name="foto" accept="image/*">
            </div>

            <div class="form-group">
                <label for="opleiding">Opleiding</label>
                <input type="text" id="opleiding" name="opleiding">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>

            <button type="submit" class="submit-btn">Schrijf in</button>

        </form>


    </div>
</div>

</body>
</html>
