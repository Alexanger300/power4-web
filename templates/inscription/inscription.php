<!DOCTYPE html>
<html lang="fr"></html>
<head>
  <meta charset="UTF-8">
  <title>Puissance 4</title>
  <link rel="stylesheet" href="../../assets/style/style.css">
  <div id="login-title">Puissance 4 - Inscription</div>
</head> 
<body class="inscription-page">
  <div class="login-container">
    <form action="/ProjetHangMan/power4-web/src/check/check.php" method="POST">
      <label for="username">Nom d'utilisateur :</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Adresse email :</label>
      <input type="text" id="email" name="email" required>

      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" name ="ok">S'inscrire</button>

      <address>Déjà un compte ? <a href="/ProjetHangMan/power4-web/templates/login/login.php">Connectez-vous ici</a></address>
    </form>
  </div>
</body>
</html>