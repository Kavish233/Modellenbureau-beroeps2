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

        <form action="#" method="post">
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
            <a href="register.php">Registreer hier</a>
        </p>
    </div>
</div>
</body>
</html>