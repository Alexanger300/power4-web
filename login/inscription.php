<!DOCTYPE html>
<html lang="fr"></html>
<head>
  <meta charset="UTF-8">
  <title>Puissance 4</title>
  <link rel="stylesheet" href="../css/style.css">
  <div id="login-title">Puissance 4 - Inscription</div>
</head> 
<body>
  <div class="login-container">
    <form action="traitement.php" method="POST">
      <label for="username">Nom d'utilisateur :</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Adresse email :</label>
      <input type="text" id="email" name="email" required>

      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>

      <button type="submit" name ="ok">S'inscrire</button>

      <address>Déjà un compte ? <a href="login.php">Connectez-vous ici</a></address>
      <button class="home-button" type="button" onclick="window.location.href='../home_page/home_page.html'">Accueil</button>
    </form>
  </div>
</body>
</html>