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
        <?php if ($rep): ?>
            <p class="profile-info"><strong>Nom d'utilisateur:</strong><?php echo htmlspecialchars($rep['pseudo']); ?></p>
            <p class="profile-info"><strong>Email:</strong><?php echo htmlspecialchars($rep['email']); ?></p>
            <p class="profile-info"><strong>Date de création:</strong><?php echo htmlspecialchars($rep['date']); ?></p>

            <button class="menu-button" onclick="window.location.href='../home_page/home_page.html'">Accueil</button>

        <?php else: ?>
            <p>Utilisateur non trouvé ou non connecté.</p>
        <?php endif; ?>
    </div>
</body>
</html>
