<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/home.css">
    <script src="/beroeps/Modellenbureau/Script/menu.js" defer></script>
    <script>
        let slideIndex = 1;
        
        function showSlide(n) {
            const slides = document.getElementsByClassName("slide");
            const dots = document.getElementsByClassName("dot");
            
            if (n > slides.length) { slideIndex = 1; }
            if (n < 1) { slideIndex = slides.length; }
            
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            
            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }
            
            if (slides[slideIndex - 1]) {
                slides[slideIndex - 1].classList.add("active");
            }
            if (dots[slideIndex - 1]) {
                dots[slideIndex - 1].classList.add("active");
            }
        }
        
        function changeSlide(n) {
            showSlide(slideIndex += n);
        }
        
        function currentSlide(n) {
            showSlide(slideIndex = n);
        }
        
        // Auto-advance slideshow elke 5 seconden
        setInterval(function() {
            changeSlide(1);
        }, 5000);
        
        // Initialiseer slideshow bij page load
        document.addEventListener('DOMContentLoaded', function() {
            showSlide(slideIndex);
        });
    </script>
</head>
<body>
<header>
    <nav class="nav">
        <!-- Desktop links -->
        <div class="nav-left">
            <a href="/beroeps/Modellenbureau/Pages/home.php">Home</a>
            <a href="/beroeps/Modellenbureau/Pages/inschrijf.php">Inschrijven</a>
            <a href="/beroeps/Modellenbureau/Pages/modellen-overzicht.php">Modellen zoeken</a>
        </div>

        <?php
        // Eerste letter van de naam voor in de profielcirkel
        $initial = strtoupper($user['naam'][0] ?? 'P');
        ?>

        <!-- Desktop rechts -->
        <div class="nav-right">
            <a href="/beroeps/Modellenbureau/Pages/profiel_bewerken.php" style="text-decoration: none;">
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
            <a href="/beroeps/Modellenbureau/Pages/profiel_bewerken.php" style="text-decoration: none;">
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
        <a href="/beroeps/Modellenbureau/Pages/home.php">Home</a>
        <a href="/beroeps/Modellenbureau/Pages/inschrijf.php">Inschrijven</a>
        <a href="/beroeps/Modellenbureau/Pages/modellen-overzicht.php">Modellen zoeken</a>
    </div>
</header>








<section class="hero">
    <div class="hero-image">
        <div class="hero-text">
            <!-- Optional: Add text or button here if needed -->
        </div>
    </div>
</section>

<section class="cards-section">
    <div class="cards-container">
        <div class="card">
            <img src="/beroeps/Modellenbureau/IMG/account-icoon.png" alt="Model 1" class="card-img">
            <h3 class="card-title">Model worden</h3>
            <p class="card-text">Schrijf je in als model en maak je profiel aan. Studenten en docenten kunnen je vinden voor fotografie-opdrachten..</p>
        </div>
        <div class="card">
            <img src="/beroeps/Modellenbureau/IMG/camera-icoon.png" alt="Model 2" class="card-img">
            <h3 class="card-title">Fotografie-student</h3>
            <p class="card-text">Als student fotografie kun je modellen zoeken die passen bij jouw opdracht of creatieve visie.</p>
        </div>
        <div class="card">
            <img src="/beroeps/Modellenbureau/IMG/beveiliging-icoon.png" alt="Model 3" class="card-img">
            <h3 class="card-title">Docent</h3>
            <p class="card-text">Beheer modellen en projecten, keur profielen goed en help studenten bij het vinden van de juiste match.</p>
        </div>
    </div>
</section>

<section class="long-cards-section">
    <h2 class="section-title">Waarom dit platform?</h2>
    <div class="long-cards-container">
        <div class="long-card">
            <img src="/beroeps/Modellenbureau/IMG/vinkje.png" alt="Service 1" class="long-card-img">
            <div class="long-card-text">
                <h3>Veilige leeromgeving</h3>
                <p>Een platform exclusief voor GLR-studenten waar modellen en fotografen elkaar kunnen vinden in een beschermde omgeving.</p>
            </div>
        </div>
        <div class="long-card">
            <img src="/beroeps/Modellenbureau/IMG/vinkje.png" alt="Service 2" class="long-card-img">
            <div class="long-card-text">
                <h3>Praktijkervaring</h3>
                <p>Modellen doen waardevolle ervaring op terwijl fotografiestudenten met diverse modellen kunnen werken.</p>
            </div>
        </div>
        <div class="long-card">
            <img src="/beroeps/Modellenbureau/IMG/vinkje.png" alt="Service 3" class="long-card-img">
            <div class="long-card-text">
                <h3>Portfoliobuilding</h3>
                <p>Zowel modellen als fotografen bouwen aan hun portfolio met professionele shoots en samenwerkingen.</p>
            </div>
        </div>
        <div class="long-card">
            <img src="/beroeps/Modellenbureau/IMG/vinkje.png" alt="Service 4" class="long-card-img">
            <div class="long-card-text">
                <h3>Docentbegeleiding</h3>
                <p>Docenten kunnen het proces begeleiden en zorgen voor kwalitatieve matches tussen modellen en fotografen.</p>
            </div>
        </div>
    </div>
</section>

<section class="featured-models-section">
    <h2 class="section-title">Uitgelichte modellen</h2>
    
    <?php if (!empty($featuredModels)): ?>
        <div class="models-slideshow">
            <div class="slideshow-container">
                <?php foreach ($featuredModels as $index => $model): ?>
                    <?php
                    // Foto pad bepalen
                    $fotoRel = $model['Foto'] ?? '';
                    if (!empty($fotoRel) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/beroeps/Modellenbureau/Pages/' . $fotoRel)) {
                        $fotoUrl = '/beroeps/Modellenbureau/Pages/' . htmlspecialchars($fotoRel);
                    } else {
                        $fotoUrl = $uploadsPath . 'placeholder.jpg';
                    }
                    // Gebruik voornaam als die er is, anders beschrijving
                    $kaartNaam = $model['voornaam'] ?? ($model['Beschrijving'] ?? 'Model');
                    ?>
                    <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                        <div class="model-tile">
                            <div class="model-image">
                                <img src="<?= $fotoUrl ?>" alt="Model foto">
                            </div>
                            <div class="model-name">
                                <?= htmlspecialchars($kaartNaam) ?>
                            </div>
                            <a class="model-btn" href="/beroeps/Modellenbureau/Pages/modellen-detail.php?id=<?= (int)$model['Profiel_ID'] ?>">
                                Bekijk profiel
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Navigatie pijlen -->
            <button class="slideshow-btn prev" onclick="changeSlide(-1)">❮</button>
            <button class="slideshow-btn next" onclick="changeSlide(1)">❯</button>
            
            <!-- Dots indicator -->
            <div class="slideshow-dots">
                <?php foreach ($featuredModels as $index => $model): ?>
                    <span class="dot <?= $index === 0 ? 'active' : '' ?>" onclick="currentSlide(<?= $index + 1 ?>)"></span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: white; padding: 20px;">Geen modellen beschikbaar.</p>
    <?php endif; ?>
</section>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Over Ons</h3>
            <p>Wij verbinden modellen, studenten en docenten voor creatieve projecten en opdrachten.</p>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Email: info@modellenbureau.nl</p>
            <p>Telefoon: +31 123 456 789</p>
        </div>
        <div class="footer-section">
            <h3>Links</h3>
            <a href="#">Home</a><br>
            <a href="#">Inschrijven</a><br>
            <a href="#">Modellen zoeken</a>
        </div>
        <div class="footer-section">
            <h3>Volg Ons</h3>
            <a href="#">Facebook</a><br>
            <a href="#">Instagram</a><br>
            <a href="#">LinkedIn</a>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2026 Modellenbureau. Alle rechten voorbehouden.
    </div>
</footer>

</body>
</html>