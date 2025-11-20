<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site-web";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Vérifier que les cookies existent
$email = $_COOKIE['email'] ?? '';
$token = $_COOKIE['token'] ?? '';

// Requête sécurisée pour récupérer l'utilisateur
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
    <link rel="stylesheet" href="../../assets/style/style.css">
    <style>
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="profile-page">

<?php if ($rep): ?>
    <p class="profile-title">Profil de l'utilisateur</p>
    <div class="profile-container">
        <div class="profile-left">
            <p class="profile-info"><strong>Nom d'utilisateur:</strong> <?php echo htmlspecialchars($rep['pseudo']); ?></p>
            <p class="profile-info"><strong>Email:</strong> <?php echo htmlspecialchars($rep['email']); ?></p>
            <p class="profile-info"><strong>Date de création:</strong> <?php echo htmlspecialchars($rep['date']); ?></p>
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
