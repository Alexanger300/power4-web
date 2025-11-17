<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site-web"; // Nom de la base de données
// Connexion à la base
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Vérifier que les cookies existent
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '';

// Requête sécurisée
if ($email && $token) {
    $req = $db->prepare("SELECT * FROM utilisateurs WHERE email = :email AND token = :token");
    $req->execute([
        ':email' => $email,
        ':token' => $token
    ]);
    $rep = $req->fetch(PDO::FETCH_ASSOC);
} else {
    $rep = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Puissance 4</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class = "profile-page">
    <p class="profile-title">Profil de l'utilisateur</p>
</form>
    <div class="profile-container">
        <div class="profile-left">
        <?php if ($rep): ?>
            <p class="profile-info"><strong>Nom d'utilisateur:</strong><?php echo htmlspecialchars($rep['pseudo']); ?></p>
            <p class="profile-info"><strong>Email:</strong><?php echo htmlspecialchars($rep['email']); ?></p>
            <p class="profile-info"><strong>Date de création:</strong><?php echo htmlspecialchars($rep['date']); ?></p>
    </div>
    <div class="profile-right">
        <p class="profile-info"><strong>Photo de profil:</strong></p>
        <!-- Afficher la photo de profil ou une image par défaut -->
<?php

$email = $_COOKIE['email'] ?? null;
if ($email) {
    $stmt = $db->prepare("SELECT photo_profil FROM utilisateurs WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($user['photo_profil'])) {
        echo "<img src='{$user['photo_profil']}' alt='Photo de profil' style='width:120px; height:120px; border-radius:50%; object-fit:cover;'>";
    } else {
        echo "<img src='../images/default.png' alt='Photo par défaut' style='width:120px; height:120px; border-radius:50%; object-fit:cover;'>";
    }
}
?>

<form action="profile.php" method="POST" enctype="multipart/form-data">
  <label for="photo">Uploader une photo de profil :</label>
  <input type="file" name="photo" id="photo" accept="image/*">
  <button type="submit" name="upload">Envoyer</button>
</form>
        </div>
        </div>
        <div>
            <button class="menu-button" onclick="window.location.href='../home_page/home_page.html'">Accueil</button>
</div>
        <?php else: ?>
            <p>Vous n'êtes pas connecté.</p>
            <button class="menu-button" onclick="window.location.href='../login/login.php'">Se connecter</button>
        <?php endif; ?>
   
</body>
</html>

