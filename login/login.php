<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Puissance 4</title>
  <link rel="stylesheet" href="../css/style.css">
  <div id="login-title">Puissance 4 - Connexion</div>
</head>
<body class="login-page">
  <div class="login-container">
    <form action="/login" method="POST">
      <label for="username">Adresse email :</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>
      
      <button type="ok">Se connecter</button>
      
    <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a></p>
    <button class="home-button" type="button" onclick="window.location.href='../home_page/home_page.html'">Accueil</button>
    </form>
  </div>
</body>
</html>