<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/inlog.css">
    <link rel="stylesheet" href="/beroeps/Modellenbureau/CSS/main.css">
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <h2>Inloggen</h2>

        <?php if (!empty($resultaat)): ?>
            <?php 
            $bgColor = $isSuccess ? '#e8f5e9' : '#ffebee';
            $textColor = $isSuccess ? '#2e7d32' : '#c62828';
            $borderColor = $isSuccess ? '#66bb6a' : '#ef5350';
            ?>
            <div style="background-color: <?= $bgColor ?>; color: <?= $textColor ?>; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid <?= $borderColor ?>;">
                <?= htmlspecialchars($resultaat) ?>
            </div>
        <?php endif; ?>

        <form action="inlog.php" method="post">
            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" placeholder="Voer je e-mail in" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" placeholder="Voer je wachtwoord in" required>
            </div>

            <button type="submit" class="login-btn">LOG IN</button>
        </form>

        <p class="register-link">
            Nog geen account?
            <a href="registreren.php">Registreer hier</a>
        </p>
    </div>
</div>
</body>
</html>